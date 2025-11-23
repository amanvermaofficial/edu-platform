<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PermissionController;

Route::prefix('admin')->as('admin.')->group(function () {

    // ----------- Admin Guest Routes (Not logged in) ------------
    Route::middleware('guest')->group(function () {
        Route::get('login', [LoginController::class, 'loginPage'])->name('login');
        Route::post('login', [LoginController::class, 'login'])->name('admin.login');
    });

    // ----------- Admin Authenticated Routes ------------
    Route::middleware('admin.auth')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('logout', [LoginController::class, 'logout'])->name('logout');
        Route::resource('permissions', PermissionController::class);
    });
});