<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

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
    public function boot(): void
    {
        // Force https when using localhost.run or ngrok tunneling
        /* if ((config('app.url') != 'http://zeebufp.test' && config('app.env') === 'local')
            || config('app.env') === 'production') {
            URL::forceScheme('https');
        } */

        Vite::prefetch(concurrency: 3);

        // Enable throttling on verification code resend (NOT WORKING YET)
        RateLimiter::for('resend', function (Request $request) {
            return Limit::perMinute(60)->by($request->ip());
        });

        // Disable wrapping Resource DB results with "data"
        JsonResource::withoutWrapping();
    }
}
