<?php

namespace App\Http\Controllers;

use App\Jobs\CreateGoogleApiClientEvent;
use App\Jobs\DeleteGoogleApiClientEvent;
use App\Jobs\UpdateGoogleApiClientEvent;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Google\Service\Calendar\Calendar;
use Google_Client;
use Google_Service_Calendar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
        if (isset($data['start']) || isset($data['end'])) {
            $startDate = empty($data['start']) ? $data['end'] : $data['start'];
            $endDate = $data['end'];
        } else {
            $startDate = $data['start_date'] == 'Invalid date' ? $data['end_date'] : $data['start_date'];
            $endDate = $data['end_date'];
        }

        $description = isset($data['description']) ? $data['description'] : '';
        $summary = isset($data['text']) ? $data['text'] : '';


        $accessToken = User::query()
            ->where('id', auth()->id())
            ->value('access_token');

        $eventData = [
            'summary' => $summary,
            'start' => [
                'dateTime' => Carbon::parse($startDate, 'Asia/Ho_Chi_Minh')->toIso8601String(),
            ],
            'end' => [
                'dateTime' => Carbon::parse($endDate, 'Asia/Ho_Chi_Minh')->toIso8601String(),
            ],
//            'description' => $description,
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
        if (isset($data['user_id'])) {
            $attendees[] = ['email' => User::query()->where('id', $data['user_id'])->value('email')];
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

        $attendees = $eventData = [];
        if (!isset($data['id_google_calendar'])) {
            $data['id_google_calendar'] = Task::query()->findOrFail(isset($data['id']) ? $data['id'] : $data['task_id'])->value('id_google_calendar');
        }
        $startDate = empty($data['start_date']) ? $data['end_date'] : $data['start_date'];
        $endDate = $data['end_date'];

        $accessToken = User::query()
            ->where('id', auth()->id())
            ->value('access_token');
        $eventId = $data['id_google_calendar'];
        $eventData = [
            'summary' => $data['text'],
            'description' => $data['description'],
            'start' => [
                'dateTime' => Carbon::parse($startDate, 'Asia/Ho_Chi_Minh')->toIso8601String(),
                'timeZone' => 'Asia/Ho_Chi_Minh',
            ],
            'end' => [
                'dateTime' => Carbon::parse($endDate, 'Asia/Ho_Chi_Minh')->toIso8601String(),
                'timeZone' => 'Asia/Ho_Chi_Minh',
            ],
            'reminders' => [
                'useDefault' => false,
                'overrides' => [
                    ['method' => 'email', 'minutes' => 24 * 60], // Gửi email nhắc nhở trước 24 giờ
                    ['method' => 'popup', 'minutes' => 10],      // Hiện popup nhắc nhở trước 10 phút
                ],
            ],
        ];

        // Thêm người tham gia (attendees)
        if (isset($data['user_id'])) {
            $attendees[] = ['email' => User::query()->where('id', $data['user_id'])->value('email')];
        }

        $userOrTaskId = [
            'user_id' => Auth::id(),
            'task_id' => isset($data['id']) ? $data['id'] : $data['task_id'],
        ];

       UpdateGoogleApiClientEvent::dispatch($eventData, $attendees, $eventId, $accessToken, $userOrTaskId);

        // $client = $this->getClient();
        // $service = new \Google_Service_Calendar($client);
        // $client->setAccessToken($accessToken);
        // $eventsList = $service->events->listEvents('primary');
        // $events = $eventsList->getItems();
        // $eventExists = false;
        // foreach ($events as $event) {
        //     if ($event->getId() === $eventId) {
        //         Log::debug($event->getId());
        //         Log::debug($eventId);
        //         $eventExists = true;
        //     }
        // }
//        dd($eventExists);
        // if ($eventExists) {
        //     UpdateGoogleApiClientEvent::dispatch($eventData, $attendees, $eventId, $accessToken, $userOrTaskId);
        // } else {
        //     CreateGoogleApiClientEvent::dispatch($eventData, $attendees, $accessToken, $userOrTaskId);
        // }


    }


    public function deleteEvent(string $id)
    {
        $accessToken = User::query()
            ->where('id', auth()->id())
            ->value('access_token');
        $userOrTaskId = [
            'user_id' => Auth::id(),
        ];
        $client = $this->getClient();
        $service = new \Google_Service_Calendar($client);
        $client->setAccessToken($accessToken);
        $eventsList = $service->events->listEvents('primary');
        $events = $eventsList->getItems();
        $eventExists = false;
        foreach ($events as $event) {
            if ($event->getId() === $id) {
                Log::debug($event->getId());
                Log::debug($id);
                $eventExists = true;
            }
        }

        if ($eventExists) {
            DeleteGoogleApiClientEvent::dispatch($accessToken, $id, $userOrTaskId);
        }

    }


}
