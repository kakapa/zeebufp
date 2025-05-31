<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Class constructor.
     */
    public function __construct()
    {
        //$this->middleware([]);
    }

    /**
     * Show dashboard page
     */
    public function showDashboard()
    {
        return Inertia::render('Dashboard');
    }
}