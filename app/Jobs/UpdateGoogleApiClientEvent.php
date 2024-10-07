<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateGoogleApiClientEvent implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $eventData;
    protected $attendees;
    protected $eventId;
    protected $userOrTaskId;
    protected $accessToken;

    /**
     * Create a new job instance.
     */
    public function __construct($eventData, $attendees, $eventId, $accessToken, $userOrTaskId)
    {
        $this->eventData = $eventData;
        $this->attendees = $attendees;
        $this->eventId = $eventId;
        $this->accessToken = $accessToken;
        $this->userOrTaskId = $userOrTaskId;

    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $client = $this->getClient();
//        $accessToken = User::query()->where('id', auth()->id())->value('remember_token');
        $accessToken = $this->accessToken;
        if ($accessToken) {
            $client->setAccessToken($accessToken);

            if ($client->isAccessTokenExpired()) {
                // Làm mới token nếu hết hạn
                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
                // Cập nhật token mới vào database
//                session(['google_access_token' => $client->getAccessToken()]);
                User::query()
                    ->where('id', $this->userOrTaskId['user_id'])
                    ->update([
                        'access_token' => $client->getAccessToken()
                    ]);
            }

            $service = new \Google_Service_Calendar($client);

            $event = $service->events->get('primary', $this->eventId); // Lấy sự kiện cần cập nhật
            // Tạo đối tượng Google_Service_Calendar_EventDateTime cho thời gian bắt đầu
            $startDateTime = new \Google_Service_Calendar_EventDateTime();
            $startDateTime->setDateTime($this->eventData['start']['dateTime']); // Đặt thời gian bắt đầu
            $startDateTime->setTimeZone($this->eventData['start']['timeZone']); // Đặt múi giờ (nếu cần)


            $endDateTime = new \Google_Service_Calendar_EventDateTime();
            $endDateTime->setDateTime($this->eventData['end']['dateTime']); // Đặt thời gian kết thúc
            $endDateTime->setTimeZone($this->eventData['end']['timeZone']); // Đặt múi giờ (nếu cần)


            $event->setStart($startDateTime);
            $event->setEnd($endDateTime);

            if (!empty($this->attendees)) {
                $event->setAttendees($this->attendees); // Thêm người tham gia (attendees)
            }

            $calendarId = 'primary'; // Hoặc sử dụng calendarId khác nếu cần
            $service->events->update($calendarId, $this->eventId, $event);

        }
    }

    public function getClient()
    {
        $client = new \Google_Client();
        $client->setAuthConfig(storage_path('app/google-calendar/credentials.json'));
        $client->addScope(\Google_Service_Calendar::CALENDAR);
        $client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));
        $client->setAccessType('offline'); // Lấy refresh token để dùng lâu dài
        $client->setPrompt('consent');

        return $client;
    }
}
