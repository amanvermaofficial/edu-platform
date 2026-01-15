<?php

namespace App\Services;

use App\Repositories\StudentPerformanceRepository;
use Exception;

/**
 * Class StudentPerformanceService.
 */
class StudentPerformanceService
{
    protected $repo;

    public function __construct(StudentPerformanceRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getPerformance($studentId)
    {
        try {
            $attempts = $this->repo->getAttemptsByStudent($studentId);

            $totalQuizzes = $attempts->count();

            $averagePercentage = $totalQuizzes
                ? round(
                    ($attempts->avg('score') / $attempts->avg('total_questions')) * 100,
                    2
                )
                : 0;

            $bestPercentage = $attempts->count()
                ? round(
                    ($attempts->max('score') / $attempts->max('total_questions')) * 100,
                    2
                )
                : 0;

            return [
                'success' => true,
                'data' => [
                    'performance' => [
                        'total_quizzes' => $totalQuizzes,
                        'average_score' => $averagePercentage,
                        'best_score' => $bestPercentage,
                        'last_attempt' => $attempts->sortByDesc('created_at')->first(),
                    ],
                    'quiz_history' => $this->repo->getQuizHistory($studentId)
                ]
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }


    public function getQuizHistory($studentId)
    {
        try {
            return [
                'success' => true,
                'data' => [
                    'history' => $this->repo->getQuizHistory($studentId)
                ]
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
}
