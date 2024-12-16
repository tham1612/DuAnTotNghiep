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
use Illuminate\Support\Facades\Log;

class RealtimeTaskKanban implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $task, $boardId, $msg, $catalogIdOld;

    /**
     * Create a new event instance.
     */
    public function __construct(Task $task, $boardId, $msg,?string $catalogIdOld)
    {
        $this->task = $task;
        $this->boardId = $boardId;
        $this->msg = $msg;
        $this->catalogIdOld = $catalogIdOld;
    }


    public function broadcastOn()
    {
        return new Channel('tasks.' . $this->boardId);
//        return new Channel('tasks');
    }

    public function broadcastWith()
    {
        return [
            'tasks' => [
                [
                    'id' => $this->task->id,
                    'text' => $this->task->text,
                    'image' => $this->task->image,
                    'start_date' => $this->task->start_date,
                    'end_date' => $this->task->end_date,
                    'totalMember' => $this->task->members->count(),
                    'totalTag' => $this->task->tags->count(),
                    'priority' => $this->task->priority,
                    'risk' => $this->task->risk,
                    'totalComment' => $this->task->taskComments->count(),
                    'totalChecklist' => $this->task->checklists->count(),
                    'totalAttachment' => $this->task->attachments->count(),
                    'authFlow' => $this->task->followMembers->contains('user_id', auth()->id()),
                    'members' => $this->task->members->map(function ($member) {
                        return [
                            'id' => $member->id,
                            'name' => $member->name,
                            'image' => $member->image,
                        ];
                    }),
                    'tags' => $this->task->tags->map(function ($tag) {
                        return [
                            'name' => $tag->name,
                            'color_code' => $tag->color_code,
                        ];
                    }),
                    'checklists' => $this->task->checklists->map(function ($checklist) {
                        return [
                            'totalChecklist' => $checklist->checklistItems->count(),
                            'totalChecklistComplete' => $checklist->checklistItems->where('is_complete', true),
                        ];
                    }),
                    'totalChecklistComplete' => $this->task->checklists->sum(function ($checklist) {
                        return $checklist->checklistItems->where('is_complete', true)->count();
                    }),
                ]
            ],
            'task' => $this->task,
            'msg' => $this->msg,
            'catalogIdOld' => $this->catalogIdOld,
        ];
    }
}
