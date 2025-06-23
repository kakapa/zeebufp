<?php

namespace App\Http\Controllers;

use App\Enums\AccountStatusEnums;
use App\Enums\ClaimStatusEnums;
use App\Enums\PaymentTypeEnums;
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
            'accounts' => \App\Http\Resources\AccountResource::collection(
                Cache::rememberForever('accounts', function () {
                    return \App\Models\Account::all();
                }),
            ),
            'clients' => \App\Http\Resources\ClientResource::collection(
                Cache::rememberForever('clients', function () {
                    return \App\Models\Client::all();
                }),
            ),
            'contributions' => \App\Http\Resources\PaymentResource::collection(
                Cache::rememberForever('contributions', function () {
                    return \App\Models\Payment::where('type', PaymentTypeEnums::CONTRIBUTION)->latest()->get();
                }),
            ),
            'claims' => \App\Http\Resources\ClaimResource::collection(
                Cache::rememberForever('claims', function () {
                    return \App\Models\Claim::all();
                }),
            ),

            // Enums for UI labels
            'package_statuses' => \App\Enums\PackageStatusEnums::labels(),
            'client_statuses' => \App\Enums\ClientStatusEnums::labels(),
            'account_statuses' => \App\Enums\AccountStatusEnums::labels(),
            'payment_statuses' => \App\Enums\PaymentStatusEnums::labels(),
            'payment_methods' => \App\Enums\PaymentMethodEnums::labels(),
            'payment_types' => \App\Enums\PaymentTypeEnums::labels(),
            'claim_statuses' => \App\Enums\ClaimStatusEnums::labels(),
            'claim_types' => \App\Enums\ClaimTypeEnums::labels(),
            'genders' => \App\Enums\ClientGenderEnums::labels(),
            'sources' => \App\Enums\ClientSourceEnums::labels(),
            'titles' => \App\Enums\ClientTitleEnums::labels(),

            // Session data
            'payment' => session('payment') ?? null,
            'account' => session('account') ?? null,
            'package' => session('package') ?? null,
            'client' => session('client') ?? null,
            'claim' => session('claim') ?? null,

            // Stats
            'activeAccountsCount' => Cache::rememberForever('activeAccountsCount', function () {
                return \App\Models\Account::where('status', AccountStatusEnums::ACTIVE)->count();
            }),
            'pendingClaimsCount' => Cache::rememberForever('pendingClaimsCount', function () {
                return \App\Models\Claim::where('status', ClaimStatusEnums::PENDING)->count();
            }),
            /* 'monthlyContributionsSum' => Cache::rememberForever('monthlyContributionsSum', function () {
                return sprintf(
                    '%s%.2f',
                    'R',
                    \App\Models\Account::where('accounts.status', AccountStatusEnums::ACTIVE)
                        ->join('packages', 'accounts.package_id', '=', 'packages.id')
                        ->sum('packages.contribution')
                );
            }), */
            'monthlyContributionsSum' => sprintf('%s%.2f','R', 0)
        ]);
    }

    /**
     * Show messages page
     */
    public function showMessages()
    {
        return inertia('Messages');
    }

    /**
     * Show notifications page
     */
    public function showNotifications()
    {
        return inertia('Notifications');
    }
}