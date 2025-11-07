<?php

namespace App\Services;

use App\Models\Quiz;
use App\Repositories\QuizRepository;
use Exception;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\TryCatch;
use Request;

/**
 * Class QuizService.
 */
class QuizService
{
    protected $repo;

    public function __construct(QuizRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getQuizzesForCourseTrade($course, $trade)
    {
        try {
            $courseTrade = $this->repo->getCourseTrade($course->id, $trade->id);

            $quizzes = $this->repo->getQuizzesByCourseTrade($courseTrade->id);

            return [
                'success' => true,
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

    public function showQuiz($quiz)
    {
        try {
            $quizData = $this->repo->getQuizWithQuestions($quiz->id);

            return [
                'success' => true,
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

    public function startQuiz(Request $request, Quiz $quiz)
    {
        try {
            $student = Auth::guard('sanctum')->user();

            $attempt = $this->repo->createAttempt(
                $student->id,
                $quiz->id,
                $quiz->questions()->count(),
                now(),
                now()->addSeconds($quiz->duration)
            );

            return [
                'success' => true,
                'message' => 'Quiz started successfully',
                'data' => [
                    'quiz' => $quiz,
                    'duration' => $quiz->duration,
                    'end_time' => $attempt->end_time
                ]
            ];
        } catch (\Throwable $th) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function submitQuiz($request, $quiz)
    {
        try {
            $student = Auth::guard('sanctum')->user();
            $answers = $request->input('answers');

            $attempt = $this->repo->findAttempt($student->id,$quiz->id);

            if(!$attempt){
                throw new Exception('No active quiz attempt found.');
            }

            $currentTime = now();

            if($currentTime->greaterThan($attempt->end_time)){
                $expired = true;
            }else{
                $expired= false;
            }

            $score = $correct = $wrong = $skipped = 0;

            $questions = $quiz->questions;
            $totalQuestions = $quiz->questions()->count();

            $attempt = $this->repo->createAttempt($student->id, $quiz->id, $totalQuestions);

            foreach ($questions as $question) {
                $answer = collect($answers)->firstWhere('question_id', $question->id);

                if (!$answer || $expired) {
                    $skipped++;
                    $this->repo->saveAttemptAnswer(
                        $attempt->id,
                        $question,
                        null,
                        $this->repo->getCorrectOption($question->id),
                        false
                    );
                    continue;
                }
                $selectedOption = $this->repo->getOption($answer['selected_option_id']);
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
           
            $this->repo->updateAttemptResult($attempt, $score, $correct, $wrong);

            return [
                'success' => true,
                'message' => $expired ? 'Time limit exceeded, quiz auto-submitted.' : 'Quiz submitted successfully',
                'data' => [
                    'score' => $score,
                    'correct_answer' => $correct,
                    'wrong_answers' => $wrong,
                    'skipped_questions' => $skipped,
                    'total_questions' => $totalQuestions
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
