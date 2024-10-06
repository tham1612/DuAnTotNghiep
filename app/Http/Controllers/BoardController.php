<?php

namespace App\Http\Controllers;

use App\Events\UserInvitedToBoard;
use App\Http\Requests\StoreBoardRequest;
use App\Models\Board;
use App\Models\BoardMember;
use App\Models\Task;
use App\Models\User;
use App\Models\WorkspaceMember;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Activitylog\Models\Activity;

// use function Laravel\Prompts\select;

class BoardController extends Controller
{
    protected $googleApiClient;

    public function __construct(GoogleApiClientController $googleApiClient)
    {
        $this->googleApiClient = $googleApiClient;
    }

    /**
     * Display a listing of the resource.
     */
    const PATH_UPLOAD = 'board.';
    public function index($workspaceId)
    {
        $userId = Auth::id();


        // Lấy tất cả các bảng trong workspace mà người dùng là người tạo hoặc là thành viên
        // Lấy tất cả các bảng trong workspace mà người dùng là người tạo hoặc là thành viên
        $boards = Board::where('workspace_id', $workspaceId)
            ->where(function ($query) use ($userId) {
                $query->where('created_at', $userId) // Ensure 'created_by' is the correct field
                ->orWhereHas('boardMembers', function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                });
            })

            ->with(['workspace', 'boardMembers'])
            ->get()
            ->map(function ($board) use ($userId) {
                $board->total_members = $board->boardMembers->count();
                $board->is_star = $board->boardMembers->contains(function ($member) use ($userId) {
                    return $member->user_id == $userId && $member->is_star == 1;
                });
                $board->follow = $board->boardMembers->contains(function ($member) use ($userId) {
                    return $member->user_id == $userId && $member->follow == 1;
                });

                return $board;
            });

        // Lọc danh sách các bảng mà user đã đánh dấu sao
        $board_star = $boards->filter(function ($board) use ($userId) {
            return $board->boardMembers->contains(function ($member) use ($userId) {
                return $member->user_id == $userId && $member->is_star == 1;
            });
        });
        // dd($workspaceId);


        // Trả về view với danh sách bảng, bảng đã đánh dấu sao và workspaceId
        return view('homes.dashboard', compact('boards', 'board_star'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('b.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $data = $request->except(['image', 'link_invite']);
        if ($request->hasFile('image')) {
            $data['image'] = Storage::put(self::PATH_UPLOAD, $request->file('image'));
        }
        $uuid = Str::uuid();
        $token = Str::random(40);
        $data['link_invite'] = url("taskflow/invite/b/{$uuid}/{$token}");
        try {
            DB::beginTransaction();
            $board = Board::query()->create($data);
            BoardMember::query()->create([
                'user_id' => auth()->id(),
                'board_id' => $board->id,
                'authorize' => 'Owner',
                'invite' => now(),
            ]);
            // ghi lại hoạt động của bảng


            activity('Người dùng đã tạo bảng ')
                ->performedOn($board) // đối tượng liên quan là bảng vừa tạo
                ->causedBy(Auth::user()) // ai là người thực hiện hoạt động này
                ->log('Đã tạo bảng mới: ' . $board->name); // Nội dung ghi log
            DB::commit();
            return redirect()->route('home');
        } catch (\Exception $exception) {
            DB::rollBack();
            dd($exception->getMessage());
            return back()->with('error', 'Error: ' . $exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $board = Board::query()->findOrFail($id);

        session(['board' => $board]);

        $viewType = \request('viewType', 'board');

        // https://laravel.com/docs/10.x/eloquent-relationships#lazy-eager-loading
        // https://laravel.com/docs/10.x/eloquent-relationships#nested-eager-loading
        $board->load([
            'users',
            // 'members',
            'catalogs',
            'catalogs.tasks',
            'catalogs.tasks.catalog:id,name',
            'catalogs.tasks' => function ($query) {
                $query->orderBy('position', 'asc');
            },

            'catalogs.tasks.members'
        ]);

        $boardMembers = $board->users->unique('id');
        // Lấy danh sách catalogs
        $catalogs = $board->catalogs;
        /*
         * pluck('tasks'): Lấy tất cả các tasks từ các catalogs, nó sẽ trả về một collection mà mỗi phần tử là một danh sách các tasks.
         * flatten(): Dùng để chuyển đổi một collection lồng vào nhau thành một collection phẳng, chứa tất cả các tasks.
         * */



        $boardId = $board->id; // ID của bảng mà bạn muốn xem hoạt động
        $activities = Activity::where('properties->board_id', $boardId)->get();

        //  dd($activities);
        $board = Board::find($boardId); // Truy xuất thông tin của board từ bảng boards
        $boardName = $board->name; // Lấy tên của board
        $tasks = $catalogs->pluck('tasks')->flatten()->sortBy('position');


        $tasks = $catalogs->pluck('tasks')->flatten()->sortBy('position');

        //
        // dd($this->googleApiClient->getClient());
        $client = $this->googleApiClient->getClient();

        $accessToken = session('google_access_token');
        //        dd($accessToken);
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

        //lấy thành viên trong bảng
        $board_m = BoardMember::query()
            ->join('users', 'users.id', 'board_members.user_id')
            ->select('users.name as name', 'users.image as image')
            ->where('board_members.is_accept_invite', NULL)
            ->whereNot('board_members.authorize', 'Owner')
            ->where('board_members.board_id', $boardId)
            ->get();
        //lấy người gửi lời mời vào nhóm
        $board_m_invite = BoardMember::query()
            ->join('users', 'users.id', 'board_members.user_id')
            ->select('users.name as name', 'users.image as image')
            ->where('board_members.is_accept_invite', 1)
            ->where('board_members.board_id', $boardId)
            ->latest('board_members.id')
            ->get();
        $board_m_viewer = BoardMember::query()
            ->join('users', 'users.id', 'board_members.user_id')
            ->select('users.name as name', 'users.image as image')
            ->where('board_members.is_accept_invite', NULL)
            ->where('board_members.authorize', "Viewer")
            ->where('board_members.board_id', $boardId)
            ->latest('board_members.id')
            ->get();
        $board_owner = BoardMember::query()
            ->join('users', 'users.id', 'board_members.user_id')
            ->select('users.name as name', 'users.image as image', 'users.id as user_id')
            ->where('board_members.is_accept_invite', NULL)
            ->where('board_members.authorize', "Owner")
            ->where('board_members.board_id', $boardId)
            ->first();
        $data = [
            'board_m' => $board_m,
            'board_m_invite' => $board_m_invite,
            'board_m_viewer' => $board_m_viewer,
            'board_owner' => $board_owner,
            'user_id' => Auth::id()
        ];

        // dd($data);
        //        $taskMembers=$tasks->pluck('members')->flatten();
        return match ($viewType) {
            'dashboard' => view('homes.dashboard_board', compact('board', 'catalogs', 'tasks', 'activities', 'data')),
            'list' => view('lists.index', compact('board', 'catalogs', 'tasks', 'activities', 'data')),
            'gantt' => view('ganttCharts.index', compact('board', 'catalogs', 'tasks', 'activities', 'data')),
            'table' => view('tables.index', compact('board', 'catalogs', 'tasks', 'activities', 'data')),
            'calendar' => view('calendars.index', compact('listEvent', 'board', 'catalogs', 'tasks', 'activities', 'data')),
            default => view('boards.index', compact('board', 'catalogs', 'activities', 'data')),

        };
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->except(['_token', '_method']);
        Board::query()
            ->where('id', $id)
            ->update($data);
        return response()->json([
            'message' => 'Board đã được cập nhật thành công',
            'success' => true
        ]);

    }

    public function updateBoardMember(Request $request, string $id)
    {
        $data = $request->only(['user_id', 'board_id']);


        $boardMember = BoardMember::where('board_id', $data['board_id'])
            ->where('user_id', $data['user_id'])
            ->first();

        if ($boardMember) {
            $newIsStar = $boardMember->is_star == 1 ? 0 : 1;
            $boardMember->update(['is_star' => $newIsStar]);

            return response()->json([
                'message' => 'Người dùng cập nhật dấu sao bảng thành công',
                'success' => true
            ]);
        }

    }
    public function updateBoardMember2(Request $request, string $id)
    {
        $data = $request->only(['user_id', 'board_id']);


        $boardMember = BoardMember::where('board_id', $data['board_id'])
            ->where('user_id', $data['user_id'])
            ->first();

        if ($boardMember) {
            $newFollow = $boardMember->follow == 1 ? 0 : 1;
            $boardMember->update(['follow' => $newFollow]);

            return response()->json([
                'follow' => $boardMember->follow, // Trả về trạng thái follow mới
            ]);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function inviteUserBoard(Request $request)
    {
        $boardId = $request->id;
//        dd($request->all(), $boardId);
        $board = Board::query()
            ->where('id', $boardId)
            ->firstOrFail();

        $request->validate([
            'email' => 'required|email',
        ]);

        $email = $request->input('email');
        $linkInvite = $board->link_invite;
        $boardName = $board->name;
        $authorize = $request->input('authorize');
        event(new UserInvitedToBoard($boardName, $email, $linkInvite, $authorize));
        return back()->with('success', 'Đã gửi email thêm thành viên !!!');
    }
  
