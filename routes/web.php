<?php

use Illuminate\Support\Facades\Route;
// Import ROUTES
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\GetStarted;
use App\Http\Controllers\Home;
use App\Http\Controllers\Products_Inventory;
use App\Http\Controllers\POS;
use App\Http\Controllers\TransactionsView; 
use App\Http\Controllers\StoreDetails; 

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



// Group routes that require authentication and a store to exist
Route::middleware(['auth', 'check.store_info'])->group(function () {
// And REPLACE it with this line:
    Route::get('/home', 
        [Home::class, 'index'])
    ->name('home');

    Route::get('/inventory', function () {
        return view('dashboard.inventory');
    });
    Route::get('/inventory/add-products', function () {
        return view('dashboard.inventory_add');
    });

    Route::get('/transactions', function () {
        return view('dashboard.transactions');
    });

    Route::get('/pos', function () {
        return view('dashboard.pos');
    });
    Route::post('/pos/transactions', [POS::class, 'store'])->name('transactions.store')->middleware('auth');
    // Action Routes for Home
    Route::post('/store/update-name', [Home::class, 'updateStoreName'])->name('store.updateName');
    Route::get('/dashboard/data', [Home::class, 'data'])->name('dashboard.data');
    Route::get('dashboard/debt-lists', [Home::class, 'DebtsList'])->name('debts.list');
    // Handle form submission (no need for GET here)
    Route::post('/inventory/add-products/store', [Products_Inventory::class, 'add_product'])->name('add.product');
    Route::put('/inventory/{product}/quantity', [Products_Inventory::class, 'update_stock'])->name('edit.quantity.product');
    // Action Routes (following your naming style)
    Route::get('/inventory/{product}/edit', [Products_Inventory::class, 'edit_stock'])->name('edit.product');
    Route::put('/inventory/{product}/update', [Products_Inventory::class, 'update_stock'])->name('edit.quantity.product');
    Route::delete('/inventory/{product}/delete', [Products_Inventory::class, 'delete_product'])->name('delete.product');
    // Action Routes for Transactions
    Route::get('/transactions-list', [TransactionsView::class, 'list'])->name('transactions.list');
    Route::get('/transactions/{transaction}', [TransactionsView::class, 'show'])->name('transactions.show');
    // Action Routes for StoreDetails
    Route::get('/store-details', [StoreDetails::class, 'edit'])->name('store-details.edit');
    Route::post('/store-details', [StoreDetails::class, 'update'])->name('store-details.update');
});