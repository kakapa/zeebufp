<?php

namespace App\Http\Middleware;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        // Get all settings that should be shared with the frontend
        $settings = \App\Models\Setting::where('editable', true)
            ->get()
            ->mapWithKeys(function ($setting) {
                // Convert value based on type
                $value = match ($setting->type) {
                    'boolean' => (bool)$setting->value,
                    'integer' => (int)$setting->value,
                    'float' => (float)$setting->value,
                    'json' => json_decode($setting->value, true),
                    default => $setting->value,
                };

                return [$setting->key => $value];
            });

        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user() ? new UserResource($request->user()) : null,
            ],
            'notifications' => [
                'unread' => $request->user() ? $request->user()->unreadNotifications()->latest()->get() : [],
                'all' => $request->user() ? $request->user()->notifications()->latest()->get() : [],
            ],
            'settings' => $settings
        ];
    }
}
