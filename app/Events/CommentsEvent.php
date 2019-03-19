<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/***********************************************************

 * @params comment

 * @description 댓글 저장 이벤트 채널

 * @method

 * @return

 ***********************************************************/

class CommentsEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $comment;

    public function __construct(\App\Comment $comment)
    {
        $this->comment = $comment;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
