<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\updateProfileRequest;
use App\Models\Student;
use App\Services\StudentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{

    protected $service;

    public function __construct(StudentService $service)
    {
        $this->service = $service;
    }

    public function getProfile()
    {
        $result = $this->service->getProfile();
        return response()->json([
            'success' => $result['success'],
            'message' => $result['message'],
            'data' => $result['data'] ?? null
        ], $result['status']);
    }

    public function updateProfile(updateProfileRequest $request)
    {
        $result = $this->service->updateProfile($request);

        return response()->json([
            'success' => $result['success'],
            'message' => $result['message'],
            'data' => $result['data'] ?? null
        ], $result['status']);
    }
}
