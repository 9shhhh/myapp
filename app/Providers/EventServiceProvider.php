<?php

namespace App\Providers;

use App\Events\ArticleCreated;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
//        Registered::class => [ 메일 보내기 예제임..... 걍 주석
//            SendEmailVerificationNotification::class,
//        ],

//        \App\Events\ArticlesEvent::class => [
//          \App\Listeners\ArticlesEventListener::class,
//        ],

//        \Illuminate\Auth\Events\Login::class => [
//          \App\Listeners\UserEventListner::class,
//        ],

//        \App\Events\CommentsEvent::class => [
//          \App\Listeners\CommentsEventListener::class,
//        ],

        \App\Events\ModelChanged::class =>[
            \App\Listeners\CacheHandler::class,
        ],
    ];

    protected $subscribe=[
      \App\Listeners\UsersEventListener::class,
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

//        \Event::listen(
//            \App\Events\ArticleCreated::class,
//            \App\Listeners\ArticlesEventListener::class
//        );

    }
}
