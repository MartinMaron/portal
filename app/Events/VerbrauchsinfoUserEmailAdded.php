<?php

namespace App\Events;

use App\Models\VerbrauchsinfoUserEmail;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class VerbrauchsinfoUserEmailAdded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public VerbrauchsinfoUserEmail $verbrauchsinfoUserEmail;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(VerbrauchsinfoUserEmail $verbrauchsinfoUserEmail)
    {
        $this->verbrauchsinfoUserEmail = $verbrauchsinfoUserEmail;
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
