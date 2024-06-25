<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\NavigationController;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        //
        View::composer('layouts.navigation', function ($view) {
            $navController = new NavigationController();
            $view->with('menuItems', $navController->getMenuItems());
        });
    }
}
