<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function ($view) {
        if (Auth::check()) {
            $user = Auth::user();
            $view->with([
                'followingCount' => $user->followings()->count(),
                'followerCount'  => $user->followers()->count(),
            ]);
        }
    });
    }
}
