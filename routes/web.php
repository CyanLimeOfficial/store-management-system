<?php

use Illuminate\Support\Facades\Route;
// Import ROUTES
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\GetStarted;
use App\Http\Controllers\Home;
use App\Http\Controllers\Products_Inventory;
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
    Route::post('/get-started/submit', [GetStarted::class, 'store'])->name('store_info.submit');
});



// Group routes that require authentication
Route::middleware(['auth', 'check.store_info'])->group(function () {
    Route::get('/home', function () {
        return view('dashboard.index');
    }); 
    // Add these new routes for store name change
    Route::post('/store/update-name', [Home::class, 'updateStoreName'])->name('store.updateName');


    Route::get('/inventory', function () {
        return view('dashboard.inventory');
    }); 
    Route::get('/inventory/add-products', function () {
        return view('dashboard.inventory_add');
    }); 

    Route::get('/pos', function () {
        return view('dashboard.pos');
    }); 

    // Handle form submission (no need for GET here)
    Route::post('/inventory/add-products/store', [Products_Inventory::class, 'add_product'])->name('add.product');
    Route::put('/inventory/{product}/quantity', [Products_Inventory::class, 'update_stock'])->name('edit.quantity.product');
});