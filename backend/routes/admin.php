<?php

use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\CourseTradeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\QuizAttemptController;
use App\Http\Controllers\Admin\QuizController;
use App\Http\Controllers\Admin\QuizQuestionImportController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\TradeController;
use App\Http\Controllers\Admin\UserController;

use Route as GlobalRoute;

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
        Route::resource('roles', RoleController::class);
        Route::resource('users', UserController::class);
        Route::get('users/{user}/reset-password', [UserController::class, 'resetPassword'])
            ->name('users.reset-password');
        Route::put('users/{user}/reset-password', [UserController::class, 'updatePassword'])->name('users.reset-password.update-password');
        Route::resource('courses', CourseController::class);
        Route::resource('trades', TradeController::class);
        Route::get('courses/{course}/map-trades', [CourseTradeController::class, 'index'])->name('courses.map-trades');
        Route::post('courses/{course}/map-trades', [CourseTradeController::class, 'update'])->name('courses.map-trades.update');
        Route::resource('quizzes', QuizController::class);
        Route::get('quiz-questions/import', [QuizQuestionImportController::class, 'create'])
            ->name('quiz.questions.import');

        Route::post('quiz-questions/import', [QuizQuestionImportController::class, 'store'])
            ->name('quiz.questions.import.store');
        Route::get('quiz-attempts', [QuizAttemptController::class, 'index'])
            ->name('quiz-attempts.index');
        Route::get('quiz-attempts/{attempt}', [QuizAttemptController::class, 'show'])
            ->name('quiz-attempts.show');
        //students
        Route::resource('students', StudentController::class)
            ->only(['index', 'show', 'destroy']);
    });
});
