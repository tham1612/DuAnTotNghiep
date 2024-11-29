<?php

namespace App\Events;

use App\Models\Catalog;
use App\Models\Task;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class RealtimeTaskArchiver implements ShouldBroadcast
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


    public function broadcastOn()
    {
        return new Channel('tasks.' . $this->boardId);
//        return new Channel('tasks');
    }

    public function broadcastWith()
    {
        return [
            'task' => $this->task,
            'countCatalog' => Catalog::query()->findOrFail($this->task->catalog_id)->tasks->count(),
        ];
    }
}
