<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Occupation;
use App\Enums\GenderEnums;
use App\Enums\WorkStatusEnums;
use App\Enums\EducationLevelEnums;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('Settings', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'countries' => Cache::remember('countries', now()->addMonth(), function () {
                return Country::all()->pluck('name', 'code');
            }),
            'occupations' => Cache::remember('occupations', now()->addMonth(), function () {
                return Occupation::all()->pluck('label', 'slug');
            }),
            'genderItems' => GenderEnums::labels(),
            'workStatusItems' => WorkStatusEnums::labels(),
            'educationLevelItems' => EducationLevelEnums::labels(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill(
            collect($request->validated())->except(
                'country_code',
                'occupation'
            )->toArray()
        );

        if (!empty($request->user()->email)) {
            if ($request->user()->isDirty('email')) {
                $request->user()->email_verified_at = null;
            }
        }

        // Assign country_id of country_code
        if (!empty($request->only('country_code'))) {
            $country = Country::where('code', $request->only('country_code'))->first();
            $request->user()->country_id = $country->id;
        }

        // Assign occupation_id of occupation
        if (!empty($request->only('occupation'))) {
            $occupation = Occupation::where('slug', $request->only('occupation'))->first();
            $request->user()->occupation_id = $occupation->id;
        }

        $request->user()->profiled_at = empty($request->user()->profiled_at)
            ? now()
            : $request->user()->profiled_at;

        $request->user()->save();

        return !empty($request->user()->profiled_at)
            ? Redirect::route('profile.edit')
            : Redirect::route('dashboard');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}