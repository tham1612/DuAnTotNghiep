<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Log;

class EventNotification implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    /**
     * Create a new event instance.
     */

    public $message;
    public $action;
    public $userId;
    // public $data;
    public function __construct($message, $action, $userId)
    {
        $this->message = $message;
        $this->action = $action;
        $this->userId = $userId;
        // $this->data = $data;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
        Log::info($this->userId);
        return new PrivateChannel("notifications." . $this->userId);
    }

    public function broadcastWith()
    {
        return [
            'userId' => $this->userId,
            'action' => $this->action,
            'message' => $this->message,
            'data' => $this->data,
        ];
    }
}
