<?php

namespace App\Events;

use App\Models\CostAmount;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CostAmountDeleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public CostAmount $costAmount;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(CostAmount $costAmount)
    {
        $this->costAmount = $costAmount;
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
