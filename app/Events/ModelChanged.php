<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ModelChanged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $cacheTags;

    public function __construct($cacheTags)
    {
        $this->cacheTags = $cacheTags;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
