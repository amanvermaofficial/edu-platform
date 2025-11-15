<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\DashboardController;

  //Route::get('login', [LoginController::class, 'loginPage'])->name('admin.login.page');
  


Route::middleware('guest')->group(function (){
    Route::get('login', [LoginController::class, 'loginPage'])->name('login');
    Route::post('login', [LoginController::class, 'login'])->name('admin.login');
});


Route::group([
    'middleware' => ['auth']
], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::post('logout', [LoginController::class, 'logout'])->name('admin.logout');
});
