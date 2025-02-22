<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Role-based dashboard routes
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin-dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');
    });

    Route::middleware(['role:cashier'])->group(function () {
        Route::get('/cashier-dashboard', function () {
            return view('cashier.dashboard');
        })->name('cashier.dashboard');
    });

    Route::middleware(['role:manager'])->group(function () {
        Route::get('/manager-dashboard', function () {
            return view('manager.dashboard');
        })->name('manager.dashboard');
    });
});

Route::resource('products', ProductController::class);
