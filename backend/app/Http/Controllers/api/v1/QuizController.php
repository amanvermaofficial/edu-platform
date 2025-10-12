<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Trade;
use Exception;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function getQuizzesByTrade(Trade $trade){
        try{
            $quizzes = $trade->quizzes()
                      ->select('id', 'title', 'description')
                      ->with('courses:id,name')
                      ->get();
            
            return $this->successResponse('Quizzes fetched successfully',['quizzes'=>$quizzes])        
        }catch(Exception $e){
              return $this->systemErrorResponse($e->getMessage());
        }
    }
}
