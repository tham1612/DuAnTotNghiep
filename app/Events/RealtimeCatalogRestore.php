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

class RealtimeCatalogRestore implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $catalog, $boardId, $msg;

    public function __construct($catalog, $boardId, $msg)
    {
        $this->catalog = $catalog;
        $this->boardId = $boardId;
        $this->msg = $msg;
    }


    public function broadcastOn()
    {
        return new Channel('catalogs.' . $this->boardId);
    }

    public function broadcastWith()
    {
        return [
            'tasks' => $this->catalog->tasks->map(function ($task) {
                return [
                    'id' => $task->id,
                    'text' => $task->text,
                    'image' => $task->image,
                    'start_date' => $task->start_date,
                    'end_date' => $task->end_date,
                    'totalMember' => $task->members->count(),
                    'totalTag' => $task->tags->count(),
                    'priority' => $task->priority,
                    'risk' => $task->risk,
                    'totalComment' => $task->taskComments->count(),
                    'totalChecklist' => $task->checklists->count(),
                    'totalAttachment' => $task->attachments->count(),
                    'authFlow' => $task->followMembers->contains('user_id', auth()->id()),
                    'members' => $task->members->map(function ($member) {
                        return [
                            'id' => $member->id,
                            'name' => $member->name,
                            'image' => $member->image,
                        ];
                    }),
                    'tags' => $task->tags->map(function ($tag) {
                        return [
                            'name' => $tag->name,
                            'color_code' => $tag->color_code,
                        ];
                    }),
                    'checklists' => $task->checklists->map(function ($checklist) {
                        return [
                            'totalChecklist' => $checklist->checklistItems->count(),
                            'totalChecklistComplete' => $checklist->checklistItems->where('is_complete', true),
                        ];
                    })
                ];
            }),
            'catalog' => $this->catalog,
            'msg' => $this->msg
        ];
    }

}
