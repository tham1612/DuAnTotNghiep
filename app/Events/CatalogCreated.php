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

class CatalogCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $catalog;
    public function __construct(Catalog $catalog)
    {
      $this->catalog=$catalog;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
        return
            new Channel('catalog');

    }
     public function broadcastWith()
    {
        return [
            'id'=>$this->catalog->id,
            'name'=>$this->catalog->name,
            'board_id'=>$this->catalog->board_id,
        ];
    }
    public function broadcastAs()
    {
        return 'CatalogCreated';
    }
}
