<?php

namespace App\Events;

use App\Models\Board;
use App\Models\Task;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class RealtimeBoardArchiver implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $board, $boardId;

    /**
     * Create a new event instance.
     */
    public function __construct(Board $board, $boardId)
    {
        $this->board = $board;
        $this->boardId = $boardId;
    }


    public function broadcastOn()
    {
        return new Channel('boards.' . $this->boardId);
    }

//    public function broadcastWith()
//    {
//        return [
//            'task' => $this->task,
//            'board_id' => $this->task->catalog->board->id,
//        ];
//    }
}
