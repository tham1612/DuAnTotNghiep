<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

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
        $accessToken = $this->accessToken;
        if ($accessToken) {
            $client->setAccessToken($accessToken);

            if ($client->isAccessTokenExpired()) {
                // Làm mới token nếu hết hạn
                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
                // Cập nhật token mới vào database
                User::query()
                    ->where('id', $this->userOrTaskId['user_id'])
                    ->update([
                        'access_token' => $client->getAccessToken()
                    ]);
            }

            $service = new \Google_Service_Calendar($client);

            $event = $service->events->get('primary', $this->eventId); // Lấy sự kiện cần cập nhật

            $event->setSummary(isset($this->eventData['summary']) ? $this->eventData['summary'] : '');
            $event->setDescription(isset($this->eventData['description']) ? $this->eventData['description'] : '');

            // Tạo đối tượng Google_Service_Calendar_EventDateTime cho thời gian bắt đầu
            if (isset($this->eventData['start']['dateTime']) || isset($this->eventData['start']['dateTime'])) {
                $startDateTime = new \Google_Service_Calendar_EventDateTime();
                $startDateTime->setDateTime($this->eventData['start']['dateTime']); // Đặt thời gian bắt đầu
                $startDateTime->setTimeZone($this->eventData['start']['timeZone']); // Đặt múi giờ (nếu cần)


                $endDateTime = new \Google_Service_Calendar_EventDateTime();
                $endDateTime->setDateTime($this->eventData['end']['dateTime']); // Đặt thời gian kết thúc
                $endDateTime->setTimeZone($this->eventData['end']['timeZone']); // Đặt múi giờ (nếu cần)


                $event->setStart($startDateTime);
                $event->setEnd($endDateTime);
            }

            Log::debug($this->attendees);
            if (!empty($this->attendees)) {
//                Log::debug($this->attendees);
                // Giả sử $this->attendees chỉ chứa một người tham gia mới mỗi lần
                $newAttendee = $this->attendees[0]; // Lấy người tham gia mới
                $email = $newAttendee['email'] ?? null; // Lấy email của người mới

                // Lấy danh sách người tham gia hiện tại từ sự kiện (nếu có) hoặc khởi tạo mảng trống
                $currentAttendees = $event->getAttendees() ?? [];

                // Tạo mảng kết hợp chứa email duy nhất làm key, giá trị là thông tin người tham gia
                $uniqueAttendees = [];

                // Đưa tất cả người tham gia hiện tại vào mảng $uniqueAttendees với email làm key
                foreach ($currentAttendees as $attendee) {
                    if (isset($attendee['email'])) {
                        $uniqueAttendees[$attendee['email']] = $attendee;
                    }
                }

                // Kiểm tra nếu email của người tham gia mới đã có trong danh sách
                if ($email && array_key_exists($email, $uniqueAttendees)) {
                    // Xóa người tham gia có email trùng lặp khỏi danh sách
                    unset($uniqueAttendees[$email]);
                    Log::debug("Xóa người tham gia trùng lặp: {$email}");
                } else {
                    // Thêm người tham gia mới vào danh sách nếu không có trùng lặp
                    if ($email) {
                        $uniqueAttendees[$email] = $newAttendee;
                        Log::debug("Thêm người tham gia mới: {$newAttendee['email']}");
                    }
                }

                // Cập nhật danh sách người tham gia không trùng lặp cho sự kiện
                $event->setAttendees(array_values($uniqueAttendees));
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
