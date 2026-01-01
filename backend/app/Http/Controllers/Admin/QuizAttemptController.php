<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\QuizAttemptDataTable;
use App\Http\Controllers\Controller;
use App\Models\QuizAttempt;
use Illuminate\Http\Request;

class QuizAttemptController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:quiz-attempts.view')->only('index');
        $this->middleware('permission:quiz-attempts.show')->only('show');
    }
    
    public function index(QuizAttemptDataTable $dataTable){
        return $dataTable->render('admin.quiz_attempts.index');
    }

    public function show(QuizAttempt $attempt){
        $attempt->load(['student','quiz']);
        $answers = $attempt->answers()
                    ->with(['question.options'])
                    ->paginate(5);

        return view('admin.quiz_attempts.show', compact('attempt','answers'));
    }
}
