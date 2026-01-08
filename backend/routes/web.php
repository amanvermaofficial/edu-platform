<?php

use App\Http\Controllers\api\v1\auth\GoogleAuthController;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/admin.php';


Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])
    ->name('google.redirect');

Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])
    ->name('google.callback');
