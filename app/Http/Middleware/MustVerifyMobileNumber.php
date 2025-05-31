<?php

namespace App\Http\Middleware;

use App\Jobs\SendUserMobileNumberSMS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Response;

class MustVerifyMobileNumber
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, \Closure $next): Response
    {
        // Inspect $request
        if ($request->user()) {
            if (empty($request->user()->pin) && empty($request->user()->mobile_verified_at)) {
                // Generate PIN
                $pin = mt_rand(1000, 9999);

                // Send PIN to User mobile number
                $user = $request->user();
                $user->update(['pin' => $pin]);
                dispatch(new SendUserMobileNumberSMS($user));

                return Redirect::route('code.prompt');
            } elseif (empty($request->user()->mobile_verified_at)) {
                return Redirect::route('code.prompt');
            }
        } else {
            return Redirect::route('login');
        }

        $response = $next($request);

        // Manipulate $response
        return $response;
    }
}
