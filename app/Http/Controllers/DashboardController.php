<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use App\Http\Resources\PackageResource;

class DashboardController extends Controller
{
    /**
     * Class constructor.
     */
    public function __construct()
    {
        //$this->middleware([]);
    }

    /**
     * Show dashboard page
     */
    public function showDashboard()
    {
        return inertia('Dashboard', [
            // Dashboard data
            'packages' => PackageResource::collection(
                Cache::rememberForever('packages', function () {
                    return \App\Models\Package::all();
                }),
            ),
            'clients' => \App\Http\Resources\ClientResource::collection(
                Cache::rememberForever('clients', function () {
                    return \App\Models\Client::all();
                }),
            ),

            // Enums for UI labels
            'packages_statuses' => \App\Enums\PackageStatusEnums::labels(),
            'client_statuses' => \App\Enums\ClientStatusEnums::labels(),
            'genders' => \App\Enums\ClientGenderEnums::labels(),
            'sources' => \App\Enums\ClientSourceEnums::labels(),
            'titles' => \App\Enums\ClientTitleEnums::labels(),

            // Session data
            'package' => session('package') ?? null,
            'client' => session('client') ?? null,
        ]);
    }

    /**
     * Show messages page
     */
    public function showMessages()
    {
        return inertia('Messages');
    }
}