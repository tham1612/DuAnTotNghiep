<?php

namespace App\Http\Controllers;

use App\Enums\AuthorizeEnum;
use App\Events\UserInvitedToBoard;
use App\Http\Requests\StoreBoardRequest;
use App\Models\Board;
use App\Models\BoardMember;
use App\Models\Task;
use App\Models\TaskTag;
use App\Models\User;
use App\Models\Workspace;
use Carbon\Carbon;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Models\WorkspaceMember;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Activitylog\Models\Activity;

// use function Laravel\Prompts\select;
//const PATH_UPLOAD = 'board';
class BoardController extends Controller
{
    const PATH_UPLOAD = 'boards';
    protected $googleApiClient;

    public function __construct(GoogleApiClientController $googleApiClient)
    {
        $this->googleApiClient = $googleApiClient;
    }

    /**
     * Display a listing of the resource.
     */


    public function index($workspaceId)
    {
        $userId = Auth::id();

        // Lấy tất cả các bảng trong workspace mà người dùng là người tạo hoặc là thành viên
        $boards = Board::where('workspace_id', $workspaceId)
            ->where(function ($query) use ($userId) {
                // Sửa điều kiện này để so sánh với trường lưu thông tin người tạo, ví dụ: 'created_by'
                $query->where('created_at', $userId)
                    ->orWhereHas('boardMembers', function ($query) use ($userId) {
                        $query->where('user_id', $userId);
                    });
            })
            ->with(['workspace', 'boardMembers', 'catalogs.tasks']) // Tải các tasks liên quan
            ->get()
            ->map(function ($board) use ($userId) {
                // Tính tổng số thành viên trong bảng
                $board->total_members = $board->boardMembers->count();

                // Kiểm tra xem user có đánh dấu sao cho bảng này không
                $board->is_star = $board->boardMembers->contains(function ($member) use ($userId) {
                    return $member->user_id == $userId && $member->is_star == 1;
                });

                // Kiểm tra xem user có theo dõi bảng này không (follow = 1)
                $board->follow = $board->boardMembers->contains(function ($member) use ($userId) {
                    return $member->user_id == $userId && $member->follow == 1;
                });

                // Tính tổng số nhiệm vụ và tổng progress của các task trong bảng
                $totalTasks = $board->catalogs->pluck('tasks')->flatten()->count();
                $totalProgress = $board->catalogs->pluck('tasks')->flatten()->sum('progress');

                // Tính phần trăm tiến độ (progress)
                $board->complete = $totalTasks > 0 ? round($totalProgress / $totalTasks, 2) : 0;

                return $board;
            });

        // Lọc danh sách các bảng mà user đã đánh dấu sao
        $board_star = $boards->filter(function ($board) use ($userId) {
            return $board->boardMembers->contains(function ($member) use ($userId) {
                return $member->user_id == $userId && $member->is_star == 1;
            });
        });

        // Trả về view với danh sách bảng, bảng đã đánh dấu sao và workspaceId
        return view('homes.dashboard', compact('boards', 'board_star', 'workspaceId'));
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
                ->withProperties(['workspace_id' => $board->workspace_id]) // Lưu trữ workspace_id vào properties
                ->log('Đã tạo bảng mới: ' . $board->name); // Nội dung ghi log

            DB::commit();
            session(['msg' => 'Thêm bảng ' . $data['name'] . ' thành công!']);
            session(['action' => 'success']);
            return redirect()->route('home');
        } catch (\Exception $exception) {
            DB::rollBack();
            dd($exception->getMessage());
            return back()->with([
                'msg' => 'Error: ' . $exception->getMessage(),
                'action' => 'error'
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id)
    {

        $board = Board::query()->findOrFail($id);
        $colors = \App\Models\Color::query()->get();
        session([
            'board' => $board,
            'colors' => \App\Models\Color::query()->get(),
        ]);

        $viewType = \request('viewType', 'board');

        // https://laravel.com/docs/10.x/eloquent-relationships#lazy-eager-loading
        // https://laravel.com/docs/10.x/eloquent-relationships#nested-eager-loading
        //        $board->load([
        //            'tags',
        //            'users',
        //            'catalogs',
        //            'catalogs.tasks' => function ($query) {
        //                $query->orderBy('position', 'asc');
        //            },
        //            'catalogs.tasks.catalog:id,name',
        //            'catalogs.tasks.members',
        //            'catalogs.tasks.checkList',
        //            'catalogs.tasks.checkList.checkListItems',
        //            'catalogs.tasks.checkList.checkListItems.checkListItemMembers',
        //            'catalogs.tasks.tags',
        //            'catalogs.tasks.followMembers'
        //        ]);

        $board->load([
            'tags',
            'users',
            'catalogs' => function ($query) use ($request) {
                $query->with(['tasks' => function ($taskQuery) use ($request) {
                    $taskQuery->where(function ($subQuery) use ($request) {

                        // Điều kiện 1: Lọc thành viên
                        if ($request->has('no_member') || $request->has('it_me')) {
                            $subQuery->where(function ($query) use ($request) {
                                // Điều kiện 1: Lọc thành viên
                                if ($request->no_member) {
                                    // Không có thành viên
                                    $query->whereDoesntHave('members');
                                }
                                if ($request->it_me) {
                                    // Giao cho tôi (có thành viên là chính tôi)
                                    $query->orWhereHas('members', function ($memberQuery) {
                                        $memberQuery->where('user_id', auth()->id());
                                    });
                                }
                            });
                        }

                        // Điều kiện 2: Ngày hết hạn
                        if ($request->has('no_date') || $request->has('no_overdue') || $request->has('due_tomorrow')) {
                            $subQuery->where(function ($dateQuery) use ($request) {
                                if ($request->has('no_date')) {
                                    // Không có ngày hết hạn
                                    $dateQuery->whereNull('end_date');
                                }
                                if ($request->has('no_overdue')) {
                                    // Quá hạn
                                    $dateQuery->orWhere('end_date', '<', now());
                                }
                                if ($request->has('due_tomorrow')) {
                                    // Hết hạn vào ngày mai
                                    $dateQuery->orWhere('end_date', '=', now()->addDay());
                                }
                            });
                        }

                        // Điều kiện 3: Lọc nhãn
                        if ($request->has('no_tags') || $request->has('tags')) {
                            $subQuery->where(function ($tagQuery) use ($request) {
                                if ($request->has('no_tags')) {
                                    // Không có nhãn
                                    $tagQuery->doesntHave('tags');
                                }
                                if ($request->has('tags')) {
                                    // Lọc theo nhãn đã chọn
                                    $tagQuery->whereHas('tags', function ($tagSubQuery) use ($request) {
                                        $tagSubQuery->whereIn('tags.id', $request->input('tags'));
                                    });
                                }
                            });
                        }
                    })
                        ->orderBy('position', 'asc')
                        ->with([
                            'members',
                            'checkList',
                            'checkList.checkListItems',
                            'checkList.checkListItems.checkListItemMembers',
                            'tags',
                            'followMembers',
                            'attachments'
                        ]);
                }]);
            }
        ]);

        if ($request->ajax()) {
            $viewType = $request->viewType;
            //            $this->middleware('csrf', ['except' => ['edit']]);
        }
        $boardMemberMain = BoardMember::query()
            ->join('users', 'users.id', '=', 'board_members.user_id')
            ->select('users.name', 'users.image', 'board_members.is_accept_invite', 'board_members.authorize', 'users.id as user_id')
            ->where('board_members.board_id', $board->id)
            ->get();

        /*
         * pluck('tasks'): Lấy tất cả các tasks từ các catalogs, nó sẽ trả về một collection mà mỗi phần tử là một danh sách các tasks.
         * flatten(): Dùng để chuyển đổi một collection lồng vào nhau thành một collection phẳng, chứa tất cả các tasks.
         * */
        //        $boardId = $board->id; // ID của bảng mà bạn muốn xem hoạt động
        $activities = Activity::with('causer')
            ->where('properties->board_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();


        // Tách danh sách các thành viên chờ lời mời và các thành viên đã được mời vào
        $boardMembers = $boardMemberMain->filter(function ($member) {
            return $member->authorize !== AuthorizeEnum::Owner()->value &&
                $member->authorize !== AuthorizeEnum::Sub_Owner()->value &&
                $member->is_accept_invite === 0;
        });

        $boardMemberInvites = $boardMemberMain->filter(function ($member) {
            return $member->is_accept_invite === 1;
        });

        // Kiểm tra và cập nhật tất cả thành viên đã được mời vào workspace cùng một lần truy vấn
        $userIds = $boardMemberInvites->pluck('user_id')->toArray();
        $invitedWorkspaceMembers = WorkspaceMember::whereIn('user_id', $userIds)
            ->where('workspace_id', $board->workspace_id)
            ->get();

        // Cập nhật `is_accept_invite` cho tất cả những người đã được mời vào workspace
        BoardMember::whereIn('user_id', $invitedWorkspaceMembers->pluck('user_id'))
            ->where('board_id', $board->id)
            ->update(['is_accept_invite' => 0]);

        // Lấy ra chủ sở hữu của bảng
        $boardOwner = $boardMemberMain->firstWhere('authorize', AuthorizeEnum::Owner()->value);

        // Lấy danh sách thành viên của workspace mà chưa phải là thành viên của bảng
        $wspMember = WorkspaceMember::query()
            ->join('users', 'users.id', '=', 'workspace_members.user_id')
            ->leftJoin('board_members', function ($join) use ($board) {
                $join->on('workspace_members.user_id', '=', 'board_members.user_id')
                    ->where('board_members.board_id', '=', $board->id);
            })
            ->select('users.id', 'users.name')
            ->whereNull('board_members.user_id') // Thành viên chưa có trong bảng
            ->where('workspace_members.workspace_id', $board->workspace_id)
            ->where('workspace_members.authorize', '!=', 'Viewer') // Lọc những người không phải Viewer
            ->get();

        switch ($viewType) {
            case 'dashboard':
                return view('homes.dashboard_board', compact('board', 'activities', 'boardMembers', 'boardMemberInvites', 'boardOwner', 'wspMember', 'colors', 'id'));

            case 'list':
                return view('lists.index', compact('board', 'activities', 'boardMembers', 'boardMemberInvites', 'boardOwner', 'wspMember', 'colors'));

            case 'gantt':
                return view('ganttCharts.index', compact('board', 'activities', 'boardMembers', 'boardMemberInvites', 'boardOwner', 'wspMember', 'colors'));

            case 'table':
                return view('tables.index', compact('board', 'activities', 'boardMembers', 'boardMemberInvites', 'boardOwner', 'wspMember', 'colors'));

            case 'calendar':
                $listEvent = array();

                $taskCalendar = Task::query()
                    ->whereHas('catalog', function ($query) use ($id) {
                        $query->where('board_id', $id);
                    })
                    ->get()
                    ->filter(function ($task) {
                        // Nếu cả hai đều không tồn tại, ẩn
                        if (is_null($task->start_date) && is_null($task->end_date)) {
                            return false;
                        }

                        // Nếu chỉ tồn tại một trong hai, gán giá trị của cái còn lại
                        if (is_null($task->start_date)) {
                            $task->start_date = $task->end_date;
                        } elseif (is_null($task->end_date)) {
                            $task->end_date = $task->start_date;
                        }
                        // Hiển thị task nếu đã xử lý xong
                        return true;
                    });
                //        dd($taskCalendar);
                foreach ($taskCalendar as $event) {
                    $listEvent[] = [
                        'id' => $event->id,
                        'id_google_calendar' => $event->id_google_calendar,
                        'title' => $event->text,
                        'email' => $event->creator_email,
                        'start' => Carbon::parse($event->start_date)->toIso8601String(),
                        'end' => Carbon::parse($event->end_date)->toIso8601String(),
                    ];
                }
                return view('calendars.index', compact('listEvent', 'board', 'activities', 'boardMembers', 'boardMemberInvites', 'boardOwner', 'wspMember', 'colors'));

            default:
                return view('boards.index', compact('board', 'activities', 'boardMembers', 'boardMemberInvites', 'boardOwner', 'wspMember', 'colors'));
        }
    }


    public function filter(Request $request, string $boardId)
    {
        $filters = $request->all(); // Lấy tất cả dữ liệu từ form

        // Thực hiện lọc các task hoặc dữ liệu theo yêu cầu
        $filteredTasks = Task::query()
            ->when(isset($filters['search']), function ($query) use ($filters) {
                return $query->where('text', 'like', '%' . $filters['search'] . '%');
            })
            ->when(isset($filters['no_member']), function ($query) {
                return $query->doesntHave('members');
            })
            ->when(isset($filters['due_tomorrow']), function ($query) {
                return $query->whereDate('due_date', '=', now()->addDay());
            })
            // Add thêm các điều kiện lọc khác
            ->get();
        dd($filteredTasks);
        return response()->json([
            'success' => true,
            'filteredTasks' => $filteredTasks
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $board = Board::query()->findOrFail($id);
        $data = $request->except(['_token', '_method', 'image']);
        if ($request->hasFile('image')) {
            $imagePath = Storage::put(self::PATH_UPLOAD, $request->file('image'));
            $data['image'] = $imagePath;
            if ($board->image && Storage::exists($board->image)) {
                Storage::delete($board->image);
            }
        }
        $board->update($data);
        return response()->json([
            'message' => 'Board đã được cập nhật thành công',
            'msg' => true
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
                'msg' => true
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
        session(['msg' => 'Đã gửi email thêm thành viên !!!']);
        session(['action' => 'success']);
        return back();
    }


    public function acceptInviteBoard($uuid, $token, Request $request)
    {
        //xử lý khi admin gửi link invite cho người dùng
        if ($request->email) {
            $board = Board::where('link_invite', 'LIKE', "%$uuid/$token%")->first();
            $user = User::query()->where('email', $request->email)->first();


            //xử lý khi người dùng có tài khoản
            if ($user) {
                $check_user_wsp = BoardMember::join('boards', 'boards.id', '=', 'board_members.board_id')
                    ->join('workspace_members', 'workspace_members.workspace_id', 'boards.workspace_id')
                    ->where('board_members.user_id', $user->id)
                    ->where('boards.workspace_id', $board->workspace_id)
                    ->where('workspace_members.workspace_id', $board->workspace_id)
                    ->first();
                $check_user_board = BoardMember::where('user_id', $user->id)->where('board_id', $board->id)
                    ->first();
                //Check xử lý người dùng có trong workspace
                if ($check_user_wsp) {

                    //xử lý khi người dùng chưa có trong bảng đó
                    if (!$check_user_board) {

                        //xử lý khi người dùng đã có tài khoản và đang đăng nhập
                        if (Auth::check()) {
                            $user_check = Auth::user(); // Lấy thông tin người dùng hiện tại

                            //xử lý người dùng khi đã đăng nhập đúng người dùng
                            if ($user_check->email === $request->email) {

                                try {
                                    //thêm người dùng vào board member
                                    BoardMember::create([
                                        'user_id' => $user_check->id,
                                        'board_id' => $board->id,
                                        'authorize' => $request->authorize,
                                        'invite' => now(),
                                    ]);

                                    // ghi lại hoạt động thêm người vào ws
                                    activity('Member Added to Bảng')
                                        ->causedBy(Auth::user()) // Người thực hiện hành động
                                        ->performedOn($board) // Liên kết với bảng
                                        ->withProperties(['member_name' => $user_check->name]) // Thông tin bổ sung
                                        ->log('Người dùng đã được thêm vào Bảng.');

                                    session(['msg' => 'Bạn đã được thêm vào bảng. \"{$board->name}\" !!!']);
                                    session(['action' => 'success']);
                                    return redirect()->route('b.edit', $board->id);
                                } catch (\Throwable $th) {
                                    throw $th;
                                }
                            } // Người dùng đã đăng nhập nhưng email khác
                            else {
                                Auth::logout();
                                Session::put('invited_board', "case1");
                                Session::put('board_id', $board->id);
                                Session::put('user_id', $user->id);
                                Session::put('email_invited', $request->email);
                                Session::put('authorize', $request->authorize);
                                return redirect()->route('login');
                            }
                        } //xử lý khi người dùng có tài khoản rồi mà chưa đăng nhập
                        else {
                            Session::put('invited_board', "case1");
                            Session::put('board_id', $board->id);
                            Session::put('user_id', $user->id);
                            Session::put('email_invited', $request->email);
                            Session::put('authorize', $request->authorize);
                            return redirect()->route('login');
                        }
                    } //DONE

                    //xử lý khi người dùng đã có trong bảng đó rồi
                    else {
                        session(['msg' => 'Bạn đã ở trong bảng rồi!!']);
                        session(['action' => 'error']);
                        return redirect()->route('b.edit', $board->id);
                    }
                } //check xử lý nếu người dùng chưa ở trong wsp
                else {

                    //xử lý khi người dùng chưa có trong bảng đó
                    if (!$check_user_board) {

                        //xử lý khi người dùng đã có tài khoản và đang đăng nhập
                        if (Auth::check()) {

                            $user_check = Auth::user(); // Lấy thông tin người dùng hiện tại

                            //xử lý người dùng khi đã đăng nhập đúng người dùng
                            if ($user_check->email === $request->email) {
                                try {

                                    //thêm người dùng vào workspace member
                                    WorkspaceMember::create([
                                        'user_id' => $user_check->id,
                                        'workspace_id' => $board->workspace_id,
                                        'authorize' => AuthorizeEnum::Viewer(),
                                        'invite' => now(),
                                        'is_active' => 1,
                                    ]);

                                    //thêm người dùng vào workspace member
                                    BoardMember::create([
                                        'user_id' => $user_check->id,
                                        'board_id' => $board->id,
                                        'authorize' => $request->authorize,
                                        'invite' => now(),
                                    ]);

                                    //query workspace_member vừa tạo
                                    $wm = WorkspaceMember::query()
                                        ->where('user_id', $user_check->id)
                                        ->where('workspace_id', $board->workspace_id)
                                        ->first();

                                    //xử lý update is_active
                                    WorkspaceMember::query()
                                        ->where('user_id', $user_check->id)
                                        ->whereNot('id', $wm->id)
                                        ->update(['is_active' => 0]);
                                    WorkspaceMember::query()
                                        ->where('id', $wm->id)
                                        ->update(['is_active' => 1]);

                                    // ghi lại hoạt động thêm người vào ws
                                    activity('Member Added to Bảng')
                                        ->causedBy(Auth::user()) // Người thực hiện hành động
                                        ->performedOn($board) // Liên kết với workspace
                                        ->withProperties(['member_name' => $user_check->name]) // Thông tin bổ sung
                                        ->log('Người dùng đã được thêm vào Bảng.');

                                    session(['msg' => 'Bạn đã được thêm vào bảng. \"{$board->name}\" !!!']);
                                    session(['action' => 'success']);
                                    return redirect()->route('b.edit', $board->id);
                                } catch (\Throwable $th) {
                                    throw $th;
                                }
                            } // Người dùng đã đăng nhập nhưng email khác
                            else {
                                Auth::logout();
                                Session::put('invited_board', "case4");
                                Session::put('board_id', $board->id);
                                Session::put('workspace_id', $board->workspace_id);
                                Session::put('user_id', $user->id);
                                Session::put('email_invited', $request->email);
                                Session::put('authorize', $request->authorize);
                                return redirect()->route('login');
                            }
                        } //xử lý khi người dùng có tài khoản rồi mà chưa đăng nhập đó
                        else {
                            Session::put('invited_board', "case4");
                            Session::put('board_id', $board->id);
                            Session::put('workspace_id', $board->workspace_id);
                            Session::put('user_id', $user->id);
                            Session::put('email_invited', $request->email);
                            Session::put('authorize', $request->authorizei);
                            return redirect()->route('login');
                        }
                    }
                }
            } //xử lý khi người dùng không có tài khoản
            else {
                //xử lý khi người dùng không có tài khoản
                Auth::logout();
                Session::put('board_id', $board->id);
                Session::put('invited_board', 'case2');
                Session::put('workspace_id', $board->workspace_id);
                Session::put('email_invited', $request->email);
                Session::put('authorize', $request->authorize);
                return redirect()->route('register');
            }
        } //xử lý khi người dùng có link invite và kick vô
        else {
            $board = Board::where('link_invite', 'LIKE', "%$uuid/$token%")->first();
            Auth::logout();
            Session::put('board_id', $board->id);
            Session::put('workspace_id', $board->workspace_id);
            Session::put('board_access', $board->access);
            Session::put('authorize', AuthorizeEnum::Member());
            Session::put('invited_board', 'case3');
            return redirect()->route('login');
        }
    }

    public function requestToJoinWorkspace()
    {
        $workspace_member = WorkspaceMember::where('user_id', Auth::id())
            ->where('is_active', 1)
            ->first();
        $workspace_member->update([
            'is_accept_invite' => 1,
        ]);
        session(['msg' => 'Bạn đã gửi yêu cầu tham gia vào không gian làm việc']);
        session(['action' => 'success']);
        return redirect()->route('home');
    }

    public function inviteMemberWorkspace($userId, $boardId)
    {
        BoardMember::create([
            'user_id' => $userId,
            'board_id' => $boardId,
            'authorize' => AuthorizeEnum::Member(),
            'invite' => now(),
        ]);
        return response()->json(['success' => true]);
    }
}