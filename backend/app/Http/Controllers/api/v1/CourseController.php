<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Services\CourseService;
use Exception;

class CourseController extends Controller
{
        protected $service;

        public function __construct(CourseService $service)
        {
           $this->service = $service;  
        }
        public function index()
        {
         $result = $this->service->getAllCourses();

         if($result['success']){
            return $this->successResponse($result['message'],$result['data']);
         }

         return $this->systemErrorResponse($result['message']);
        }
}
