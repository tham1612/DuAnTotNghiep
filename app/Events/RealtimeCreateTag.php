<?php

namespace App\Events;

use App\Models\Tag;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RealtimeCreateTag implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $tag, $boardId,$taskId;

    /**
     * Create a new event instance.
     */
    public function __construct( Tag $tag,$boardId,$taskId)
    {
        $this->tag = $tag;
        $this->taskId = $taskId;
        $this->boardId = $boardId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
        return new Channel('tags.' . $this->boardId);
    }
    public function broadcastWith()
    {
        return [
            'board_id'=>$this->boardId,
            'task_id' => $this->taskId,
            'tagTaskName' => $this->tag->name,
            'tagTaskColor' => $this->tag->color_code,
            'tag_id' => $this->tag->id,
        ];
    }
}
