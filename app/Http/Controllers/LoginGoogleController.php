<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Workspace;
use App\Models\WorkspaceMember;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;


class LoginGoogleController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }


    public function handleGoogleCallback()
    {

        try {
            $userMain = Socialite::driver('google')->user();
            $finduser = User::where('email', $userMain->email)->first();
            if ($finduser) {

                /// sử lý thêm người dùng vào workspace
                //xử lý khi thêm người dùng vào wsp mà người đó có tài khoản nhưng đang login tk khác của task flow
                if (Session::get('invited') == "case1") {

                    //xử lý trường hợp người dùng đăng nhập  đúng email được gửi link mời
                    if (Session::get('email_invited') == $userMain->email) {
                        $user = Auth::user();
                        try {
                            //thêm người dùng vào workspace member
                            WorkspaceMember::create([
                                'user_id' => $user->name,
                                'workspace_id' => Session::get('workspace_id'),
                                'authorize' => Session::get('authorize'),
                                'invite' => now(),
                                'is_active' => 1,
                            ]);
                            $wsp = Workspace::find(Session::get('workspace_id'));

                            //query workspace_member vừa tạo
                            $wm = WorkspaceMember::query()
                                ->where('workspace_members.user_id', $user->name)
                                ->where('workspace_id', Session::get('workspace_id'))
                                ->first();

                            //xử lý update is_active
                            WorkspaceMember::query()
                                ->where('user_id', $user->name)
                                ->whereNot('id', $wm->id)
                                ->update(['is_active' => 0]);
                            WorkspaceMember::query()
                                ->where('id', $wm->id)
                                ->update(['is_active' => 1]);
                            //thông báo
                            $this->notificationMemberInviteWorkspace(Session::get('workspace_id'), $user->name);
                            //xóa hết tất cả các session đã set
                            Session::forget('invited');
                            Session::forget('user_id');
                            Session::forget('workspace_id');
                            Session::forget('email_invited');
                            Session::forget('authorize');
                            session()->flash('action', 'success');
                            session()->flash('msg', "Bạn đã được thêm vào trong không gian làm việc. \"{$wsp->name}\" !!!");
                            // return redirect()->route('home')->with([
                            //     'action' => 'success',
//     'msg' => "Bạn đã được thêm vào trong không gian làm việc. \"{$wsp->name}\" !!!"
                            // ]);
                        } catch (\Throwable $th) {
                            throw $th;
                        }
                    }

                    //xử lý trường hợp người dùng nhưng không đăng nhập  đúng email được gửi link mời
                    else {
                        Session::forget('invited');
                        Session::forget('workspace_id');
                        Session::forget('email_invited');
                        Session::forget('authorize');
                    }
                }

                //xử lý người dùng kick vào link invite
                else if (Session::get('invited') == "case3") {
                    $user = User::where('email', $userMain->email)->first();
                    //xử lý thêm người dùng nếu mà kick vào link invite mà
                    //workspace đang public thì vào luôn

                    //check xem thằng này đã có trong wsp chưa
                    $userCheck = WorkspaceMember::where('user_id', $user->id)
                        ->where('workspace_id', Session::get('workspace_id'))->first();
                    if (Session::get('access') == 'public') {

                        try {
                            //thêm người vào database

                            if (!$userCheck) {
                                WorkspaceMember::create([
                                    'user_id' => $user->id,
                                    'workspace_id' => Session::get('workspace_id'),
                                    'authorize' => Session::get('authorize'),
                                    'invite' => now(),
                                    'is_active' => 1,
                                ]);
                            }
                            //xử lý update is_active
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
                            //xóa tất cả session đã set
                            Session::forget('workspace_id');
                            Session::forget('invited');
                            Session::forget('authorize');
                            Session::forget('access');

                            return redirect()->route('home')->with([
                                'msg' => 'Bạn đã tham gia vào không gian làm việc',
                                'action' => 'success'
                            ]);
                        } catch (\Throwable $th) {
                            dd($th);
                        }
                    }

                    // xử lý người dùng kick vào link invite và workspace đang private
                    else {

                        try {
                            if (!$userCheck) {
                                WorkspaceMember::query()->create([
                                    'user_id' => $user->id,
                                    'workspace_id' => Session::get('workspace_id'),
                                    'authorize' => "Viewer",
                                    'invite' => now(),
                                    'is_active' => 0,
                                    'is_accept_invite' => 1,
                                ]);
                                //xóa tất cả session đã set
                                Session::forget('workspace_id');
                                Session::forget('invited');
                                Session::forget('authorize');
                                Session::forget('access');
                            }

                            //xóa tất cả session đã set
                            Session::forget('workspace_id');
                            Session::forget('invited');
                            Session::forget('authorize');
                            Session::forget('access');
                            session()->flash('action', 'success');
                            session()->flash('msg', "Chờ quản trị viên duyệt!");

                        } catch (\Throwable $th) {
                            dd($th);
                        }
                    }
                }

                /// END. sử lý thêm người dùng vào workspace

                //-----------------------------------Xử lý người dùng thêm vào bảng--------------------------------------------//


                //xử lý khi thêm người dùng vào bảng mà người đó có tài khoản nhưng đang login tk khác của task flow
                else if (Session::get('invited_board') == "case1") {
                    //xử lý người dùng khi đăng nhập đúng email
                    if (Session::get('email_invited') == $userMain->email) {
                        try {
                            //thêm người dùng vào workspace member
                            BoardMember::create([
                                'user_id' => Session::get('user_id'),
                                'board_id' => Session::get('board_id'),
                                'authorize' => Session::get('authorize'),
                                'invite' => now(),
                            ]);

                            $board = Board::find(Session::get('board_id'));
                            $this->notificationMemberInviteBoard(Session::get('board_id'), auth()->user()->name);
                            Session::forget('invited_board');
                            Session::forget('user_id');
                            Session::forget('board_id');
                            Session::forget('email_invited');
                            Session::forget('authorize');
                            session()->flash('action', 'success');
                            session()->flash('msg', "Bạn đã được thêm vào trong bảng. \"{$board->name}\" !!!");
                            // return redirect()->route('b.edit', $board->id)->with([
                            //     'msg' => "Bạn đã được thêm vào trong bảng. \"{$board->name}\" !!!",
                            //     'action' => 'success'
                            // ]);
                        } catch (\Throwable $th) {
                            throw $th;
                        }
                    }

                    //xử lý trường hợp người dùng nhưng không đăng nhập  đúng email được gửi link mời
                    else {

                        Session::forget('invited_board');
                        Session::forget('user_id');
                        Session::forget('board_id');
                        Session::forget('email_invited');
                        Session::forget('authorize');
                    }
                }

                //xử lý người dùng kick vào link invite
                else if (Session::get('invited_board') == "case3") {

                    $user = User::where('email', $userMain->email)->first();
                    $check_user_wsp = WorkspaceMember::where('user_id', $user->id)->where('workspace_id', Session::get('workspace_id'))
                        ->first();
                    $check_user_board = BoardMember::where('user_id', $user->id)
                        ->where('board_id', Session::get('board_id'))
                        ->first();

                    if ($check_user_wsp) {
                        if (!$check_user_board) {
                            //xử lý nếu bảng public
                            if (Session::get('board_access') == "public") {
                                try {
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
                                    session()->flash('action', 'success');
                                    session()->flash('msg', "Bạn đã tham gia vào Bảng");
                                    // return redirect()->route('home')->with([
                                    //     'msg' =>
                                    //     'Bạn đã tham gia vào Bảng',
                                    //     'action' => 'success'
                                    // ]);
                                } catch (\Throwable $th) {
                                    throw $th;
                                }
                            }
                            //xử lý nếu bảng private
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
                                session()->flash('action', 'success');
                                session()->flash('msg', "Chờ quản trị viên duyệt bạn vào bảng");
                                // return redirect()->route('home')->with([
//     'msg' =>
                                //     'Chờ quản trị viên duyệt bạn vào bảng',
                                //     'action' => 'danger'
                                // ]);
                            }
                        } else {
                            //
                            if ($check_user_wsp->is_active == 1) {
                                session(['msg' => 'Bạn đã ở trong bảng rồi']);
                                session(['action' => 'success']);
                                $boardId = Session::get('board_id');
                                Session::forget('board_id');
                                Session::forget('workspace_id');
                                Session::forget('board_access');
                                Session::forget('authorize');
                                Session::forget('invited_board');
                                return redirect()->route('b.edit', $boardId);
                            } else {
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
                                session(['msg' => 'Bạn đã ở trong bảng rồi']);
                                session(['action' => 'success']);
                                $boardId = Session::get('board_id');
                                Session::forget('board_id');
                                Session::forget('workspace_id');
                                Session::forget('board_access');
                                Session::forget('authorize');
                                Session::forget('invited_board');
                                return redirect()->route('b.edit', $boardId);
                            }
                        }
                    }
                }

                //xử lý khi người dùng chưa trong wsp và chưa trong bảng
                //nhưng đã có tài khoản mà đang đăng nhập email khác
                else if (Session::get('invited_board') == "case4") {
                    //xử lý khi người dùng đăng nhập đúng email
                    if (Session::get('email_invited') == $userMain->email) {
                        try {
//Thêm người dung vào workspace
                            WorkspaceMember::create([
                                'user_id' => Session::get('user_id'),
                                'workspace_id' => Session::get('workspace_id'),
                                'authorize' => AuthorizeEnum::Viewer(),
                                'invite' => now(),
                                'is_active' => 1,
                            ]);
                            //thêm người dùng vào board member
                            BoardMember::create([
                                'user_id' => Session::get('user_id'),
                                'board_id' => Session::get('board_id'),
                                'authorize' => Session::get('authorize'),
                                'invite' => now(),
                            ]);
                            $board = Board::find(Session::get('board_id'));

                            $wm = WorkspaceMember::query()
                                ->where('workspace_members.user_id', Session::get('user_id'))
                                ->where('workspace_id', Session::get('workspace_id'))
                                ->first();

                            //xử lý update is_active
                            WorkspaceMember::query()
                                ->where('user_id', Session::get('user_id'))
                                ->whereNot('id', $wm->id)
                                ->update(['is_active' => 0]);
                            WorkspaceMember::query()
                                ->where('id', $wm->id)
                                ->update(['is_active' => 1]);

                            Session::forget('workspace_id');
                            Session::forget('invited_board');
                            Session::forget('user_id');
                            Session::forget('board_id');
                            Session::forget('email_invited');
                            Session::forget('authorize');
                            session()->flash('action', 'success');
                            session()->flash('msg', "Bạn đã được thêm vào trong bảng. \"{$board->name}\" !!!");
                            // return redirect()->route('b.edit', $board->id)->with([
                            //     'msg' =>
                            //     "Bạn đã được thêm vào trong bảng. \"{$board->name}\" !!!",
                            //     'action' => 'success'
                            // ]);
                        } catch (\Throwable $th) {
                            throw $th;
                        }
                    }
                    //xử lý trường hợp người dùng nhưng không đăng nhập  đúng email được gửi link mời
                    else {
                        Session::forget('workspace_id');
                        Session::forget('invited_board');
                        Session::forget('user_id');
                        Session::forget('board_id');
                        Session::forget('email_invited');
                        Session::forget('authorize');
                        session()->flash('action', 'success');
                        session()->flash('msg', "Bạn không đăng nhập đúng email được mời");
                        // return redirect()->route('home')->with([
                        //     'msg' =>
                        //     'Bạn không đăng nhập đúng email được mời',
                        //     'action' => 'success'
                        // ]);
                    }
                }
                ///END.
                Auth::login($finduser);
                // if (empty($finduser->password)) {
                //     return redirect()->route('password.request')->with('message', 'Vui lòng đặt mật khẩu mới cho tài khoản của bạn.');
                // }

                return redirect()->intended('home');
            } else {
                $newUser = User::create([
                    'name' => $userMain->name,
                    'email' => $userMain->email,
                    'social_id' => $userMain->id,
                    'password' => ''
                ]);
                Auth::login($newUser);
                // return redirect()->route('password.request')->with('message', 'Vui lòng đặt mật khẩu mới cho tài khoản của bạn.');
                return redirect()->intended('home');
            }
        } catch (Exception $e) {
            Log::error('Error during Google OAuth callback: ' . $e->getMessage());
            return redirect('/login')->with('error', 'Có lỗi xảy ra khi xác thực Google.');
        }
    }
}
