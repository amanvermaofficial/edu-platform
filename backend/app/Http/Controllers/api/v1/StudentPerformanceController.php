<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Services\StudentPerformanceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentPerformanceController extends Controller
{
    protected $service;
    public function __construct(StudentPerformanceService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $student = Auth::guard('sanctum')->user();
        $performance = $this->service->getPerformance($student->id);
        $history = $this->service->getQuizHistory($student->id);

        return response()->json([
            'success' => true,
            'data' => [
                'performance' => $performance['data']['performance'],
                'quiz_history' => $history['data']['history']
            ]
        ]);
    }
}
