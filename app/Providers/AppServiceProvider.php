<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment('local')){
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
        }

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function($view){
            $allTags = \Cache::rememberForever('tags.list',function (){
               return \App\Tag::all();
            });
            // 현재 사용자
            $currentUser = auth()->user();

            $view->with(compact('allTags','currentUser'));
        });
    }
}
