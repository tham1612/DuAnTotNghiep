<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            $user = Socialite::driver('google')->user();
            $finduser = User::where('email', $user->email)->first();
            if ($finduser) {
                Auth::login($finduser);

                // if (empty($finduser->password)) {
                //     return redirect()->route('password.request')->with('message', 'Vui lòng đặt mật khẩu mới cho tài khoản của bạn.');
                // }

                return redirect()->intended('home');
            } else {
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'social_id' => $user->id,
                    'password' => ''
                ]);
                Auth::login($newUser);
                // return redirect()->route('password.request')->with('message', 'Vui lòng đặt mật khẩu mới cho tài khoản của bạn.');
                return redirect()->intended('home');
            }
        } catch (Exception $e) {
            \Log::error('Error during Google OAuth callback: ' . $e->getMessage());
            return redirect('/login')->with('error', 'Có lỗi xảy ra khi xác thực Google.');
        }
    }
}
