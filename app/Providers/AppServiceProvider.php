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
        if ($locale = request()->cookie('locale__myapp')) {
            // 사용자가 제출한 암호화된 쿠키를 복호화한 후
            // 애플리케이션 전체에 적용할 언어를 설정한다.
            app()->setLocale(\Crypt::decrypt($locale));
        }

        \Carbon\Carbon::setLocale(app()->getLocale());

        view()->composer('*', function($view){
            $allTags = \Cache::rememberForever('tags.list',function (){
               return \App\Tag::all();
            });
            // 현재 사용자
            $currentUser = auth()->user();
            $currentLocale = app()->getLocale();
            $currentUrl = current_url();

            $view->with(compact('allTags','currentUser','currentLocale','currentUrl'));
        });
    }
}
