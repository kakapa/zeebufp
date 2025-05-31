<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\SendUserMobileNumberSMS;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MobileVerificationController extends Controller
{
    /**
     * Class constructor.
     */
    public function __construct()
    {
        //$this->middleware([]);
    }

    /**
     * Show Mobile Number verification form
     */
    public function showForm(Request $request)
    {
        return empty($request->user()->pin)
            ? redirect()->intended(route('dashboard', absolute: false))
            : Inertia::render('Auth/VerifyMobileNumber');
    }

    /**
     * Verify code sent to user's mobile number
     */
    public function verifyCode(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|digits:4'
        ]);

        try {
            // Get $user
            $user = auth()->user();

            if ($user->pin == $validated['code']) {
                $user->update([
                    'mobile_verified_at' => now(),
                    'pin' => null
                ]);

                return redirect(route('dashboard', absolute: false));
            } else {
                return back()->withErrors(['code' => 'Invalid verification code, please try again!']);
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    /**
     * Resend verification code
     */
    public function resendCode()
    {
        // Get user
        $user = auth()->user();

        try {
            // Generate & Send new code
            $code = mt_rand(1000, 9999);
            $user->update([
                'pin' => $code
            ]);

            dispatch(new SendUserMobileNumberSMS($user));
            return back()->with(['message' => 'Verification code re-sent!']);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
