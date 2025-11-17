<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\DashboardController;


Route::prefix('admin')->group(function () {

    // ----------- Admin Guest Routes (Not logged in) ------------
    Route::middleware('guest')->group(function () {
        Route::get('login', [LoginController::class, 'loginPage'])->name('login');
        Route::post('login', [LoginController::class, 'login'])->name('admin.login');
    });

    // ----------- Admin Authenticated Routes ------------
    Route::middleware('auth')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::post('logout', [LoginController::class, 'logout'])->name('admin.logout');
    });
});// same as admin/dashboard 404 not found