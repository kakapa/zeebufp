<?php

namespace App\Http\Controllers;

use App\Enums\BeneficiaryStatusEnums;
use App\Http\Requests\StoreBeneficiaryRequest;
use App\Http\Requests\UpdateBeneficiaryRequest;
use App\Models\Beneficiary;
use Illuminate\Support\Facades\Cache;
use \App\Http\Resources\BeneficiaryResource;

class BeneficiaryController extends Controller
{
    /**
     * Class constructor.
     */
    public function __construct()
    {
        //$this->middleware([]);
        //$this->authorizeResource(Beneficiary::class, 'beneficiary');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        return inertia()->render('Beneficiarys/Index', [
            'beneficiarys' => BeneficiaryResource::collection(
                Cache::rememberForever('beneficiarys', function () {
                    return Beneficiary::all();
                })
            ),
            'statuses' => BeneficiaryStatusEnums::labels(),
            'beneficiary' => session('beneficiary') ?? null,
            'success' => session('success') ?? null,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBeneficiaryRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreBeneficiaryRequest $request)
    {
        $beneficiary = Beneficiary::create($request->validated());

        // Clear the cache to ensure the new beneficiary is available
        Cache::forget('beneficiarys');

        return redirect()->route('dashboard')
            ->with('success', 'Beneficiary created successfully.')
            ->with('beneficiary', new BeneficiaryResource($beneficiary));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Beneficiary  $beneficiary
     * @return \Inertia\Response
     */
    public function show(Beneficiary $beneficiary)
    {
        return inertia()->render('Beneficiarys/Show', [
            'beneficiary' => new BeneficiaryResource($beneficiary),
            'statuses' => BeneficiaryStatusEnums::labels(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\StoreBeneficiaryRequest  $request
     * @param  \App\Models\Beneficiary  $beneficiary
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(StoreBeneficiaryRequest $request, Beneficiary $beneficiary)
    {
        $beneficiary->update($request->validated());

        // Clear the cache to ensure the new beneficiary is available
        Cache::forget('beneficiarys');

        return redirect()->route('dashboard')
            ->with('success', 'Beneficiary updated successfully.')
            ->with('beneficiary', new BeneficiaryResource($beneficiary));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Beneficiary  $beneficiary
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Beneficiary $beneficiary)
    {
        $beneficiary->delete();

        // Clear the cache to ensure the new beneficiary is available
        Cache::forget('beneficiarys');

        return redirect()->route('dashboard')
            ->with('success', 'Beneficiary deleted successfully.');
    }
}
