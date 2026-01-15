<?php

namespace App\Repositories;

use App\Models\QuizAttempt;

class StudentPerformanceRepository
{
    public function getAttemptsByStudent($studentId)
    {
        return QuizAttempt::where('student_id', $studentId)->get();
    }

    public function getQuizHistory($studentId)
    {
        return QuizAttempt::with('quiz')
            ->where('student_id', $studentId)
            ->latest()
            ->get([
                'id',
                'quiz_id',
                'score',
                'total_questions',
                'correct_answers',
                'created_at'
            ]);
    }
}
