<?php

namespace App\Listeners;

use App\Events\ModelChanged;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CacheHandler
{

    public function __construct()
    {

    }

    public function handle(ModelChanged $event)
    {
        if (! taggable()) {
            return \Cache::flush();
        }

        return \Cache::tags($event->cacheTags)->flush();
    }
}
