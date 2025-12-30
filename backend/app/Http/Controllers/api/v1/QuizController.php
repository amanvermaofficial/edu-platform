<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseTrade;
use App\Models\Option;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\QuizAttemptAnswer;
use App\Models\Trade;
use App\Services\QuizService;
use Auth;
use Exception;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    protected $service;

    public function __construct(QuizService $service)
    {
        $this->service = $service;
    }
    
    public function getQuizzesForCourseTrade(Course $course, Trade $trade)
    {
        $result = $this->service->getQuizzesForCourseTrade($course, $trade);

        if ($result['success']) {
            return $this->successResponse($result['message'], $result['data']);
        }

        return $this->systemErrorResponse($result['message']);
    }

    public function show(Quiz $quiz)
    {
        $result = $this->service->showQuiz($quiz);

        if ($result['success']) {
            return $this->successResponse($result['message'], $result['data']);
        }

        return $this->systemErrorResponse($result['message']);
    }

    public function startQuiz(Request $request, Quiz $quiz)
    {
        $result = $this->service->startQuiz($request, $quiz);

        if ($result['success']) {
            return $this->successResponse($result['message'], $result['data']);
        }


        if (isset($result['status']) && $result['status'] !== 'error') {
            return $this->businessResponse(
                $result['status'],
                $result['message'],
                $result['data'] ?? []
            );
        }

        return $this->systemErrorResponse($result['message']);
    }

    public function submitQuiz(Request $request, Quiz $quiz)
    {
        $result = $this->service->submitQuiz($request, $quiz);

        if ($result['success']) {
            return $this->successResponse($result['message'], $result['data']);
        }

        return $this->systemErrorResponse($result['message']);
    }

    public function quizResult(Quiz $quiz)
    {
        $result = $this->service->getQuizResult($quiz);

        if ($result['success']) {
            return $this->successResponse(
                $result['message'],
                $result['data']
            );
        }

        return $this->systemErrorResponse('Unable to fetch quiz result. Please try again later.');
    }
}
