<?php

use App\Http\Controllers\api\v1\CourseController;
use App\Http\Controllers\api\v1\OtpLogController;
use App\Http\Controllers\api\v1\QuizController;
use App\Http\Controllers\api\v1\StudentController;
use App\Http\Controllers\api\v1\TradeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function(){
    Route::post('/send-otp',[OtpLogController::class,'sendOtp']);
    Route::post('/verify-otp',[OtpLogController::class,'verifyOtp']); 
});

Route::prefix('v1')->group(function(){
    Route::middleware('auth:sanctum')->group(function(){
        Route::post('/logout',[StudentController::class,'logout']);
        Route::get('student/profile',[StudentController::class,'getProfile']);
        Route::post('student/update-profile',[StudentController::class,'updateProfile']);
        Route::get('/courses',[CourseController::class,'index']);
        Route::get('/trades',[TradeController::class,'index']);
        Route::get('/courses/{course}/trades',[TradeController::class,'getTradesByCourse']);
        //Quiz
        Route::get('/courses/{course}/trades/{trade}/quizzes', [QuizController::class, 'getQuizzesForCourseTrade']);
        Route::get('/quizzes/{quiz}',[QuizController::class,'show']);
        Route::post('/quizzes/{quiz}/submit', [QuizController::class, 'submitQuiz']);
        Route::post('/quizzes/{quiz}/start',[QuizController::class,'startQuiz']);
        Route::get('/quizzes/{quiz}/result', [QuizController::class, 'quizResult']);
    });
});
