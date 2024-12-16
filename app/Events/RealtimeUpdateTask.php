<?php

namespace App\Events;

use App\Models\Task;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RealtimeUpdateTask implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $task, $boardId;

    /**
     * Create a new event instance.
     */
    public function __construct(Task $task, $boardId)
    {
        $this->task = $task;
        $this->boardId = $boardId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
        return new Channel('tasks.' . $this->boardId);
    }
    public function broadcastWith()
    {
        return [
            'task' => $this->task,
//            'catalog_name' => $this->task->catalog->name,
        ];
    }
}
