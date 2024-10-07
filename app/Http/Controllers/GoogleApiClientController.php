<?php

namespace App\Http\Controllers;

use App\Jobs\CreateGoogleApiClientEvent;
use App\Jobs\UpdateGoogleApiClientEvent;
use App\Models\User;
use Carbon\Carbon;
use Google_Client;
use Google_Service_Calendar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GoogleApiClientController extends Controller
{
    public function getClient()
    {
        $client = new Google_Client();
        $client->setAuthConfig(storage_path('app/google-calendar/credentials.json'));
        $client->addScope(Google_Service_Calendar::CALENDAR);
        $client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));
        $client->setAccessType('offline'); // Lấy refresh token để dùng lâu dài
        $client->setPrompt('consent');

        return $client;
    }

    public function redirectToGoogle()
    {
        $client = $this->getClient();
        $authUrl = $client->createAuthUrl();
        return redirect()->to($authUrl);
    }

    public function handleGoogleCallback(Request $request)
    {

        $client = $this->getClient();
        $client->authenticate($request->get('code'));
        $accessToken = $client->getAccessToken();
        session(['google_access_token' => $accessToken]);
        // Lưu access token cho người dùng (thường lưu vào DB hoặc session)
//        dd($client->getAccessToken(), auth()->id());
        User::query()
            ->where('id', auth()->id())
            ->update([
                'access_token' => $client->getAccessToken()
            ]);

        return redirect()->route('home');
    }

    public function createEvent($data)
    {
//        dd($data);
        $startDate = $data['start_date'] == 'Invalid date' ? $data['end_date'] : $data['start_date'];
        $endDate = $data['end_date'];
        $description = isset($data['description']) ? $data['description'] : '';

//        $accessToken = session('google_access_token');
        $accessToken = User::query()
            ->where('id', auth()->id())
            ->value('access_token');

        $eventData = [
            'summary' => $data['text'],
            'start' => [
                'dateTime' => Carbon::parse($startDate, 'Asia/Ho_Chi_Minh')->toIso8601String(),
            ],
            'end' => [
                'dateTime' => Carbon::parse($endDate, 'Asia/Ho_Chi_Minh')->toIso8601String(),
            ],
            'description' => $description,
            'reminders' => [
                'useDefault' => false,
                'overrides' => [
                    ['method' => 'email', 'minutes' => 24 * 60], // Gửi email nhắc nhở trước 24 giờ
                    ['method' => 'popup', 'minutes' => 10],      // Hiện popup nhắc nhở trước 10 phút
                ],
            ],
        ];

        // Thêm người tham gia (attendees)
        $attendees = [];
        if (!empty($data['attendees'])) {
            // Tách email nếu có nhiều
            $emails = explode(',', $data['attendees']);
            foreach ($emails as $email) {
                $attendees[] = ['email' => trim($email)];
            }
        }
        $userOrTaskId = [
            'user_id' => Auth::id(),
            'task_id' => $data['id'],
        ];
//        dd($eventData);
        // chuyen vao trong queue
        CreateGoogleApiClientEvent::dispatch($eventData, $attendees, $accessToken, $userOrTaskId);
    }

    public function updateEvent($data)
    {
//        dd($data);
        $attendees = [];
//        $accessToken = session('google_access_token');
        $accessToken = User::query()
            ->where('id', auth()->id())
            ->value('access_token');
        $eventId = $data['id_gg_canlendar'];
        if ($data['changeDate']) {
            $eventData = [
                'start' => [
                    'dateTime' => Carbon::parse($data['start'], 'Asia/Ho_Chi_Minh')->toIso8601String(),
                    'timeZone' => 'Asia/Ho_Chi_Minh',
                ],
                'end' => [
                    'dateTime' => Carbon::parse($data['end'], 'Asia/Ho_Chi_Minh')->toIso8601String(),
                    'timeZone' => 'Asia/Ho_Chi_Minh',
                ],
            ];
        } else {
            $eventData = [
                'summary' => $data->summary,
                'start' => ['dateTime' => Carbon::parse($data->start, 'Asia/Ho_Chi_Minh')->toIso8601String()],
                'end' => ['dateTime' => Carbon::parse($data->end, 'Asia/Ho_Chi_Minh')->toIso8601String()],
                'description' => $data->description,
            ];
            // Thêm người tham gia (attendees)
            if (!empty($data->attendees)) {
                foreach ($data->attendees as $email) {
                    // Tách email nếu có nhiều
                    $emails = explode(',', $email);
                    foreach ($emails as $email) {
                        $attendees[] = ['email' => trim($email)];
                    }
                }
            }
        }
        $userOrTaskId = [
            'user_id' => Auth::id(),
            'task_id' => $data['id'],
        ];
        UpdateGoogleApiClientEvent::dispatch($eventData, $attendees, $eventId, $accessToken,$userOrTaskId);

    }


    public function deleteEvent(string $id)
    {
        $client = $this->getClient();
        //        $accessToken =  User::query()->where('user_id', auth()->id())->value('access_token');
        $accessToken = session('google_access_token');
        if ($accessToken) {
            $client->setAccessToken($accessToken);

            if ($client->isAccessTokenExpired()) {
                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
                //                 User::query()->where('user_id', auth()->id())->update([
                //                    'remember_token' => json_encode($client->getAccessToken())
                //                ]);
            }
            $service = new Google_Service_Calendar($client);

            $service->events->delete('primary', $id);
        }
        return response()->json(['msg' => 'xoa thanh cong']);
    }
}
