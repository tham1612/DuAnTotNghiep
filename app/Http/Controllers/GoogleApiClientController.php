<?php

namespace App\Http\Controllers;

use Google_Client;
use Google_Service_Calendar;
use Illuminate\Http\Request;

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
        //        User::query()
        //            ->where('id', auth()->id())
        //            ->update([
        //                'remember_token' => json_encode($client->getAccessToken())
        // ]);

        return redirect()->route('home');
    }
}
