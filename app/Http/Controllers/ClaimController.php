<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use App\Enums\ClaimStatusEnums;
use App\Http\Requests\StoreClaimRequest;
use Illuminate\Support\Facades\Cache;
use \App\Http\Resources\ClaimResource;

class ClaimController extends Controller
{
    /**
     * Class constructor.
     */
    public function __construct()
    {
        //$this->middleware([]);
        //$this->authorizeResource(Claim::class, 'claim');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        return inertia()->render('Claims/Index', [
            'claims' => ClaimResource::collection(
                Cache::rememberForever('claims', function () {
                    return Claim::all();
                })
            ),
            'statuses' => ClaimStatusEnums::labels(),
            'claim' => session('claim') ?? null,
            'success' => session('success') ?? null,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreClaimRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreClaimRequest $request)
    {
        $claim = Claim::create($request->validated());

        // Clear the cache to ensure the new claim is available
        Cache::forget('claims');
        Cache::forget('pendingClaimsCount');

        return redirect()->route('dashboard')
            ->with('success', 'Claim created successfully.')
            ->with('claim', new ClaimResource($claim));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Claim  $claim
     * @return \Inertia\Response
     */
    public function show(Claim $claim)
    {
        return inertia()->render('Claims/Show', [
            'claim' => new ClaimResource($claim),
            'statuses' => ClaimStatusEnums::labels(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\StoreClaimRequest  $request
     * @param  \App\Models\Claim  $claim
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(StoreClaimRequest $request, Claim $claim)
    {
        $claim->update($request->validated());

        // Clear the cache to ensure the new claim is available
        Cache::forget('claims');
        Cache::forget('pendingClaimsCount');

        return redirect()->route('dashboard')
            ->with('success', 'Claim updated successfully.')
            ->with('claim', new ClaimResource($claim));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Claim  $claim
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Claim $claim)
    {
        $claim->delete();

        // Clear the cache to ensure the new claim is available
        Cache::forget('claims');
        Cache::forget('pendingClaimsCount');

        return redirect()->route('dashboard')
            ->with('success', 'Claim deleted successfully.');
    }
}