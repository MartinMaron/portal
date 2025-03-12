<?php

namespace App\Events;

use App\Models\Cost;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CostUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Cost $cost;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Cost $cost)
    {
        $this->cost = $cost;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
