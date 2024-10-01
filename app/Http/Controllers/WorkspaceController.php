<?php

namespace App\Http\Controllers;

use App\Enums\AuthorizeEnum;
use App\Events\UserInvitedToWorkspace;
use App\Http\Requests\UpdateWorkspaceRequest;
use App\Models\User;
use App\Models\Workspace;
use App\Models\WorkspaceMember;
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
        $userId = \Illuminate\Support\Facades\Auth::id();
        //        dd($userId);
        WorkspaceMember::query()
            ->where('user_id', auth()->id())
            ->whereNot('id', $id)
            ->update(['is_active' => 0]);
        WorkspaceMember::query()
            ->where('id', $id)
            ->update(['is_active' => 1]);
        return view('homes.home');
    }

    public function create()
    {
        Log::debug(Auth::check());
        Log::debug(Auth::user()->hasWorkspace());
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
            //           update lai cot is_active khi tao ws moi
            WorkspaceMember::query()
                ->where('user_id', auth()->id())
                ->whereNot('id', $workspaceMember->id)
                ->update(['is_active' => 0]);



            // lưu lại hoạt động
            activity('Board Create')
            ->causedBy(Auth::user())
            ->withProperties('board_name',$workspace->name)
            ->tap(function(Activity $activity)use ($workspace){
             $activity->Workspace_id = $workspace->id;
            })
            ->log('người dùng đã tạo bảng mới trong ws');


            //xử lý thêm người dùng khi người dùng đăng ký qua nhập link mời
            if (Session::get('invited') == "case2") {
                $user = Auth::user();
                //xử lý trường hợp người dùng đăng nhập  đúng email được gửi link mời
                if (Session::get('email_invited') == $user->email) {
                    try {
                        //thêm người dùng vào workspace member
                        WorkspaceMember::create([
                            'user_id' => $user->id,
                            'workspace_id' => Session::get('workspace_id'),
                            'authorize' => AuthorizeEnum::Member,
                            'invite' => now(),
                            'is_active' => 1,
                        ]);

                        // ghi lại hoạt động khi thêm người dùng vào ws

                        activity('Thêm người dùng vào WS')
                        ->causedBy(Auth::user())
                        ->withProperties(['added_user_id'=> $user->id])
                        ->tap(function (Activity $activity) use ($workspace){
                            $activity->Workspace_id = $workspace->id;
                        })
                        ->log('add người thành công vào ws');

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
                    } catch (\Throwable $th) {
                        throw $th;
                    }
                }
            }
            DB::commit();


            return redirect()->route('home');

        } catch (\Exception $exception) {
            DB::rollBack();
            dd($exception->getMessage());
            return back()->with('error', 'Error: ' . $exception->getMessage());
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
        try {
            $ws_replace = WorkspaceMember::query()
                ->where('workspace_members.user_id', $userId)
                ->whereNot('id', $id)->first();
            $ws = WorkspaceMember::query()->find($id);
            $ws->delete();

            //xử lý logic sau khi xóa
            WorkspaceMember::query()
                ->where('user_id', $userId)
                ->whereNot('id', $ws_replace->id)
                ->update(['is_active' => 0]);
            WorkspaceMember::query()
                ->where('id', $ws_replace->id)
                ->update(['is_active' => 1]);

            return redirect()->route('user', $userId)->with('msg', "Bạn đã xóa Thành công không gian làm việc");
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
            ->select('*', 'workspaces.id as id', 'workspace_members.id as wm_id')
            ->join('workspace_members', 'workspaces.id', 'workspace_members.workspace_id')
            ->where('workspace_members.user_id', $userId)
            ->where('workspace_members.is_active', 1)
            ->first();

        //get thông tin cho modal thêm thành viên
        //lấy thằng chủ ws
        $wsp_owner = WorkspaceMember::query()
            ->select('*', 'users.id as user_id')
            ->join('users', 'users.id', 'workspace_members.user_id')
            ->where('workspace_id', $workspaceChecked->workspace_id)
            ->where('authorize', AuthorizeEnum::Owner())
            ->first();
        //lấy thằng member ws
        $wsp_member = WorkspaceMember::query()
            ->select('*', 'users.id as user_id')
            ->join('users', 'users.id', 'workspace_members.user_id')
            ->where('workspace_id', $workspaceChecked->workspace_id)
            ->whereNot('authorize', AuthorizeEnum::Owner())
            ->where('is_accept_invite', NULL)
            ->get();
        //lấy yêu cầu tham gia
        $wsp_invite = WorkspaceMember::query()
            ->select('*', 'users.id as user_id', 'workspace_members.id as wm_id')
            ->join('users', 'users.id', 'workspace_members.user_id')
            ->where('workspace_id', $workspaceChecked->workspace_id)
            ->whereNot('is_accept_invite', NULL)->get();

        // dd($wsp_invite);
        //lấy số người có trong bảng nhưng không có trong wsp

        // dd($wsp_owner);
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

        return view('workspaces.update', compact('userId', 'userName', 'workspaceChecked', 'icon', 'access', 'ws_desrip', 'wsp_owner', 'wsp_member', 'wsp_invite', 'userId'));
    }

    //Duyệt người dùng gửi lời mời vào wsp
    public function accept_member(Request $request)
    {
        try {
            $isAcceptInvite = $request->type_update === 'NULL' ? null : $request->type_update;

            WorkspaceMember::query()
                ->where('user_id', $request->user_id)
                ->where('workspace_id', $request->workspace_id)
                ->update(['is_accept_invite' => $isAcceptInvite]);
            return redirect()->route('showFormEditWorkspace');
        } catch (\Exception $e) {
            throw $e;
        }
    }

    //Xóa người dùng gửi lời mời vào wsp
    public function refuse_member($wm_id)
    {
        try {
            DB::table('workspace_members')->where('id', $wm_id)->delete();
            return redirect()->route('showFormEditWorkspace');
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    // logic chỉnh sửa ws
    public function editWorkspace(UpdateWorkspaceRequest $request)
    {
        $userId = Auth::id();

        try {
            $workspace = Workspace::query()
                ->select("*", "workspaces.id as id")
                ->join('workspace_members', 'workspaces.id', 'workspace_members.workspace_id')
                ->where('workspace_members.user_id', $userId)
                ->where('workspace_members.is_active', 1)
                ->firstOrFail(); // Sử dụng firstOrFail để ném ngoại lệ nếu không tìm thấy
            // dd($workspace);
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
            return redirect()->route('showFormEditWorkspace')->with('msg', 'Thay đổi thành công');
        } catch (\Exception $e) {
            // Xử lý ngoại lệ, có thể log lỗi hoặc thông báo cho người dùng
            return redirect()->route('showFormEditWorkspace')->withErrors(['msg' => 'Có lỗi xảy ra: ' . $e->getMessage()]);
        }
    }
    //chỉnh sửa công khai hoặc riêng tư
    public function update_ws_access(Request $request)
    {
        $userId = Auth::id();
        try {
            Workspace::query()
                ->join('workspace_members', 'workspaces.id', 'workspace_members.workspace_id')
                ->where('workspace_members.user_id', $userId)
                ->where('workspace_members.is_active', 1)
                ->update(['access' => $request->access]);

            return redirect()->route('showFormEditWorkspace')->with('msg', 'Thay đổi thành công');
        } catch (\Throwable $th) {
            return redirect()->route('showFormEditWorkspace')->withErrors(['msg' => 'Có lỗi xảy ra: ' . $th->getMessage()]);
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
            return redirect()->route('showFormEditWorkspace')->with('error', 'Không gửi email thêm thành viên rồi :(');
        }

        // Validate email từ request
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = $request->input('email');
        $linkInvite = $workspace->link_invite;
        $workspaceName = $workspace->name;
        // Gửi sự kiện để kích hoạt việc gửi email
        event(new UserInvitedToWorkspace($workspaceName, $email, $linkInvite));

        return redirect()->route('showFormEditWorkspace')->with('msg', 'Đã gửi email thêm thành viên !!!');
    }

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
                                    'authorize' => AuthorizeEnum::Member,
                                    'invite' => now(),
                                    'is_active' => 1,
                                ]);

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

                                return redirect()->route('home')->with('msg', "Bạn đã được thêm vào trong không gian làm việc. \"{$workspace->id}\" !!!");

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
                            return redirect()->route('login');
                        }
                    }
                    //xử lý khi người dùng có tài khoản và chưa đăng nhập
                    else {
                        Session::put('invited', "case1");
                        Session::put('workspace_id', $workspace->id);
                        Session::put('user_id', $user->id);
                        Session::put('email_invited', $request->email);
                        return redirect()->route('login');
                    }
                }
                //xử lý khi người dùng đã ở trong wsp đó rồi
                else {
                    return redirect()->route('home');
                }
            } else {
                //xử lý khi người dùng không có tài khoản
                Auth::logout();
                Session::put('workspace_id', $workspace->id);
                Session::put('invited', 'case2');
                Session::put('email_invited', $request->email);
                return redirect()->route('register');
            }
        }
        //xử lý khi người dùng kick vào link invite
        else {
            $workspace = Workspace::where('link_invite', 'LIKE', "%$uuid/$token%")->first();
            Auth::logout();
            Session::put('workspace_id', $workspace->id);
            Session::put('invited', 'case3');
            return redirect()->route('login');
        }


    }



}
