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
        \App\Models\Account::observe(\App\Observers\AccountObserver::class);
        \App\Models\Payment::observe(\App\Observers\PaymentObserver::class);
        \App\Models\Claim::observe(\App\Observers\ClaimObserver::class);
    }
}