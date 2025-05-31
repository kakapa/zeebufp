<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Response;

class UpdateProfileOfNewlyRegisteredUser
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
        // Manipulate $request
        if (empty($request->user()->profiled_at)) {
            return Redirect::route('profile.edit')->with(['status' => 'Please update your profile!']);
        }

        $response = $next($request);

        // Manipulate $response
        return $response;
    }
}
