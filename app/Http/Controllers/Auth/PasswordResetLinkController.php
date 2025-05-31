<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\SendUserMobileNumberSMS;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/ForgotPassword', [
            'status' => session('status'),
        ]);
    }

    /**
     * Display form to request new PIN
     */
    public function requestPin()
    {
        return Inertia::render('Auth/ForgotPin', [
            'status' => session('status')
        ]);
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status == Password::RESET_LINK_SENT) {
            return back()->with('status', __($status));
        }

        throw ValidationException::withMessages([
            'email' => [trans($status)],
        ]);
    }

    /**
     * Create and store new PIN (password) for the user, and
     * dispatch via SMS
     */
    public function newPin(Request $request)
    {
        $request->validate([
            'mobile_number' => 'required|digits:10|exists:users,mobile_number'
        ]);

        try {
            // Get User by mobile number
            $user = User::where('mobile_number', $request->only('mobile_number'))->first();

            // Create new pin
            $newPin = mt_rand(10000, 99999);

            // Hash & save to password
            $user->update(['password' => \Hash::make($newPin)]);

            // Send new PIN to User
            dispatch(new SendUserMobileNumberSMS($user, 'new-pin', $newPin));

            return back()->with(['status' => 'New PIN has been created!']);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th);
        }
    }
}
