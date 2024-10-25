<?php

namespace App\Http\Controllers;

use App\Enums\AuthorizeEnum;
use App\Events\UserInvitedToWorkspace;
use App\Http\Requests\UpdateWorkspaceRequest;
use App\Models\Board;
use App\Models\BoardMember;
use App\Models\User;
use App\Models\Workspace;
use App\Models\WorkspaceMember;
use App\Notifications\BoardNotification;
use App\Notifications\WorksaceNotification;
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
    const PATH_UPLOAD = 'workspaces.';

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
                ->causedBy(Auth::user())  // Ghi nhận người thực hiện
                ->performedOn($workspace) // Liên kết với workspace được tạo
                ->withProperties(['workspace_name' => $workspace->name]) // Thông tin bổ sung
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
                }

                //xử lý người dùng kick link invte và workspace đang private
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

    /**
     * sử lý xóa không gian làm việc
     */
    public
        function delete(
        $id
    ) {
        $userId = Auth::id();
        $workspaceAuthorize = WorkspaceMember::query()
            ->select('authorize')
            ->where('user_id', $userId)
            ->where('is_active', 1)
            ->first();
        if ($workspaceAuthorize->authorize->value !== AuthorizeEnum::Owner()->value && $workspaceAuthorize->authorize->value !== AuthorizeEnum::Sub_Owner()->value) {
            return redirect()->route('showFormEditWorkspace')->with([
                'action' => 'error',
                'msg' => 'Bạn không có quyền xóa không gian làm việc'
            ]);
        }
        try {
            $ws = WorkspaceMember::query()->find($id);
            $ws->update([
                'is_active' => 0
            ]);
            $ws->delete();

            activity('Workspace Deleted')
                ->causedBy(Auth::user())
                ->withProperties(['workspace_name' => $ws->name]) // Sử dụng biến $ws thay vì $workspace
                ->log('Người dùng đã xóa không gian làm việc.');

            return redirect()->route('user', $userId)->with([
                'msg' => "Bạn đã xóa Thành công không gian làm việc",
                'action' => 'error'
            ]);
        } catch (\Throwable $th) {
            throw $th;
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
            } elseif ($member->is_accept_invite != 0) {
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
    public function accept_member(Request $request)
    {
        try {
            // Lấy WorkspaceMember
            $workspaceMember = WorkspaceMember::query()
                ->where('user_id', $request->user_id)
                ->where('workspace_id', $request->workspace_id)
                ->with('user') // Eager load user
                ->first(); // Lấy bản ghi đầu tiên

            // Kiểm tra nếu WorkspaceMember tồn tại
            if ($workspaceMember) {
                // Cập nhật các trường is_accept_invite và authorize
                $workspaceMember->update([
                    'is_accept_invite' => 0,
                    'authorize' => "Member"
                ]);

                // Gọi hàm thông báo
                $this->notificationMemberInviteWorkspace($request->workspace_id, $workspaceMember->user->name);
            } else {
                return redirect()->route('showFormEditWorkspace')->with([
                    'msg' => 'Không tìm thấy thành viên trong không gian làm việc',
                    'action' => 'error'
                ]);
            }

            // Trả về phản hồi thành công
            return redirect()->route('showFormEditWorkspace')->with([
                'msg' => 'Đã thêm thành viên vào không gian làm việc',
                'action' => 'success'
            ]);
        } catch (\Exception $e) {
            throw $e; // Hoặc xử lý lỗi bằng cách khác
        }
    }

    //Xóa người dùng gửi lời mời vào wsp
    //thông báo Done
    public function refuse_member($wm_id)
    {
        $wspMember = WorkspaceMember::with(['user', 'workspace'])->find($wm_id);
        try {
            DB::table('workspace_members')->where('id', $wm_id)->delete();

            $title = "Từ chối lời mời";
            $description = 'Bạn đã bị từ chối lời mời vào không gian làm việc ' . $wspMember->workspace->name;
            $wspMember->user->notify(new WorkspaceMemberNotification($title, $description));
            return redirect()->route('showFormEditWorkspace')->with([
                'msg' => 'Bạn đã xóa lời mời vào không gian làm việc của ' . $wspMember->user->name,
                'action' => 'warning'
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    // logic chỉnh sửa ws
    //thông báo Done
    public function editWorkspace(UpdateWorkspaceRequest $request)
    {

        $user = Auth::user();
        $workspaceAuthorize = WorkspaceMember::query()
            ->select('authorize')
            ->where('user_id', $user->id)
            ->where('is_active', 1)
            ->first();
        if ($workspaceAuthorize->authorize->value !== AuthorizeEnum::Owner()->value && $workspaceAuthorize->authorize->value !== AuthorizeEnum::Sub_Owner()->value) {
            return redirect()->route('showFormEditWorkspace')->with([
                'action' => 'error',
                'msg' => 'Bạn không có quyền xóa không gian làm việc'
            ]);
        }
        try {
            $workspace = Workspace::query()
                ->select("*", "workspaces.id as id")
                ->join('workspace_members', 'workspaces.id', 'workspace_members.workspace_id')
                ->where('workspace_members.user_id', $user->id)
                ->where('workspace_members.is_active', 1)
                ->firstOrFail(); // Sử dụng firstOrFail để ném ngoại lệ nếu không tìm thấy

            $validatedData = $request->except('image');
            if ($request->hasFile('image')) {
                $validatedData['image'] = Storage::put(self::PATH_UPLOAD, $request->file('image'));

                $currentImage = $workspace->image;
                if ($currentImage && Storage::exists($currentImage)) {
                    Storage::delete($currentImage);
                }
            }
            // Cập nhật workspace
            $workspace->update($validatedData);
            // Thêm ghi lại hoạt động khi chỉnh sửa workspace
            activity('Workspace Updated')
                ->causedBy(Auth::user()) // Người thực hiện
                ->performedOn($workspace) // Workspace được chỉnh sửa
                ->withProperties(['updated_fields' => $validatedData]) // Các trường đã được chỉnh sửa
                ->log('Người dùng đã chỉnh sửa workspace.');

            $this->notificationEditWorkspace($workspace->id, $user->name);

            return redirect()->route('showFormEditWorkspace')->with([
                'msg' => 'Thay đổi thành công',
                'action' => 'success'
            ]);
        } catch (\Exception $e) {
            // Xử lý ngoại lệ, có thể log lỗi hoặc thông báo cho người dùng
            return redirect()->route('showFormEditWorkspace')->withErrors(['action' => 'Có lỗi xảy ra: ' . $e->getMessage()]);
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
        if ($workspaceAuthorize->authorize->value !== AuthorizeEnum::Owner()->value && $workspaceAuthorize->authorize->value !== AuthorizeEnum::Sub_Owner()->value) {
            return redirect()->route('showFormEditWorkspace')->with([
                'action' => 'danger',
                'msg' => 'Bạn không có quyền xóa không gian làm việc'
            ]);
        }
        try {
            Workspace::query()
                ->join('workspace_members', 'workspaces.id', 'workspace_members.workspace_id')
                ->where('workspace_members.user_id', $user->id)
                ->where('workspace_members.is_active', 1)
                ->update(['access' => $request->access]);
            $this->notificationUpdateWorkspaceAccess($workspaceAuthorize->workspace->id, $user->name);
            return redirect()->route('showFormEditWorkspace')->with([
                'msg' => 'Thay đổi thành công',
                'action' => 'success'

            ]);
        } catch (\Throwable $th) {
            return redirect()->route('showFormEditWorkspace')->withErrors(['action' => 'Có lỗi xảy ra: ' . $th->getMessage()]);
        }
    }

    //gửi mail mời thành viên
    public function inviteUser(Request $request, $workspaceId)
    {
        // Xác thực người dùng
        $userId = Auth::id();

        // Kiểm tra xem workspace có tồn tại không
        $workspace = Workspace::query()
            ->where('id', $workspaceId)
            ->firstOrFail();

        if (!$workspace) {
            return redirect()->route('showFormEditWorkspace')->with([
                'action' => 'danger',
                'msg' => 'Không gửi email thêm thành viên rồi :('

            ]);
        }

        // Validate email từ request
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = $request->input('email');
        $linkInvite = $workspace->link_invite;
        $workspaceName = $workspace->name;
        $authorize = $request->input('authorize');
        // Gửi sự kiện để kích hoạt việc gửi email
        event(new UserInvitedToWorkspace($workspaceName, $email, $linkInvite, $authorize));


        // Thêm ghi lại hoạt động khi gửi lời mời
        activity('Workspace Invitation Sent')
            ->causedBy(Auth::user())  // Người thực hiện
            ->performedOn($workspace) // Workspace liên quan
            ->withProperties(['invited_email' => $email]) // Thông tin người được mời
            ->log('Người dùng đã gửi lời mời thành viên vào workspace.');


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
            $check_user_wsp = WorkspaceMember::where('user_id', $user)->where('workspace_id', $workspace->id)
                ->first();

            //logic sử lý thêm người dùng
            if ($user) {

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
                        }

                        // Người dùng đã đăng nhập nhưng email khác
                        else {
                            Auth::logout();
                            Session::put('invited', "case1");
                            Session::put('workspace_id', $workspace->id);
                            Session::put('user_id', $user->id);
                            Session::put('email_invited', $request->email);
                            Session::put('authorize', $request->authorize);
                            return redirect()->route('login');
                        }
                    }

                    //xử lý khi người dùng có tài khoản và chưa đăng nhập
                    else {
                        Session::put('invited', "case1");
                        Session::put('workspace_id', $workspace->id);
                        Session::put('email_invited', $request->email);
                        Session::put('authorize', $request->authorize);
                        return redirect()->route('login');
                    }

                }

                //xử lý khi người dùng đã ở trong wsp đó rồi
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
        }

        //xử lý khi người dùng kick vào link invite
        else {
            $workspace = Workspace::where('link_invite', 'LIKE', "%$uuid/$token%")->first();
            Auth::logout();
            Session::put('workspace_id', $workspace->id);
            Session::put('access', $workspace->access);
            Session::put('authorize', AuthorizeEnum::Member());
            Session::put('invited', 'case3');
            return redirect()->route('login');
        }

    }

    //Kích thành viên || Rời khỏi không gian làm việc
    //thông báo Done
    public function activateMember($id)
    {
        $user = Auth::user();
        $wsp = WorkspaceMember::with(['user', 'workspace'])->find($id);
        $data = Workspace::find($wsp->workspace_id)->with([
            'boards' => function ($query) use ($user) {
                $query->whereHas('boardMembers', function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                });
            },
        ])
            ->where('id', $wsp->workspace_id)
            ->first();
        try {

            if (!empty($data->boards)) {
                dd('a');

                $wsp->update([
                    'authorize' => AuthorizeEnum::Viewer()
                ]);
                $title = "Bạn đã xóa khỏi vào không gian làm việc";
                $description = 'Bạn đã xóa khỏi vào không gian làm việc ' . $wsp->workspace->name;
                $wsp->user->notify(new WorkspaceMemberNotification($title, $description));
            } else {
                dd('b');
                $wsp->delete();

                $title = "Bạn đã xóa khỏi vào không gian làm việc";
                $description = 'Bạn đã xóa khỏi vào không gian làm việc ' . $wsp->workspace->name;
                $wsp->user->notify(new WorkspaceMemberNotification($title, $description));
                return redirect()->route('b.create');
            }
            return redirect()->route('showFormEditWorkspace')->with([
                'msg' => 'Bạn đã kích thành viên ra khỏi không gian làm việc',
                'action' => 'warning'
            ]);
        } catch (\Throwable $th) {
            dd($th);
        }
    }
  
    //Thăng cấp thành viên
    //thông báo Done
    public function upgradeMemberShip($wm_id)
    {
        $wspMember = WorkspaceMember::with('user', 'workspace')->find($wm_id);
        $wspMember->update([
            'authorize' => AuthorizeEnum::Sub_Owner()
        ]);
        $this->notificationUpgradeMemberShip($wspMember->workspace->id, $wspMember->user->name);
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
                $user->notify(new WorksaceNotification($user, $workspace, $name, $description, $title));
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
                $user->notify(new WorksaceNotification($user, $workspace, $name, $description, $title));
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
                $user->notify(new WorksaceNotification($user, $workspace, $name, $description, $title));
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
                $user->notify(new WorksaceNotification($user, $workspace, $name, $description, $title));
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
                $description = 'Người dùng "' . $userName . '" Chỉnh sửa không gian làm việc, xem chi tiết!.';
                $user->notify(new WorksaceNotification($user, $workspace, $name, $description, $title));
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
                    $user->notify(new BoardNotification($user, $board, $name, $description, $title));
                }
            });
        }
    }
}
