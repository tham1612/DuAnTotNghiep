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

class RealtimeCreateCatalog implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $catalog;

    public function __construct(Catalog $catalog)
    {
        $this->catalog = $catalog;
    }


    public function broadcastOn()
    {
        return new Channel('catalogs');
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->catalog->id,
            'name' => $this->catalog->name,
            'board_id' => $this->catalog->board_id,
        ];
    }

}
