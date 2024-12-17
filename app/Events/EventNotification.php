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

    public $load;
    public function __construct($message, $action, $userId, ?bool $load = NULL)
    {
        $this->message = $message;
        $this->action = $action;
        $this->userId = $userId;
        $this->load = $load;
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
            'load' => $this->load,
        ];
    }
}
