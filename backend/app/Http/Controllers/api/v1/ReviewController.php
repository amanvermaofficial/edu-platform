<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewRequest;
use App\Services\ReviewService;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    protected $service;
    public function __construct(ReviewService $service)
    {
        $this->service = $service;
    }

    public function index(){
        $result = $this->service->getAllReviews();
        if($result['success']){
            return $this->successResponse($result['message'], $result['data']);
        }
        return $this->systemErrorResponse($result['message']);
    }
    public function store(ReviewRequest $request){ 
        $result = $this->service->create($request->validated());
        if($result['success']){
            return $this->successResponse($result['message'], $result['data']);
        }
        return $this->systemErrorResponse($result['message']);
    }
}
