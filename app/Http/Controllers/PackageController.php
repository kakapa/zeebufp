<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Enums\PackageStatusEnums;
use App\Http\Requests\StorePackageRequest;
use App\Http\Resources\PackageResource;
use Illuminate\Support\Facades\Cache;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        return inertia()->render('Packages/Index', [
            'packages' => PackageResource::collection(
                Cache::rememberForever('packages', function () {
                    return Package::all();
                })
            ),
            'statuses' => PackageStatusEnums::labels(),
            'package' => session('package') ?? null,
            'success' => session('success') ?? null,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePackageRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StorePackageRequest $request)
    {
        $package = Package::create($request->validated());

        // Clear the cache to ensure the new package is available
        Cache::forget('packages');

        return redirect()->route('dashboard')
            ->with('success', 'Package created successfully.')
            ->with('package', new PackageResource($package));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Package  $package
     * @return \Inertia\Response
     */
    public function show(Package $package)
    {
        return inertia()->render('Packages/Show', [
            'package' => new PackageResource($package),
            'statuses' => PackageStatusEnums::labels(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\StorePackageRequest  $request
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(StorePackageRequest $request, Package $package)
    {
        $package->update($request->validated());

        // Clear the cache to ensure the new package is available
        Cache::forget('packages');

        return redirect()->route('dashboard')
            ->with('success', 'Package updated successfully.')
            ->with('package', new PackageResource($package));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Package $package)
    {
        $package->delete();

        // Clear the cache to ensure the new package is available
        Cache::forget('packages');

        return redirect()->route('dashboard')
            ->with('success', 'Package deleted successfully.');
    }
}