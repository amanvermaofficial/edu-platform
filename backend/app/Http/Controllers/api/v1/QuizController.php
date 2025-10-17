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

    public function submitQuiz(Request $request,Quiz $quiz){
    try {
        $student = Auth::guard('sanctum')->user();
    $answers = $request->input('answers');

    $score = 0;
    $correct=0;
    $wrong = 0;

    $attempt = QuizAttempt::create([
        'student_id'=>$student->id,
        'quiz_id'=>$quiz->id,
        'total_questions'=>count($answers)
    ]);

    foreach($answer as $ans){
        $question = Question::find($ans['question_id']);
        $selectedOption = Option::find($ans['selected_option_id']);
        $correctOption = Option::find('question_id',$question->id)
                        ->where('is_correct',true)
                        ->first();
        $isCorrect = $selectedOption && $correctOption  && $selectedOption->id == $correctOption->id;    
        
        if($isCorrect){
            $score++;
            $correct++;
        }else{
            $wrong++;
        }

        QuizAttemptAnswer::create([
            'quiz_attempt_id' => $attempt->id,
            'question_id' => $question->id,
            'selected_option' => $selectedOption ? $selectedOption->option_text : null,
            'correct_option' => $correctOption ? $correctOption->option_text : null,
            'is_correct' => $isCorrect,
        ])
    }

    $attempt->update([
        'score'=>$score,
        'correct_answers'=>$correct,
        'wrong_answers'=>$wrong
    ]);

    return $this->successResponse('Quiz submitted successfully', [
        'score'=>$score,
        'correct_answers'=>$correct,
        'wrong_answers'=>$wrong
    ]);
    } catch (Exception $e) {
        return $this->systemErrorResponse($e->getMessage());
    }
    }
}
