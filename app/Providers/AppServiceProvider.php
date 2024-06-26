<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\User;
use App\Models\Pet;
use App\Models\Service;
use App\Models\Event;
use Illuminate\Support\Facades\Gate;
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

        Gate::define('update-post', function (User $user, Post $post) {
            if ($user->hasRole('Admin')) {
                return true;
            }

            return $user->id === $post->user->id;
        });
        
        Gate::define('update-service', function (User $user, Service $service) {
            if ($user->hasRole('Admin')) {
                return true;
            }

            return $service->owners->contains($user->id);
        });

        Gate::define('update-event', function (User $user, Event $event) {
            if ($user->hasRole('Admin')) {
                return true;
            }

            return $event->hosts->contains($user->id);
        });

        Gate::define('update-pet', function (User $user, Pet $pet) {
            if ($user->hasRole('Admin')) {
                return true;
            }

            return $pet->users->contains($user->id);
        });
    }
}
