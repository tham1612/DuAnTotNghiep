<?php

namespace App\Http\Controllers;

use App\Enums\AuthorizeEnum;
use App\Events\EventNotification;
use App\Events\UserInvitedToWorkspace;
use App\Http\Requests\UpdateWorkspaceRequest;
use App\Models\Board;
use App\Models\BoardMember;
use App\Models\Catalog;
use App\Models\CheckList;
use App\Models\Follow_member;
use App\Models\Tag;
use App\Models\Task;
use App\Models\TaskAttachment;
use App\Models\TaskComment;
use App\Models\TaskMember;
use App\Models\TaskTag;
use App\Models\User;
use App\Models\Workspace;
use App\Models\WorkspaceMember;
use App\Notifications\BoardNotification;
use App\Notifications\WorkspaceNotification;
use App\Notifications\WorkspaceMemberNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Spatie\Activitylog\Contracts\Activity;
use function Laravel\Prompts\table;


class WorkspaceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    const PATH_UPLOAD = 'workspaces';
    public $authorizeWeb;

    public function __construct(AuthorizeWeb $authorizeWeb)
    {
        $this->authorizeWeb = $authorizeWeb;
    }

    public function index(string $id)
    {
        $userId = Auth::id();
        WorkspaceMember::query()
            ->where('user_id', $userId)
            ->whereNot('id', $id)
            ->update(['is_active' => 0]);
        WorkspaceMember::query()
            ->where('id', $id)
            ->update(['is_active' => 1]);
        Session::forget('workspaceChecked');
        return redirect()->route('home')->with([
            'msg' => "Bạn đã chuyển đổi không gian làm việc",
            'action' => 'success'
        ]);
    }

    public function create()
    {
        // Log::debug(Auth::check());
        // Log::debug(Auth::user()->hasWorkspace());
        return view('workspaces.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Session::flush();

        Log::debug('check');

        $data = $request->except('image');
        if ($request->hasFile('image')) {
            $data['image'] = Storage::put(self::PATH_UPLOAD, $request->file('image'));
        }
        $data['access'] = $data['access'] ?? 'private';
        $uuid = Str::uuid();
        $token = Str::random(40);
        $data['link_invite'] = url("taskflow/invite/{$uuid}/{$token}");
        $is_active = 1;

        try {
            DB::beginTransaction();
            $workspace = Workspace::query()->create($data);
            Log::info('Form submitted by user: ' . auth()->id());
            $workspaceMember = WorkspaceMember::query()
                ->create([
                    'user_id' => auth()->id(),
                    'workspace_id' => $workspace->id,
                    'authorize' => 'Owner',
                    'invite' => now(),
                    'is_active' => $is_active,
                ]);

                activity('Workspace Created')
                ->causedBy(Auth::user())
                ->performedOn($workspace)
                ->withProperties([
                    'workspace_name' => $workspace->name,
                ])
                ->tap(function (Activity $activity) use ($workspace) {
                    $activity->workspace_id = $workspace->id;
                })
                ->log('Người dùng đã tạo không gian làm việc mới.');
            //           update lai cot is_active khi tao ws moi
            WorkspaceMember::query()
                ->where('user_id', auth()->id())
                ->whereNot('id', $workspaceMember->id)
                ->update(['is_active' => 0]);

            // lưu lại hoạt động
            activity('Board Create')
                ->causedBy(Auth::user())
                ->withProperties('board_name', $workspace->name)
                ->tap(function (Activity $activity) use ($workspace) {
                    $activity->Workspace_id = $workspace->id;
                })
                ->log('người dùng đã tạo bảng mới trong ws');

            //xử lý thêm người dùng khi người dùng đăng ký qua nhập link mời email vào workspace
            if (Session::get('invited') == "case2") {
                $user = Auth::user();
                //xử lý trường hợp người dùng đăng nhập  đúng email được gửi link mời
                if (Session::get('email_invited') == $user->email) {
                    try {
                        //thêm người dùng vào workspace member
                        WorkspaceMember::create([
                            'user_id' => $user->id,
                            'workspace_id' => Session::get('workspace_id'),
                            'authorize' => Session::get('authorize'),
                            'invite' => now(),
                            'is_active' => 1,
                        ]);

                        // ghi lại hoạt động khi thêm người dùng vào ws

                        activity('Thêm người dùng vào WS')
                            ->causedBy(Auth::user())
                            ->withProperties(['added_user_id' => $user->id])
                            ->tap(function (Activity $activity) use ($workspace) {
                                $activity->Workspace_id = $workspace->id;
                            })
                            ->log('add người thành công vào ws');

                        //thông báo
                        $this->notificationMemberInviteWorkspace(Session::get('workspace_id'), $user->name);

                        //query workspace_member vừa tạo
                        $wm = WorkspaceMember::query()
                            ->where('workspace_members.user_id', $user->id)
                            ->where('workspace_id', Session::get('workspace_id'))
                            ->first();
                        //xử lý update is_active
                        WorkspaceMember::query()
                            ->where('user_id', $user->id)
                            ->whereNot('id', $wm->id)
                            ->update(['is_active' => 0]);


                        WorkspaceMember::query()
                            ->where('id', $wm->id)
                            ->update(['is_active' => 1]);
                        //xóa các session sau khi xong
                        Session::forget('invited');
                        Session::forget('workspace_id');
                        Session::forget('email_invited');
                        Session::forget('authorize');
                    } catch (\Throwable $th) {
                        throw $th;
                    }
                } else {
                    Session::forget('invited');
                    Session::forget('workspace_id');
                    Session::forget('email_invited');
                    Session::forget('authorize');
                }
            }

            //xử lý thêm người dùng khi người dùng đăng ký qua nhập link mời email vào bảng
            if (Session::get('invited_board') == "case2") {
                $user = Auth::user();

                //xử lý trường hợp người dùng đăng ký đúng email được gửi link mời
                if (Session::get('email_invited') == $user->email) {
                    try {

                        //thêm người dung vào wsp với tư cách viewer
                        WorkspaceMember::create([
                            'user_id' => $user->id,
                            'workspace_id' => Session::get('workspace_id'),
                            'authorize' => AuthorizeEnum::Viewer(),
                            'invite' => now(),
                            'is_active' => 1,
                        ]);

                        //thêm người dùng vào workspace member
                        BoardMember::create([
                            'user_id' => $user->id,
                            'board_id' => Session::get('board_id'),
                            'authorize' => Session::get('authorize'),
                            'invite' => now(),
                        ]);

                        $wm = WorkspaceMember::query()
                            ->where('workspace_members.user_id', $user->id)
                            ->where('workspace_id', Session::get('workspace_id'))
                            ->first();
                        //xử lý update is_active
                        WorkspaceMember::query()
                            ->where('user_id', $user->id)
                            ->whereNot('id', $wm->id)
                            ->update(['is_active' => 0]);
                        WorkspaceMember::query()
                            ->where('id', $wm->id)
                            ->update(['is_active' => 1]);
                        $this->notificationMemberInviteBoard(Session::get('board_id'), $user->name);

                        //xóa các session sau khi xong
                        Session::forget('invited_board');
                        Session::forget('workspace_id');
                        Session::forget('board_id');
                        Session::forget('email_invited');
                        Session::forget('authorize');
                    } catch (\Throwable $th) {
                        throw $th;
                    }
                } else {
                    Session::forget('invited_board');
                    Session::forget('board_id');
                    Session::forget('email_invited');
                    Session::forget('authorize');
                }
            }

            if (Session::get('invited') == "case3") {
                $user = Auth::user();

                //xử lý người dùng kick link invte và workspace đang public
                if (Session::get('access') == 'public') {
                    try {
                        WorkspaceMember::create([
                            'user_id' => $user->id,
                            'workspace_id' => Session::get('workspace_id'),
                            'authorize' => Session::get('authorize'),
                            'invite' => now(),
                            'is_active' => 1,
                        ]);

                        //update is_active
                        $wm = WorkspaceMember::query()
                            ->where('workspace_members.user_id', Auth::id())
                            ->where('workspace_id', Session::get('workspace_id'))
                            ->first();

                        //xử lý update is_active
                        WorkspaceMember::query()
                            ->where('user_id', Auth::id())
                            ->whereNot('id', $wm->id)
                            ->update(['is_active' => 0]);
                        WorkspaceMember::query()
                            ->where('id', $wm->id)
                            ->update(['is_active' => 1]);
                        $this->notificationMemberInviteWorkspace(Session::get('workspace_id'), $user->name);

                        Session::forget('workspace_id');
                        Session::forget('invited');
                        Session::forget('authorize');
                        Session::forget('access');

                        Session::put('msg', 'one');
                    } catch (\Throwable $th) {
                        dd($th);
                    }
                } //xử lý người dùng kick link invte và workspace đang private
                else {
                    WorkspaceMember::create([
                        'user_id' => $user->id,
                        'workspace_id' => Session::get('workspace_id'),
                        'authorize' => Session::get('authorize'),
                        'invite' => now(),
                        'is_active' => 0,
                        'is_accept_invite' => 1,
                    ]);

                    //xóa tất cả session đã set
                    Session::forget('workspace_id');
                    Session::forget('invited');
                    Session::forget('authorize');
                    Session::forget('access');
                    Session::put('msg', 'two');

                }
            }
            if (Session::get('invited_board') == "case3") {
                $user = Auth::user();
                if (Session::get('board_access') == "public") {

                    try {
                        WorkspaceMember::create([
                            'user_id' => $user->id,
                            'workspace_id' => Session::get('workspace_id'),
                            'authorize' => AuthorizeEnum::Viewer(),
                            'invite' => now(),
                            'is_active' => 1,
                        ]);

                        BoardMember::create([
                            'user_id' => $user->id,
                            'board_id' => Session::get('board_id'),
                            'authorize' => Session::get('authorize'),
                            'invite' => now(),
                        ]);

                        $wm = WorkspaceMember::query()
                            ->where('workspace_members.user_id', $user->id)
                            ->where('workspace_id', Session::get('workspace_id'))
                            ->first();
                        //xử lý update is_active
                        WorkspaceMember::query()
                            ->where('user_id', $user->id)
                            ->whereNot('id', $wm->id)
                            ->update(['is_active' => 0]);
                        WorkspaceMember::query()
                            ->where('id', $wm->id)
                            ->update(['is_active' => 1]);
                        $this->notificationMemberInviteBoard(Session::get('board_id'), auth()->user()->name);

                        Session::forget('board_id');
                        Session::forget('workspace_id');
                        Session::forget('board_access');
                        Session::forget('authorize');
                        Session::forget('invited_board');
                        Session::put('msg', 'one');
                    } catch (\Throwable $th) {
                        dd($th);
                        throw $th;
                    }
                } //xử lý nếu bảng private
                else {
                    BoardMember::create([
                        'user_id' => $user->id,
                        'board_id' => Session::get('board_id'),
                        'authorize' => Session::get('authorize'),
                        'invite' => now(),
                        'is_accept_invite' => 1,
                    ]);

                    Session::forget('board_id');
                    Session::forget('workspace_id');
                    Session::forget('board_access');
                    Session::forget('authorize');
                    Session::forget('invited_board');
                    Session::put('msg', 'two');
                }
            }

            DB::commit();

            if (Session::get('msg') == "one") {
                Session::forget('msg');
                return redirect()->route('home')->with([
                    'msg' => 'Bạn đã tham gia vào không gian làm việc',
                    'action' => 'success'
                ]);
            } else if (Session::get('msg') == "two") {
                Session::forget('msg');
                return redirect()->route('home')->with([
                    'msg' => 'Chờ quản trị viên duyệt',
                    'action' => 'success'
                ]);
            }

            return redirect()->route('home');
        } catch (\Exception $exception) {
            DB::rollBack();
            dd($exception->getMessage());
            return back()->with([
                'action' => 'danger',
                'msg' => 'Error: ' . $exception->getMessage()
            ]);
        }
    }

    public function delete(string $id)
    {
        $authorize = $this->authorizeWeb->authorizeEditWorkspace();
        if (!$authorize) {
            return response()->json([
                'action' => 'error',
                'msg' => 'Bạn không có quyền!!',
            ]);
        }

        $wsp = Workspace::query()->findOrFail($id);
        $boards = Board::withTrashed()
            ->where('workspace_id', $wsp->id)
            ->get();
        //        dd($boards);


        try {
            DB::beginTransaction();
            foreach ($boards as $board) {
                BoardMember::query()->where('board_id', $board->id)->delete();
                $catalogs = Catalog::withTrashed()
                    ->where('board_id', $board->id)
                    ->get();

                foreach ($catalogs as $catalog) {
                    $tasks = Task::withTrashed()
                        ->where('catalog_id', $catalog->id)
                        ->get();
                    foreach ($tasks as $task) {
                        // đơn
                        Follow_member::query()->where('task_id', $task->id)->delete();
                        TaskMember::query()->where('task_id', $task->id)->delete();
                        TaskTag::query()->where('task_id', $task->id)->delete();
                        TaskAttachment::query()->where('task_id', $task->id)->delete();

                        foreach ($task->checkLists as $checklist) {
                            // Lặp qua các checklist item của mỗi checklist và xóa các item members
                            foreach ($checklist->checkListItems as $checklistItem) {
                                $checklistItem->checkListItemMembers()->delete();
                            }
                            // Xóa tất cả các checklist items của checklist
                            $checklist->checkListItems()->delete();
                        }

                        TaskComment::query()->where('task_id', $task->id)->forceDelete();

                        //  kết hợp
                        CheckList::query()->where('task_id', $task->id)->delete();

                        $task->forceDelete();
                        if ($task->id_google_calendar)
                            $this->googleApiClient->deleteEvent($task->id_google_calendar);
                    }

                    $catalog->forceDelete();
                }
                Tag::where('board_id', $board->id)->delete();
                $board->forceDelete();
            }


            WorkspaceMember::query()->where('workspace_id', $wsp->id)->forceDelete();

            $wsp->delete();
            $wsChecked = WorkspaceMember::query()->where('user_id', Auth::id())->inRandomOrder('id')->first();
            if ($wsChecked) {
                $wsChecked->update([
                    'is_active' => 1,
                ]);
            }

            DB::commit();
            return response()->json([
                'action' => 'success',
                'msg' => 'Bạn đã xóa Thành công không gian làm việc!!',
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();
            dd($exception->getMessage());
            return back()->with([
                'msg' => 'Error: ' . $exception->getMessage(),
                'action' => 'danger'
            ]);
        }
    }


    // show form chỉnh sửa ws
    public function showFormEditWorkspace()
    {
        $userId = Auth::id();
        $user = Auth::user();
        $userName = $user->name;

        $workspaceChecked = Workspace::query()
            ->select('*', 'workspaces.id as id', 'workspace_members.id as wm_id', 'workspaces.name as wsp_name')
            ->join('workspace_members', 'workspaces.id', 'workspace_members.workspace_id')
            ->where('workspace_members.user_id', $userId)
            ->where('workspace_members.is_active', 1)
            ->first();


        $workspaceMembers = WorkspaceMember::query()
            ->select('workspace_members.*', 'workspace_members.id as wm_id', 'users.id as user_id', 'users.name as name', 'workspaces.name as wsp_name')
            ->join('users', 'users.id', 'workspace_members.user_id')
            ->join('workspaces', 'workspaces.id', 'workspace_members.workspace_id')
            ->where('workspace_members.workspace_id', $workspaceChecked->workspace_id)
            ->get();

        $wspMemberCount = 0;
        $wspInviteCount = 0;
        $wspViewerCount = 0;
        $wspSubOwnerCount = 0;

        $wspOwner = null;
        $wspMember = [];
        $wspSubOwner = [];
        $wspInvite = [];
        $wspViewer = [];

        foreach ($workspaceMembers as $member) {
            if ($member->authorize->value == AuthorizeEnum::Owner()) {
                $wspOwner = $member;
            } elseif ($member->authorize->value == AuthorizeEnum::Member() && $member->is_accept_invite == 0) {
                $wspMember[] = $member;
                $wspMemberCount++;
            } elseif ($member->authorize == AuthorizeEnum::Sub_Owner() && $member->is_accept_invite == 0) {
                $wspSubOwner[] = $member;
                $wspSubOwnerCount++;
            } elseif ($member->is_accept_invite != 0 && $member->is_accept_invite != 2) {
                $wspInvite[] = $member;
                $wspInviteCount++;
            } elseif ($member->authorize->value == AuthorizeEnum::Viewer() && $member->is_accept_invite == 0) {
                $wspViewer[] = $member;
                $wspViewerCount++;
            }
        }
        //lấy số người có trong bảng nhưng không có trong wsp
        if ($workspaceChecked->access == 'private') {
            $icon = 'ri-git-repository-private-fill';
            $access = 'Riêng tư';
            $ws_desrip =
                'Đây là Không gian làm việc riêng tư. Chỉ những người trong Không gian làm việc có thể truy cập hoặc nhìn thấy Không gian làm việc.';
        } elseif ($workspaceChecked->access == 'public') {
            $icon = 'ri-global-line';
            $access = 'Công khai';
            $ws_desrip = "Đây là không gian làm việc công khai. Bất kỳ
                                    ai có đường dẫn tới không gian
                                    làm việc đều có thể nhìn thấy không gian làm việc và không gian làm việc có thể được tìm
                                    thấy trên các công cụ tìm kiếm như Google. Chỉ những người được mời vào không gian làm
                                    việc mới có thể thêm và chỉnh sửa các bảng của không gian làm việc.";
        }

        return view(
            'workspaces.update',
            compact(
                'userId',
                'userName',
                'workspaceChecked',
                'icon',
                'wspViewer',
                'access',
                'ws_desrip',
                'wspOwner',
                'wspMember',
                'wspInvite',
                'userId',
                'wspMemberCount',
                'wspInviteCount',
                'wspViewerCount',
                'wspSubOwner',
                'wspSubOwnerCount'
            )
        );
    }

    //duyệt người dùng
    //thông báo Done
    // public function accept_member(Request $request)
    // {
    //     try {
    //         // Lấy WorkspaceMember
    //         $workspaceMember = WorkspaceMember::query()
    //             ->where('user_id', $request->user_id)
    //             ->where('workspace_id', $request->workspace_id)
    //             ->with('user') // Eager load user
    //             ->first(); // Lấy bản ghi đầu tiên

    //         // Kiểm tra nếu WorkspaceMember tồn tại
    //         if ($workspaceMember) {
    //             // Cập nhật các trường is_accept_invite và authorize
    //             // $workspaceMember->update([
    //             //     'is_accept_invite' => 0,
    //             //     'authorize' => "Member"
    //             // ]);

    //             // Gọi hàm thông báo
    //             $this->notificationMemberInviteWorkspace($request->workspace_id, $workspaceMember->user->name);
    //         } else {
    //             if (request()->ajax()) {
    //                 return response()->json([
    //                     'success' => true,
    //                     'action' => 'error',
    //                     'msg' => 'Không tìm thấy thành viên trong không gian làm việc',
    //                 ]);
    //             }
    //             return redirect()->route('showFormEditWorkspace')->with([
    //                 'msg' => 'Không tìm thấy thành viên trong không gian làm việc',
    //                 'action' => 'error'
    //             ]);
    //         }
    //         if (request()->ajax()) {
    //             return response()->json([
    //                 'success' => true,
    //                 'action' => 'success',
    //                 'msg' => 'Bạn đã thêm người dùng vào không gian làm việc',
    //             ]);
    //         }
    //         // Trả về phản hồi thành công
    //         return redirect()->route('showFormEditWorkspace')->with([
    //             'msg' => 'Đã thêm thành viên vào không gian làm việc',
    //             'action' => 'success'
    //         ]);
    //     } catch (\Exception $e) {
    //         throw $e; // Hoặc xử lý lỗi bằng cách khác
    //     }
    // }

    public function accept_member(Request $request)
    {
        try {
            // Debug xem dữ liệu nhận được
            \Log::info('Request data:', $request->all());

            $workspaceMember = WorkspaceMember::query()
                ->where('user_id', $request->user_id)
                ->where('workspace_id', $request->workspace_id)
                ->with('user')
                ->first();

            if ($workspaceMember) {
                // Cập nhật trạng thái
                $workspaceMember->update([
                    'is_accept_invite' => 0,
                    'authorize' => "Member"
                ]);

                // Gửi thông báo
                $this->notificationMemberInviteWorkspace($request->workspace_id, $workspaceMember->user->name);
                $owner = WorkspaceMember::where('authorize', "Owner")
                    ->where('Workspace_id', $request->workspace_id)
                    ->first();
                return response()->json([
                    'success' => true,
                    'action' => 'success',
                    'msg' => 'Đã thêm thành viên vào không gian làm việc',
                    'name' => $workspaceMember->user->name,
                    'image' => $workspaceMember->user->image ? Storage::url($workspaceMember->user->image) : null,
                    'owner_id' => $owner->id
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'action' => 'error',
                    'msg' => 'Không tìm thấy thành viên trong không gian làm việc',
                ]);
            }
        } catch (\Exception $e) {
            \Log::error('Error in accept_member:', ['message' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'action' => 'error',
                'msg' => 'Có lỗi xảy ra khi xử lý yêu cầu',
            ]);
        }
    }


    //Xóa người dùng gửi lời mời vào wsp
    //thông báo Done
    public function refuse_member($wm_id)
    {
        $wspMember = WorkspaceMember::with(['user', 'workspace'])->find($wm_id);
        try {
            DB::table('workspace_members')->where('id', $wm_id)->update([
                'is_accept_invite' => 2
            ]);

            $title = "Từ chối lời mời";
            $title = "Lời Mời Đã Bị Từ Chối";
            $description = 'Bạn vừa nhận được thông báo từ chối lời mời gia nhập không gian làm việc "' . $wspMember->workspace->name . '". Hy vọng bạn sẽ có những cơ hội hợp tác khác trong tương lai gần!';
            if ($wspMember->user->id == Auth::id()) {
                event(new EventNotification($description, 'success', $wspMember->user->id));
            }
            $wspMember->user->notify(new WorkspaceMemberNotification($title, $description, $wspMember, 1));
            return response()->json([
                'success' => true,
                'action' => 'success',
                'msg' => 'Bạn đã xóa lời mời vào không gian làm việc của ' . $wspMember->user->name,
            ]);
            // return redirect()->route('showFormEditWorkspace')->with([
            //     'msg' => 'Bạn đã xóa lời mời vào không gian làm việc của ' . $wspMember->user->name,
            //     'action' => 'warning'
            // ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    // logic chỉnh sửa ws
    //thông báo Done

    public function editWorkspace(UpdateWorkspaceRequest $request)
    {
        $authorize = $this->authorizeWeb->authorizeEditWorkspace();
        if (!$authorize) {
            return response()->json([
                'action' => 'error',
                'msg' => 'Bạn không có quyền!!',
            ]);
        }
        try {
            $user = Auth::user();

            $workspace = Workspace::find($request->workspace_id);

            $validatedData = $request->except('image');

            if ($request->hasFile('image')) {
                $validatedData['image'] = Storage::put('workspace_images', $request->file('image'));

                if ($workspace->image && Storage::exists($workspace->image)) {
                    Storage::delete($workspace->image); // Xóa ảnh cũ
                }
            }

            $workspace->update($validatedData);

            activity('Workspace Updated')
                ->causedBy($user)
                ->performedOn($workspace)
                ->withProperties(['updated_fields' => $validatedData])
                ->log('Người dùng đã chỉnh sửa workspace.');

            // Gửi thông báo hoặc ghi log
            $this->notificationEditWorkspace($workspace->id, $user->name);

            if ($request->ajax()) {
                return response()->json(['message' => 'Cập nhật thành công!', 'action' => 'success'], 200);
            }

            return redirect()->route('showFormEditWorkspace')->with(['msg' => 'Cập nhật thành công!', 'action' => 'success']);
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['message' => 'Có lỗi xảy ra: ' . $e->getMessage(), 'action' => 'success'], 500);
            }

            return redirect()->route('showFormEditWorkspace')->withErrors(['msg' => 'Có lỗi xảy ra!']);
        }
    }

    //chỉnh sửa công khai hoặc riêng tư
    //thông báo Done
    public function update_ws_access(Request $request)
    {
        $user = Auth::user();
        $workspaceAuthorize = WorkspaceMember::query()
            ->with('workspace')
            ->where('user_id', $user->id)
            ->where('is_active', 1)
            ->first();

        if (
            $workspaceAuthorize->authorize->value !== AuthorizeEnum::Owner()->value
            && $workspaceAuthorize->authorize->value !== AuthorizeEnum::Sub_Owner()->value
        ) {

            $response = ['message' => 'Bạn không có quyền thay đổi quyền truy cập không gian làm việc'];
            return $request->ajax()
                ? response()->json($response, 403)
                : redirect()->route('showFormEditWorkspace')->with($response);
        }

        try {
            Workspace::query()
                ->join('workspace_members', 'workspaces.id', 'workspace_members.workspace_id')
                ->where('workspace_members.user_id', $user->id)
                ->where('workspace_members.is_active', 1)
                ->update(['access' => $request->access]);

            $this->notificationUpdateWorkspaceAccess($workspaceAuthorize->workspace->id, $user->name);

            $response = ['message' => 'Thay đổi thành công', 'action' => 'success'];
            return $request->ajax()
                ? response()->json($response, 200)
                : redirect()->route('showFormEditWorkspace')->with($response);
        } catch (\Throwable $th) {
            $response = ['message' => 'Có lỗi xảy ra: ' . $th->getMessage(), 'action' => 'error'];
            return $request->ajax()
                ? response()->json($response, 500)
                : redirect()->route('showFormEditWorkspace')->withErrors($response);
        }
    }

    //gửi mail mời thành viên
    // public function inviteUser(Request $request, $workspaceId)
    // {
    //     // Kiểm tra xem workspace có tồn tại không
    //     $workspace = Workspace::query()
    //         ->where('id', $workspaceId)
    //         ->firstOrFail();

    //     if (!$workspace) {
    //         return redirect()->route('showFormEditWorkspace')->with([
    //             'action' => 'danger',
    //             'msg' => 'Không gửi email thêm thành viên rồi :('

    //         ]);
    //     }

    //     // Validate email từ request
    //     $request->validate([
    //         'email' => 'required|email',
    //     ]);

    //     $email = $request->input('email');
    //     $linkInvite = $workspace->link_invite;
    //     $workspaceName = $workspace->name;
    //     $authorize = $request->input('authorize');
    //     // Gửi sự kiện để kích hoạt việc gửi email
    //     event(new UserInvitedToWorkspace($workspaceName, $email, $linkInvite, $authorize));


    //     // Thêm ghi lại hoạt động khi gửi lời mời
    //     activity('Workspace Invitation Sent')
    //         ->causedBy(Auth::user())  // Người thực hiện
    //         ->performedOn($workspace) // Workspace liên quan
    //         ->withProperties(['invited_email' => $email]) // Thông tin người được mời
    //         ->log('Người dùng đã gửi lời mời thành viên vào workspace.');


    //     return redirect()->route('showFormEditWorkspace')->with([
    //         'msg' => 'Đã gửi email thêm thành viên !!!',
    //         'action' => 'success'

    //     ]);
    // }
    public function inviteUser(Request $request, $workspaceId)
    {
        // Kiểm tra xem workspace có tồn tại không
        $workspace = Workspace::findOrFail($workspaceId);

        // Validate email từ request
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = $request->input('email');
        $linkInvite = $workspace->link_invite;
        $workspaceName = $workspace->name;
        $authorize = $request->input('authorize');



        if ($request->ajax()) {
            $userCheck = User::where('email', $email)->first(); // Đã sửa 'fisrt' thành 'first'
            $wspCheck = WorkspaceMember::where('user_id', $userCheck->id)->where('workspace_id', $workspaceId)->first();

            if (!empty($wspCheck)) {
                return response()->json([
                    'msg' => 'Người dùng đã ở trong không gian làm việc',
                    'action' => 'error',
                ]);
            }

            // Gửi sự kiện để kích hoạt việc gửi email
            event(new UserInvitedToWorkspace($workspaceName, $email, $linkInvite, $authorize));

            // Thêm ghi lại hoạt động
            activity('Workspace Invitation Sent')
                ->causedBy(Auth::user())
                ->performedOn($workspace)
                ->withProperties(['invited_email' => $email])
                ->log('Người dùng đã gửi lời mời thành viên vào workspace.');


            return response()->json([
                'msg' => 'Đã gửi email thêm thành viên!',
                'action' => 'success',
            ]);
        }

        return redirect()->route('showFormEditWorkspace')->with([
            'msg' => 'Đã gửi email thêm thành viên !!!',
            'action' => 'success'
        ]);
    }


    //người dùng tham gia vào không gian làm việc
    //thông báo Done
    public function acceptInvite($uuid, $token, Request $request)
    {
        //xử lý khi admin gửi link invite cho người dùng
        if ($request->email) {
            $workspace = Workspace::where('link_invite', 'LIKE', "%$uuid/$token%")->first();
            $user = User::query()->where('email', $request->email)->first();


            //logic sử lý thêm người dùng
            if ($user) {
                $check_user_wsp = WorkspaceMember::where('user_id', $user->id)->where('workspace_id', $workspace->id)
                    ->first();

                //xử lý khi người dùng chưa ở trong wsp đó
                if (!$check_user_wsp) {

                    //xử lý khi người dùng có tài khoản và đang đăng nhập
                    if (Auth::check()) {
                        $user_check = Auth::user(); // Lấy thông tin người dùng hiện tại

                        //xử lý người dùng khi đã đăng nhập đúng người dùng
                        if ($user_check->email === $request->email) {
                            try {

                                //thêm người dùng vào workspace member
                                WorkspaceMember::create([
                                    'user_id' => $user_check->id,
                                    'workspace_id' => $workspace->id,
                                    'authorize' => $request->authorize,
                                    'invite' => now(),
                                    'is_active' => 1,
                                ]);

                                // ghi lại hoạt động thêm người vào ws
                                activity('Member Added to Workspace')
                                    ->causedBy(Auth::user()) // Người thực hiện hành động
                                    ->performedOn($workspace) // Liên kết với workspace
                                    ->withProperties(['member_name' => $user_check->name]) // Thông tin bổ sung
                                    ->log('Người dùng đã được thêm vào workspace.');

                                //query workspace_member vừa tạo
                                $wm = WorkspaceMember::query()
                                    ->where('workspace_members.user_id', $user_check->id)
                                    ->where('workspace_id', $workspace->id)
                                    ->first();

                                //xử lý update is_active
                                WorkspaceMember::query()
                                    ->where('user_id', $user_check->id)
                                    ->whereNot('id', $wm->id)
                                    ->update(['is_active' => 0]);
                                WorkspaceMember::query()
                                    ->where('id', $wm->id)
                                    ->update(['is_active' => 1]);

                                $this->notificationMemberInviteWorkspace($workspace->id, $user->name);

                                return redirect()->route('home')->with([
                                    'msg' => "Bạn đã được thêm vào trong không gian làm việc. \"{$workspace->id}\" !!!",
                                    'action' => 'success'
                                ]);
                            } catch (\Throwable $th) {
                                throw $th;
                            }
                        } // Người dùng đã đăng nhập nhưng email khác
                        else {
                            Auth::logout();
                            Session::put('invited', "case1");
                            Session::put('workspace_id', $workspace->id);
                            Session::put('user_id', $user->id);
                            Session::put('email_invited', $request->email);
                            Session::put('authorize', $request->authorize);
                            return redirect()->route('login');
                        }
                    } //xử lý khi người dùng có tài khoản và chưa đăng nhập
                    else {
                        Session::put('invited', "case1");
                        Session::put('workspace_id', $workspace->id);
                        Session::put('email_invited', $request->email);
                        Session::put('authorize', $request->authorize);
                        return redirect()->route('login');
                    }

                } //xử lý khi người dùng đã ở trong wsp đó rồi
                else {
                    return redirect()->route('home');
                }

                //xử lý khi người dùng không có tài khoản
            } else {
                Auth::logout();
                Session::put('workspace_id', $workspace->id);
                Session::put('invited', 'case2');
                Session::put('email_invited', $request->email);
                Session::put('authorize', $request->authorize);
                return redirect()->route('register');
            }
        } //xử lý khi người dùng kick vào link invite
        else {
            $workspace = Workspace::where('link_invite', 'LIKE', "%$uuid/$token%")->first();
            Auth::logout();
            Session::put('workspace_id', $workspace->id);
            Session::put('access', $workspace->access);
            Session::put('authorize', AuthorizeEnum::Viewer());
            Session::put('invited', value: 'case3');
            return redirect()->route('login');
        }

    }

    //Kích thành viên || Rời khỏi không gian làm việc
    // thông báo Done
    // public function activateMember($id)
    // {
    //     $user = Auth::user();
    //     $wsp = WorkspaceMember::with(['user', 'workspace'])->find($id);
    //     $data = Workspace::with([
    //         'boards' => function ($query) use ($user) {
    //             $query->whereHas('boardMembers', function ($q) use ($user) {
    //                 $q->where('user_id', $user->id);
    //             });
    //         },
    //         'users'
    //     ])
    //         ->where('id', $wsp->workspace_id)
    //         ->first();

    //     try {
    //         if ($wsp) {
    //             if ($wsp->authorize == "Owner") {
    //                 if ($data->users->count() == 1) {
    //                     $wsp->forceDelete();
    //                     $title = "Rời Khỏi Không Gian Làm Việc";
    //                     $description = 'Chúng tôi rất tiếc phải thông báo rằng bạn đã bị xóa khỏi không gian làm việc "' . $wsp->workspace->name . '". Hy vọng sẽ có cơ hội gặp lại bạn trong tương lai!';
    //                     if ($wsp->user->id == Auth::id()) {
    //                         event(new EventNotification($description, 'success', $wsp->user->id));
    //                     }
    //                     $wsp->user->notify(new WorkspaceMemberNotification($title, $description, $wsp, 0));
    //                     return redirect()->route('workspaces.create');
    //                 } else {
    //                     return redirect()->route('showFormEditWorkspace')->with([
    //                         'msg' => 'Bạn phải nhượng quyền mới có thể dời khỏi không gian làm việc',
    //                         'action' => 'warning'
    //                     ]);
    //                 }
    //             }

    //             if ($data->boards->count() != 0) {
    //                 $wsp->update([
    //                     'authorize' => AuthorizeEnum::Viewer()
    //                 ]);
    //                 $title = "Rời Khỏi Không Gian Làm Việc";
    //                 $description = 'Chúng tôi rất tiếc phải thông báo rằng bạn đã bị xóa khỏi không gian làm việc "' . $wsp->workspace->name . '". Hy vọng sẽ có cơ hội làm việc cùng bạn trong tương lai!';
    //                 if ($wsp->user->id == Auth::id()) {
    //                     event(new EventNotification($description, 'success', $wsp->user->id));
    //                 }
    //                 $wsp->user->notify(new WorkspaceMemberNotification($title, $description, $wsp, 0));
    //                 return redirect()->route('showFormEditWorkspace')->with([
    //                     'msg' => 'Bạn đã kích thành viên ra khỏi không gian làm việc',
    //                     'action' => 'warning'
    //                 ]);
    //             } else {
    //                 $user_id = $wsp->user_id;
    //                 $wsp->forceDelete();
    //                 $wsChecked = WorkspaceMember::query()->where('user_id', $user_id)->inRandomOrder('id')->first();
    //                 $title = "Rời Khỏi Không Gian Làm Việc";
    //                 $description = 'Chúng tôi rất tiếc phải thông báo rằng bạn đã bị xóa khỏi không gian làm việc "' . $wsp->workspace->name . '". Hy vọng sẽ có cơ hội làm việc cùng bạn trong tương lai!';
    //                 if ($wsp->user->id == Auth::id()) {
    //                     event(new EventNotification($description, 'success', $wsp->user->id));
    //                 }
    //                 $wsp->user->notify(new WorkspaceMemberNotification($title, $description, $wsp, 0));
    //                 if ($wsChecked) {
    //                     $wsChecked->update([
    //                         'is_active' => 1,
    //                     ]);
    //                     return redirect()->route('home');
    //                 }

    //                 return redirect()->route('workspaces.create');
    //             }
    //         }

    //         return back()->with([
    //             'msg' => 'Bạn đã không còn trong không gian làm việc',
    //             'action' => 'warning'
    //         ]);


    //     } catch (\Throwable $th) {
    //         dd($th);
    //     }
    // }

    public function activateMember($id)
    {
        $wsp = WorkspaceMember::with(['user', 'workspace'])->find($id);

        try {
            if ($wsp->authorize != AuthorizeEnum::Viewer()) {
                $title = "Rời Khỏi Không Gian Làm Việc";
                $description = 'Chúng tôi rất tiếc phải thông báo rằng bạn đã bị xóa khỏi không gian làm việc "' . $wsp->workspace->name . '". Bạn đang là khách của không gian làm việc này';
                $wsp->user->notify(new WorkspaceMemberNotification($title, $description, $wsp, 0));
                event(new EventNotification('Bạn đã bị xóa khỏi không gian làm việc ' . $wsp->workspace->name, 'error', $wsp->user->id));
                $wsp->update([
                    'authorize' => AuthorizeEnum::Viewer()
                ]);

                if (request()->ajax()) {
                    return response()->json([
                        'success' => true,
                        'action' => 'success',
                        'msg' => 'Bạn đã kick thành viên khỏi không gian làm việc',
                        'name' => $wsp->user->name,
                        'image' => $wsp->user->image ? Storage::url($wsp->user->image) : null,
                    ]);
                }
            } else {
                if (request()->ajax()) {
                    return response()->json([
                        'success' => true,
                        'action' => 'success',
                        'msg' => 'Bạn đã kick thành viên khỏi không gian làm việc',
                        'name' => $wsp->user->name,
                        'image' => $wsp->user->image ? Storage::url($wsp->user->image) : null,
                    ]);
                }
            }
        } catch (\Throwable $th) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Đã xảy ra lỗi trong quá trình xử lý.'
                ]);
            }
        }
    }


    //hàm rời khỏi workspace
    public function leaveWorkspace($id)
    {

        $wsp = WorkspaceMember::with(['user', 'workspace'])->find($id);
        $workspaceChecked = Workspace::query()
            ->with('users')
            ->join('workspace_members', 'workspaces.id', 'workspace_members.workspace_id')
            ->where('workspace_members.user_id', Auth::id())
            ->where('workspace_members.is_active', 1)
            ->first();
        try {
            if ($wsp) {
                if ($wsp->authorize == "Owner") {
                    if ($workspaceChecked->users->count() == 1) {
                        $wsp->update([
                            'authorize' => AuthorizeEnum::Viewer()
                        ]);
                        $title = "Rời Khỏi Không Gian Làm Việc";
                        $description = 'Bạn đã rời khỏi không gian làm việc "' . $wsp->workspace->name . '". Bạn đang là khách của không gian làm việc này!';
                        if ($wsp->user->id == Auth::id()) {
                            event(new EventNotification($description, 'success', $wsp->user->id));
                        }
                        $wsp->user->notify(new WorkspaceMemberNotification($title, $description, $wsp, 0));
                        return redirect()->route('inbox');
                    } else {
                        return redirect()->route('showFormEditWorkspace')->with([
                            'msg' => 'Bạn phải nhượng quyền mới có thể dời khỏi không gian làm việc',
                            'action' => 'warning'
                        ]);
                    }

                } else {
                    $wsp->update([
                        'authorize' => AuthorizeEnum::Viewer()
                    ]);
                    $title = "Rời Khỏi Không Gian Làm Việc";
                    $description = 'Bạn đã rời khỏi không gian làm việc "' . $wsp->workspace->name . '". Bạn đang là khách của không gian làm việc này!';
                    if ($wsp->user->id == Auth::id()) {
                        event(new EventNotification($description, 'success', $wsp->user->id));
                    }
                    $wsp->user->notify(new WorkspaceMemberNotification($title, $description, $wsp, 0));
                    return redirect()->route('inbox');
                }
            } else {
                return redirect()->route('inbox')->with([
                    'msg' => 'Bạn đã không còn ở không gian làm việc này',
                    'action' => 'warning'
                ]);
            }

        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    //thêm khách vào không gian làm việc
    public function addGuest($id)
    {
        $wsp = WorkspaceMember::with(['user', 'workspace'])->find($id);
        $owner = WorkspaceMember::where('authorize', "Owner")
            ->where('Workspace_id', $wsp->workspace->id)
            ->first();
        try {
            $title = "Lời mời vào không gian làm việc";
            $description = 'Bạn vừa được thêm vào không gian làm việc' . $wsp->workspace->name;
            $wsp->user->notify(new WorkspaceMemberNotification($title, $description, $wsp, 0));
            event(new EventNotification('Bạn đã được thêm vào không gian làm việc ' . $wsp->workspace->name, 'success', $wsp->user->id));
            $wsp->update([
                'authorize' => AuthorizeEnum::Member()
            ]);

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'action' => 'success',
                    'msg' => 'Bạn đã thêm người dùng vào không gian làm việc',
                    'name' => $wsp->user->name,
                    'image' => $wsp->user->image ? Storage::url($wsp->user->image) : null,
                    'owner_id' => $owner->id
                ]);
            }
            return redirect()->route('showFormEditWorkspace')->with([
                'msg' => 'Bạn đã thêm người dùng vào không gian làm việc',
                'action' => 'success'
            ]);
        } catch (\Throwable $th) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'action' => 'error',
                    'msg' => 'Thêm người dùng thất bại',
                ]);
            }
            throw $th;
        }
    }

    //xóa khách khỏi không gian làm việc
    public function deleteGuest($id)
    {
        $wsp = WorkspaceMember::find($id);
        $userBoard = $wsp->relatedBoardMembers;

        try {
            foreach ($userBoard as $item) {
                $item->forceDelete();
            }
            $title = "Loại không gian làm việc";
            $description = 'Bạn vừa bị loại khỏi không gian làm việc ' . $wsp->workspace->name;
            $wsp->user->notify(new WorkspaceMemberNotification($title, $description, $wsp, 0));
            event(new EventNotification('Bạn đã bị loại khỏi không gian làm việc ' . $wsp->workspace->name, 'success', $wsp->user->id));
            $wsp->forceDelete();
            return response()->json([
                'success' => true,
                'action' => 'success',
                'msg' => 'Bạn đã loại người dùng vào không gian làm việc',
            ]);

        } catch (\Throwable $th) {
            throw $th;
        }

    }


    //Thăng cấp thành viên
    //thông báo Done

    public function upgradeMemberShip($wm_id)
    {
        $wspMember = WorkspaceMember::with('user', 'workspace')->find($wm_id);

        if (!$wspMember) {
            return response()->json([
                'success' => false,
                'message' => 'Thành viên không tồn tại!',
                'action' => 'error'
            ], 404);
        }

        $wspMember->update([
            'authorize' => AuthorizeEnum::Sub_Owner()
        ]);

        $this->notificationUpgradeMemberShip($wspMember->workspace->id, $wspMember->user->name);

        // Trả JSON nếu là AJAX
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Thành viên đã được thăng cấp thành công!',
                'action' => 'success',
                'name' => $wspMember->user->name
            ]);
        }

        // Trả redirect nếu không phải AJAX
        return redirect()->route('showFormEditWorkspace')->with([
            'msg' => 'Bạn đã thăng cấp thành viên thành công',
            'action' => 'success'
        ]);
    }

    //Nhượng quyền
    //thông báo Done
    public function managementfranchise($ownerId, $user_id)
    {
        $wspMember = WorkspaceMember::with('user', 'workspace')->find($user_id);
        try {
            WorkspaceMember::find($user_id)->update([
                'authorize' => AuthorizeEnum::Owner()
            ]);

            WorkspaceMember::find($ownerId)->update([
                'authorize' => AuthorizeEnum::Member()
            ]);
            $this->notificationManagementfranchise($wspMember->workspace->id, $wspMember->user->name);

            return redirect()->route('showFormEditWorkspace')->with([
                'msg' => 'Bạn đã nhượng quyền quản trị viên',
                'action' => 'warning'
            ]);
        } catch (\Throwable $th) {
            dd($th);
        }

    }

    //thông báo người dùng tham gia vào không gian làm việc
    protected function notificationMemberInviteWorkspace($workspaceID, $userName)
    {
        $workspace = Workspace::with([
            'users' => function ($query) {
                $query->wherePivot('authorize', '!=', 'Viewer') // Điều kiện lọc 'authorize' không phải là 'Viewer'
                    ->wherePivot('is_accept_invite', 0); // Điều kiện lọc 'is_accept_invite' bằng 0
            }
        ])->find($workspaceID);

        if ($workspace) {
            $workspace->users->each(function ($user) use ($workspace, $userName) {
                $name = 'không gian làm việc ' . $workspace->name;
                $title = 'Thành viên mới trong không gian làm việc';
                $description = 'Người dùng "' . $userName . '" đã được thêm vào không gian làm việc "' . $workspace->name . '".';
                if ($user->id != Auth::id()) {
                    event(new EventNotification('Bạn đã đã được thêm vào không gian làm việc ' . $workspace->name, 'success', $user->id));
                }

                $user->notify(new WorkspaceNotification($user, $workspace, $name, $description, $title));
            });
        }
    }

    //thông báo chỉnh sửa không gian làm việc
    protected function notificationUpdateWorkspaceAccess($workspaceID, $userName)
    {
        $workspace = Workspace::with([
            'users' => function ($query) {
                $query->wherePivot('authorize', '!=', 'Viewer') // Điều kiện lọc 'authorize' không phải là 'Viewer'
                    ->wherePivot('is_accept_invite', 0); // Điều kiện lọc 'is_accept_invite' bằng 0
            }
        ])->find($workspaceID);

        if ($workspace) {

            $workspace->users->each(function ($user) use ($workspace, $userName) {
                $name = 'không gian làm việc ' . $workspace->name;
                $title = 'Chỉnh sửa không gian làm việc';
                $description = 'Người dùng "' . $userName . '" đã thay đổi trạng thái của không gian làm việc sang "' . $workspace->access . '".';

                // broadcast(new EventNotification($description, 'success', 3))->toOthers();
                if ($user->id != Auth::id()) {
                    event(new EventNotification($description, 'success', $user->id));
                }
                $user->notify(new WorkspaceNotification($user, $workspace, $name, $description, $title));
            });
        }
    }

    //Thông báo thăng cấp thành viên
    protected function notificationUpgradeMemberShip($workspaceID, $userName)
    {
        $workspace = Workspace::with([
            'users' => function ($query) {
                $query->wherePivot('authorize', '!=', 'Viewer') // Điều kiện lọc 'authorize' không phải là 'Viewer'
                    ->wherePivot('is_accept_invite', 0); // Điều kiện lọc 'is_accept_invite' bằng 0
            }
        ])->find($workspaceID);

        if ($workspace) {
            $workspace->users->each(function ($user) use ($workspace, $userName) {
                $name = 'không gian làm việc ' . $workspace->name;
                $title = 'Thăng cấp thành viên';
                $description = 'Người dùng "' . $userName . '" đã được thăng cấp lên Phó Nhóm.';
                if ($user->id != Auth::id()) {
                    event(new EventNotification($description, 'success', $user->id));
                }
                $user->notify(new WorkspaceNotification($user, $workspace, $name, $description, $title));
            });
        }
    }

    //Thông báo nhượng quyền
    protected function notificationManagementfranchise($workspaceID, $userName)
    {
        $workspace = Workspace::with([
            'users' => function ($query) {
                $query->wherePivot('authorize', '!=', 'Viewer') // Điều kiện lọc 'authorize' không phải là 'Viewer'
                    ->wherePivot('is_accept_invite', 0); // Điều kiện lọc 'is_accept_invite' bằng 0
            }
        ])->find($workspaceID);

        if ($workspace) {
            $workspace->users->each(function ($user) use ($workspace, $userName) {
                $name = 'không gian làm việc ' . $workspace->name;
                $title = 'Nhượng quyền';
                $description = 'Người dùng "' . $userName . '" đã được nhượng quyền lên Chủ Nhóm.';
                if ($user->id != Auth::id()) {
                    event(new EventNotification($description, 'success', $user->id));
                }
                $user->notify(new WorkspaceNotification($user, $workspace, $name, $description, $title));
            });
        }
    }

    protected function notificationEditWorkspace($workspaceID, $userName)
    {
        $workspace = Workspace::with([
            'users' => function ($query) {
                $query->wherePivot('authorize', '!=', 'Viewer') // Điều kiện lọc 'authorize' không phải là 'Viewer'
                    ->wherePivot('is_accept_invite', 0); // Điều kiện lọc 'is_accept_invite' bằng 0
            }
        ])->find($workspaceID);

        if ($workspace) {
            $workspace->users->each(function ($user) use ($workspace, $userName) {
                $name = 'không gian làm việc ' . $workspace->name;
                $title = 'Chỉnh sửa';
                $description = 'Người dùng "' . $userName . '" đã chỉnh sửa không gian làm việc, xem chi tiết!.';
                if ($user->id != Auth::id()) {
                    event(new EventNotification($description, 'success', $user->id));
                }
                $user->notify(new WorkspaceNotification($user, $workspace, $name, $description, $title));
            });
        }
    }

    //thông báo thêm người dùng vào bảng
    protected function notificationMemberInviteBoard($boardID, $userName)
    {
        // Eager load boardMembers và user, lọc authorize != Viewer
        $board = Board::with([
            'boardMembers' => function ($query) {
                $query->where('authorize', '!=', 'Viewer');
            },
            'boardMembers.user' // Eager load user
        ])->find($boardID);

        if ($board) {
            // Gửi thông báo tới các thành viên hợp lệ
            $board->boardMembers->each(function ($boardMember) use ($board, $userName) {
                $user = $boardMember->user;
                if ($user) {
                    $name = 'Bảng ' . $board->name;
                    $title = 'Thành viên mới trong bảng';
                    $description = 'Người dùng "' . $userName . '" đã được thêm vào bảng "' . $board->name . '".';

                    if ($user->id != Auth::id()) {
                        event(new EventNotification($description, 'success', $user->id));
                    }
                    $user->notify(new BoardNotification($user, $board, $name, $description, $title));
                }
            });
        }
    }
}