<?php

namespace App\Http\Controllers;

use App\Mail\SubmitContactForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    /**
     * Class constructor.
     */
    public function __construct()
    {
        //$this->middleware([]);
    }

    /**
     * Show home page
     */
    public function showHome()
    {
        return inertia('Welcome', [
            'mainActivePackages' => Cache::rememberForever('mainActivePackages', function () {
                return \App\Http\Resources\PackageResource::collection(
                    \App\Models\Package::where('main', true)
                        ->where('status', 'active')
                        ->get()
                );
            })
        ]);
    }

    /**
     * Submit contact form
     */
    public function submitContactForm(Request $request)
    {
        // Validate
        $validated = $request->validate([
            'name' => 'required|string|min:1|max:60',
            'phone' => 'required|string|min:10|max:10',
            'email' => 'required|email|min:1|max:60',
            'message' => 'required|string|min:1|max:300'
        ]);

        // Send email to admin
        Mail::to($validated['email'])->send(new SubmitContactForm($validated));

        return redirect()->back();
    }
}