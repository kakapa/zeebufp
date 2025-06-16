<?php

namespace App\Http\Controllers;

use Illuminate\Console\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
        return Inertia::render('Welcome', [
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
        return;
    }
}