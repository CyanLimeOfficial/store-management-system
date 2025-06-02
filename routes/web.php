<?php

use Illuminate\Support\Facades\Route;
// Import ROUTES
use App\Http\Controllers\Auth\LoginController;
// Import Middleware
use App\Http\Middleware\CheckStoreExist;


// Redirect to Login by Default
Route::redirect('/', '/login', 301);

// Login Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Authenticated Zone
Route::get('/get-started', function () {
    return view('auth.get-started');
})->middleware('auth');

// Group routes that require authentication
Route::middleware(['auth', 'check.store_info'])->group(function () {
    Route::get('/home', function () {
        return view('dashboard.index');
    }); 
});