<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard.index', [
            'studentsCount'   => \App\Models\Student::count(),
            'quizzesCount'    => \App\Models\Quiz::count(),
            'attemptsCount'   => \App\Models\QuizAttempt::count(),
            'pendingReviews'  => \App\Models\Review::where('is_published', false)->count(),
            'publishedReviews' => \App\Models\Review::where('is_published', true)->count(),
            'coursesCount'    => \App\Models\Course::count(),
            'tradesCount'     => \App\Models\Trade::count(),
        ]);
    }
}
