<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\ClaimController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\MustVerifyMobileNumber;
use App\Http\Middleware\UpdateProfileOfNewlyRegisteredUser;
use Illuminate\Support\Facades\Route;

Route::name('guest')->group(function () {
    Route::get('/', [HomeController::class, 'showHome']);
    Route::post('/contact', [HomeController::class, 'submitContactForm']);
});

Route::middleware(['auth', MustVerifyMobileNumber::class, 'verified', UpdateProfileOfNewlyRegisteredUser::class])
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'showDashboard'])->name('dashboard');

        Route::get('/notifications', [DashboardController::class, 'showNotifications'])->name('notifications');
    });

Route::middleware('auth')->group(function () {
    Route::resource('documents', DocumentController::class);

    Route::resource('packages', PackageController::class);

    Route::resource('clients', ClientController::class);

    Route::resource('payments', PaymentController::class);

    Route::resource('claims', ClaimController::class);

    Route::resource('accounts', AccountController::class);
    Route::get('/accounts/{account}/pdf', [AccountController::class, 'downloadTerms'])->name('accounts.pdf');

    Route::get('/settings', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';