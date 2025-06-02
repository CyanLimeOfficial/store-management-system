<?php

use Illuminate\Support\Facades\Route;
// Import ROUTES
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\GetStarted;
// Import Middleware
use App\Http\Middleware\CheckStoreExist;


// Redirect to Login by Default
Route::redirect('/', '/login', 301);

// Login Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Authenticated Zone
Route::middleware(['auth'])->group(function () {
    // Form display
    Route::get('/get-started', function () {
        return view('auth.get-started');
    });

    // Handle form submission (no need for GET here)
    Route::post('/store-info/submit', [GetStarted::class, 'store'])->name('store_info.submit');
});



// Group routes that require authentication
Route::middleware(['auth', 'check.store_info'])->group(function () {
    Route::get('/home', function () {
        return view('dashboard.index');
    }); 
});