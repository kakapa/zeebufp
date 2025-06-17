<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'firstname' => 'required|string|max:255',
            'initials' => 'required|string|max:3',
            'lastname' => 'required|string|max:255',
            'mobile_number' => 'required|digits:10|unique:' . User::class,
            'password' => ['required', 'confirmed', 'numeric', 'min:10000', 'max:99999'/* Rules\Password::defaults() */],
        ]);

        $user = User::create([
            'firstname' => $request->firstname,
            'initials' => $request->initials,
            'lastname' => $request->lastname,
            'mobile_number' => $request->mobile_number,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
