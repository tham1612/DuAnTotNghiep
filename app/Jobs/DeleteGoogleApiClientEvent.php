<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class DeleteGoogleApiClientEvent implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $accessToken;
    protected $id;
    protected $userOrTaskId;

    /**
     * Create a new job instance.
     */
    public function __construct($accessToken, $id, $userOrTaskId)
    {
        $this->accessToken = $accessToken;
        $this->id = $id;
        $this->userOrTaskId = $userOrTaskId;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $client = $this->getClient();
        $accessToken = $this->accessToken;
        if ($accessToken) {
            $client->setAccessToken($accessToken);

            if ($client->isAccessTokenExpired()) {
                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
                User::query()
                    ->where('id', $this->userOrTaskId['user_id'])
                    ->update([
                        'access_token' => $client->getAccessToken()
                    ]);
            }
            $service = new \Google_Service_Calendar($client);

            $service->events->delete('primary', $this->id);
        }
    }

    public function getClient()
    {
        $client = new \Google_Client();
        $client->setAuthConfig(storage_path('app/google-calendar/credentials.json'));
        $client->addScope(\Google_Service_Calendar::CALENDAR);
        $client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));
        $client->setAccessType('offline'); // Lấy refresh token để dùng lâu dài
        $client->setPrompt('consent');

        return $client;
    }
}
