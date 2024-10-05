<?php

namespace App\Listeners;

use App\Events\UserInvitedToBoard;
use App\Mail\InviteBoardMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
class SendInviteEmailBoard
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
    public function handle(UserInvitedToBoard $event): void
    {
        Mail::to($event->email)->send(new InviteBoardMail($event->boardName, $event->linkInvite, $event->email, $event->authorize));
        
    }
}
