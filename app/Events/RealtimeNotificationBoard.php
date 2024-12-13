<?php

namespace App\Events;

use App\Models\Catalog;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RealtimeNotificationBoard implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $msg, $boardId;

    public function __construct($msg, $boardId)
    {
        $this->msg = $msg;
        $this->boardId = $boardId;
    }


    public function broadcastOn()
    {
        return new Channel('boards.' . $this->boardId);
    }


}
