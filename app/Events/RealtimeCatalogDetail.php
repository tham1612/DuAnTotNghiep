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

class RealtimeCatalogDetail implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $catalog,$boardId;

    public function __construct(Catalog $catalog,$boardId)
    {
        $this->catalog = $catalog;
        $this->boardId = $boardId;
    }


    public function broadcastOn()
    {
        return new Channel('catalogs.'.$this->boardId);
    }

//    public function broadcastWith()
//    {
//        return [
//            'id' => $this->catalog->id,
//            'name' => $this->catalog->name,
//            'board_id' => $this->catalog->board_id,
//        ];
//    }

}
