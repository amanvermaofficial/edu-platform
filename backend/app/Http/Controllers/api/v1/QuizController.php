<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseTrade;
use App\Models\Quiz;
use App\Models\Trade;
use Exception;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function getQuizzesForCourseTrade(Course $course,Trade $trade){
        try{
            $courseTrade = CourseTrade::where('course_id',$course->id)
                                        ->where('trade_id',$trade->id)
                                        ->firstOrFail();
            
            $quizzes = Quiz::whereHas('courseTrades',function($q)use($courseTrade){
                $q->where('course_trade_id',$courseTrade->id);
            })->withCount('questions')->get();                             
            
            return $this->successResponse('Quizzes fetched successfully',['quizzes'=>$quizzes]);        
        }catch(Exception $e){
              return $this->systemErrorResponse($e->getMessage());
        }
    }

    public function show(Quiz $quiz){
        try{
            $quiz = Quiz::with('questions.options')->find($quiz->id);
            return $this->successResponse('Quiz fetched successfully', ['quiz' => $quiz]);
        }catch(Exception $e){
            return $this->systemErrorResponse($e->getMessage());
        }
    }
}
