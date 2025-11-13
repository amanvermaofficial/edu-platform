<?php

namespace App\Repositories;

use App\Models\CourseTrade;
use App\Models\Option;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\QuizAttemptAnswer;

class QuizRepository
{
    public function getCourseTrade($courseId, $tradeId)
    {
        return CourseTrade::where('course_id', $courseId)
            ->where('trade_id', $tradeId)
            ->firstOrFail();
    }

    public function getQuizzesByCourseTrade($courseTradeId)
    {
        return Quiz::whereHas('courseTrades', function ($q) use ($courseTradeId) {
            $q->where('course_trade_id', $courseTradeId);
        })->withCount('questions')->get();
    }

    public function getQuizWithQuestions($quizId)
    {
        return Quiz::with('questions.options')->find($quizId);
    }

    public function createAttempt($studentId, $quizId, $totalQuestions, $startTime, $endTime)
    {
        return QuizAttempt::create([
            'student_id' => $studentId,
            'quiz_id' => $quizId,
            'total_questions' => $totalQuestions,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'duration' => abs($endTime->diffInSeconds($startTime)),
        ]);
    }

    public function getQuestion($questionId)
    {
        return Question::find($questionId);
    }

    public function getOption($optionId)
    {
        return Option::find($optionId);
    }

    public function getCorrectOption($questionId)
    {
        return Option::where('question_id', $questionId)
            ->where('is_correct', true)
            ->first();
    }

    public function saveAttemptAnswer($attemptId, $question, $selectedOption, $correctOption, $isCorrect)
    {
        return QuizAttemptAnswer::create([
            'quiz_attempt_id' => $attemptId,
            'question_id' => $question->id,
            'selected_option' => $selectedOption ? $selectedOption->option_text : null,
            'correct_option' => $correctOption ? $correctOption->option_text : null,
            'is_correct' => $isCorrect,
        ]);
    }

    public function updateAttemptResult($attempt, $score, $correct, $wrong)
    {
        return $attempt->update([
            'score' => $score,
            'correct_answers' => $correct,
            'wrong_answers' => $wrong,
            'end_time' => now(),
        ]);
    }

    
    public function findActiveAttempt($studentId, $quizId)
    {
        return QuizAttempt::where('student_id', $studentId)
            ->where('quiz_id', $quizId)
            ->where('end_time', '>', now())
            ->first();
    }

      public function findAttempt($studentId, $quizId)
    {
        return QuizAttempt::where('student_id', $studentId)
            ->where('quiz_id', $quizId)
            ->latest()
            ->first();
    }
}
