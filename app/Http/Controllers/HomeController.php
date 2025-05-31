<?php

namespace App\Http\Controllers;

use Illuminate\Console\Application;
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
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register')
        ]);
    }

    /**
     * Show about page
     */
    public function showAbout()
    {
        return Inertia::render('About');
    }

    /**
     * Show contact page
     */
    public function showContact()
    {
        return Inertia::render('Contact');
    }

    /**
     * Show resume page
     */
    public function showResume()
    {
        return Inertia::render('Resume', ['name' => 'Molotsi Paul Pilane']);
    }
}