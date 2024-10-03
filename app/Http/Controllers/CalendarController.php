<?php

namespace App\Http\Controllers;

use App\Jobs\CreateGoogleApiClientEvent;
use App\Jobs\UpdateGoogleApiClientEvent;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    protected $googleApiClient;
    public function __construct(GoogleApiClientController $googleApiClient)
    {
        $this->googleApiClient = $googleApiClient;
    }

    public function index()
    {
        // dd($this->googleApiClient->getClient());
        $client = $this->googleApiClient->getClient();

        $accessToken = session('google_access_token');

        if ($accessToken) {
            $client->setAccessToken($accessToken);
            if ($client->isAccessTokenExpired()) {
                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());

                session(['google_access_token' => $client->getAccessToken()]);
                // Cập nhật token mới vào database
                //            User::query()
                //                ->where('id', auth()->id())
                //                ->update([
                //                    'remember_token' => json_encode($client->getAccessToken())
                //                ]);
            }

            $service = new \Google_Service_Calendar($client);

            $calendarId = 'primary'; // Lịch chính
            $optParams = [
                // 'maxResults' => 10, // Giới hạn số lượng sự kiện trả về
                'orderBy' => 'startTime',
                'singleEvents' => true, // Chỉ lấy các sự kiện đơn lẻ, không lấy các chuỗi sự kiện lặp lại
                // 'timeMin' => date('c'), // Chỉ lấy các sự kiện từ thời điểm hiện tại trở đi
            ];

            $events = $service->events->listEvents($calendarId, $optParams);
            $events = $events->getItems(); // Lấy các sự kiện trả về
            $listEvent = array();
            foreach ($events as $event) {
                $listEvent[] = [
                    'email' => $event->getCreator()->getEmail(),
                    'id_google_calendar' => $event->getId(),
                    'title' => $event->getSummary(),
                    'start' => $event->getStart()->getDateTime() ?: $event->getStart()->getDate(),
                    'end' => $event->getEnd()->getDateTime() ?: $event->getEnd()->getDate(),
                    'description' => $event->getDescription(),
                ];
            }
        }

        return view('tasks', compact('listEvent'));
    }

    public function createEvent(Request $request)
    {
        $startDate = $request->start == 'Invalid date' ? $request->end : $request->start;
        $endDate = $request->end;
        $accessToken = session('google_access_token');
        $eventData = [
            'summary' => $request->summary,
            'start' => [
                'dateTime' => Carbon::parse($startDate, 'Asia/Ho_Chi_Minh')->toIso8601String(),
            ],
            'end' => [
                'dateTime' => Carbon::parse($endDate, 'Asia/Ho_Chi_Minh')->toIso8601String(),
            ],
            'description' => $request->description,
            'reminders' => [
                'useDefault' => false,
                'overrides' => [
                    ['method' => 'email', 'minutes' => 24 * 60], // Gửi email nhắc nhở trước 24 giờ
                    ['method' => 'popup', 'minutes' => 10],      // Hiện popup nhắc nhở trước 10 phút
                ],
            ],
        ];
        //        dd($eventData, $startDate, $endDate);
        // Thêm người tham gia (attendees)
        $attendees = [];
        if (!empty($request->attendees)) {
            // Tách email nếu có nhiều
            $emails = explode(',', $request->attendees);
            foreach ($emails as $email) {
                $attendees[] = ['email' => trim($email)];
            }
        }
        // dd($eventData, $attendees, $accessToken);
        CreateGoogleApiClientEvent::dispatch($eventData, $attendees, $accessToken);

        return response()->json(['msg' => 'them thanh cong']);
    }

    public function updateEvent(Request $request, string $id)
    {

        $attendees = [];
        $accessToken = session('google_access_token');
        $eventId = $request->id_gg_canlendar;
        if ($request->changeDate) {
            $eventData = [
                'start' => [
                    'dateTime' => Carbon::parse($request->start, 'Asia/Ho_Chi_Minh')->toIso8601String(),
                    'timeZone' => 'Asia/Ho_Chi_Minh',
                ],
                'end' => [
                    'dateTime' => Carbon::parse($request->end, 'Asia/Ho_Chi_Minh')->toIso8601String(),
                    'timeZone' => 'Asia/Ho_Chi_Minh',
                ],
            ];
        } else {
            $eventData = [
                'summary' => $request->summary,
                'start' => ['dateTime' => Carbon::parse($request->start, 'Asia/Ho_Chi_Minh')->toIso8601String()],
                'end' => ['dateTime' => Carbon::parse($request->end, 'Asia/Ho_Chi_Minh')->toIso8601String()],
                'description' => $request->description,
            ];
            // Thêm người tham gia (attendees)

            if (!empty($request->attendees)) {
                foreach ($request->attendees as $email) {
                    // Tách email nếu có nhiều
                    $emails = explode(',', $email);
                    foreach ($emails as $email) {
                        $attendees[] = ['email' => trim($email)];
                    }
                }
            }
        }

        UpdateGoogleApiClientEvent::dispatch($eventData, $attendees, $eventId, $accessToken);


        return response()->json(['msg' => 'cap thanh cong']);
    }


    public function deleteEvent(string $id)
    {
        $client = $this->googleApiClient->getClient();
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
            $service = new \Google_Service_Calendar($client);

            $service->events->delete('primary', $id);
        }
        return response()->json(['msg' => 'xoa thanh cong']);
    }
}
