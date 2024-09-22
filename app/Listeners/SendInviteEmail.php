<?php

namespace App\Listeners;

use App\Events\UserInvitedToWorkspace;
use App\Mail\InviteWorkspaceMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendInviteEmail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserInvitedToWorkspace $event): void
    {
        Mail::to($event->email)->send(new InviteWorkspaceMail($event->workspaceName, $event->linkInvite, $event->email));
    }
}
