<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use Exception;

class CourseController extends Controller
{
    public function index(){
        try {
            $courses = Course::select('id','name','description');
            return $this->successResponse('Courses fetched successfully', ['courses' => $courses]);
        } catch (Exception $e) {
            return $this->systemErrorResponse($e->getMessage());
        }
    }
}
