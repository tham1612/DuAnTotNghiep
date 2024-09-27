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
            DB::commit();

            return redirect()->route('home');

        } catch (\Exception $exception) {
            DB::rollBack();
//            dd($exception->getMessage());
            return back()->with('error', 'Error: ' . $exception->getMessage());
        }
    }


    /**
     * Display the specified resource.
     */
    public
    function show(
        string $id
    )
    {
        //        $model = Workspace::query()->findOrFail($id);
//         return view('workspaces.edit',compact('model'));
//        $data = $request->except('image');
//        if ($request->hasFile('image')) {
//            $data['image'] = Storage::put(self::PATH_UPLOAD, $request->file('image'));
//        }
//        $data['access'] = $data['access'] ?? 'private';
    }

    /**
     * Show the form for editing the specified resource.
     */
    public
    function edit(
        string $id
    )
    {
        $model = Workspace::query()->findOrFail($id);
        return view('workspaces.edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     */
    public
    function update(
        Request $request,
        string  $id
    )
    {
        $model = Workspace::query()->findOrFail($id);
    }

    /**
     * Remove the specified resource from storage.
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
        return view('workspaces.update', compact('userId', 'userName', 'workspaceChecked', 'icon', 'access', 'ws_desrip'));
    }

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
                dd($validatedData);
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
    public function inviteUser(Request $request, $workspaceId)
    {
        // Xác thực người dùng
        $userId = Auth::id();

        // Kiểm tra xem workspace có tồn tại không
        $workspace = Workspace::query()
            ->select("*", "workspaces.id as id")
            ->join('workspace_members', 'workspaces.id', 'workspace_members.workspace_id')
            ->where('workspace_members.user_id', $userId)
            ->where('workspace_members.is_active', 1)
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
        $workspace = Workspace::where('link_invite', 'LIKE', "%$uuid/$token%")->first();
        $user = User::query()->where('email', $request->email)->first();

        if ($user) {
            //xử lý khi người dùng có tài khoản
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
                    Session::put('invited', "Yes");
                    Session::put('workspace_id', $workspace->id);
                    Session::put('user_id', $user->id);
                    Session::put('email_invited', $request->email);
                    return redirect()->route('login');

                }
            }
        } else {
            //xử lý khi người dùng không có tài khoản
        }

    }


}
