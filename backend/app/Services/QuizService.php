<?php

namespace App\Services;

use App\Repositories\QuizRepository;
use Exception;
use Illuminate\Support\Facades\Auth;

/**
 * Class QuizService.
 */
class QuizService
{
    protected $repo;

    public function __construct(QuizRepository $repo){
        $this->repo = $repo;
    }

    public function getQuizzesForCourseTrade($course,$trade){
        try {
            $courseTrade = $this->repo->getCourseTrade($course->id,$trade->id);

            $quizzes = $this->repo->getQuizzesByCourseTrade($courseTrade->id);

            return [
                'success'=>true,
                'message' => 'Quizzes fetched successfully',
                'data' => ['quizzes' => $quizzes],
            ];
        } catch (Exception $e) {
           return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function showQuiz($quiz){
        try {
            $quizData = $this->repo->getQuizWithQuestions($quiz->id);

            return [
                'success'=>true,
                'message' => 'Quiz fetched successfully',
                'data' => ['quiz' => $quizData],
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function submitQuiz($request,$quiz){
        try {
            $student = Auth::guard('sanctum')->user();
            $answers = $request->input('answers');

            $score =0;
            $correct=0;
            $wrong=0;

            $totalQuestions = $quiz->questions()->count();

            $attempt = $this->repo->createAttempt($student->id,$quiz->id,$totalQuestions);

            foreach($answers as $ans){
                $question = $this->repo->getQuestion($ans['question_id']);
                $selectedOption = $this->repo->getOption($ans['selected_option_id']);
                $correctOption = $this->repo->getCorrectOption($question->id);

                $isCorrect = $selectedOption && $correctOption && $selectedOption->id == $correctOption->id;

                if ($isCorrect) {
                    $score++;
                    $correct++;
                } else {
                    $wrong++;
                }

                $this->repo->saveAttemptAnswer(
                    $attempt->id,
                    $question,
                    $selectedOption,
                    $correctOption,
                    $isCorrect
                );
            }

            $this->repo->updateAttemptResult($attempt , $score,$correct,$wrong);

            return [
                'success'=>true,
                'message'=>'Quiz submitted successfully',
                'data'=>[
                    'score'=>$score,
                    'correct_answer'=>$correct,
                    'wrong_answers'=>$wrong,
                ],
            ];
        } catch (Exception $e) {
             return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }
}
