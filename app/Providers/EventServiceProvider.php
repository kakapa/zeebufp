<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Observers
        \App\Models\User::observe(\App\Observers\UserObserver::class);
        \App\Models\Package::observe(\App\Observers\PackageObserver::class);
        \App\Models\Client::observe(\App\Observers\ClientObserver::class);
    }
}