<?php

use App\Http\Controllers\api\v1\OtpLogController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function(){
    Route::post('/send-otp',[OtpLogController::class,'sendOtp']);
    Route::post('/verify-otp',[OtpLogController::class,'verifyOtp']);
});