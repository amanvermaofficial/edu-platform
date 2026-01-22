<?php

namespace App\Services;

use App\Models\Quiz;
use App\Models\QuizAttemptAnswer;
use App\Repositories\QuizRepository;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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

            if ($quiz->questions()->count() === 0) {
                return [
                    'success' => false,
                    'message' => 'This quiz has no questions yet.'
                ];
            }

            $attempt = $this->repo->findAttempt($student->id, $quiz->id);

            if ($attempt && $attempt->score !== null) {
                return [
                    'success' => false,
                    'status' => 'COMPLETED',
                    'message' => 'You have already attempted this quiz.'
                ];
            }

            $attempt = $this->repo->createAttempt(
                $student->id,
                $quiz->id,
                $quiz->questions()->count(),
                now(),
                now()->addSeconds($quiz->duration)
            );

            return [
                'success' => true,
                'status'  => 'START',
                'message' => 'Quiz started successfully',
                'data' => [
                    'quiz' => $quiz,
                    'duration' => $quiz->duration,
                    'start_time' => $attempt->start_time,
                    'end_time' => $attempt->end_time
                ]
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    // public function submitQuiz($request, $quiz)
    // {
    //     try {
    //         $student = Auth::guard('sanctum')->user();
    //         $answers = $request->input('answers');

    //         $attempt = $this->repo->findAttempt($student->id, $quiz->id);

    //         if (!$attempt) {
    //             throw new Exception('No active quiz attempt found.');
    //         }

    //         $expired = now()->greaterThan($attempt->end_time);

    //         $score = $correct = $wrong = $skipped = 0;

    //         $questions = $quiz->questions;
    //         $totalQuestions = $quiz->questions()->count();



    //         foreach ($questions as $question) {
    //             $answer = collect($answers)->firstWhere('question_id', $question->id);

    //             if (!$answer) {
    //                 $skipped++;
    //                 $this->repo->saveAttemptAnswer(
    //                     $attempt->id,
    //                     $question,
    //                     null,
    //                     $this->repo->getCorrectOption($question->id),
    //                     false
    //                 );
    //                 continue;
    //             }
    //             $selectedOption = $this->repo->getOption($answer['selected_option_id']);
    //             $correctOption = $this->repo->getCorrectOption($question->id);

    //             $isCorrect = $selectedOption && $correctOption && $selectedOption->id == $correctOption->id;

    //             if ($isCorrect) {
    //                 $score++;
    //                 $correct++;
    //             } else {
    //                 $wrong++;
    //             }

    //             $this->repo->saveAttemptAnswer(
    //                 $attempt->id,
    //                 $question,
    //                 $selectedOption,
    //                 $correctOption,
    //                 $isCorrect
    //             );
    //         }

    //         $this->repo->updateAttemptResult($attempt, $score, $correct, $wrong,$skipped);

    //         return [
    //             'success' => true,
    //             'message' => $expired ? 'Time limit exceeded, quiz auto-submitted.' : 'Quiz submitted successfully',
    //             'data' => [
    //                 'score' => $score,
    //                 'correct_answer' => $correct,
    //                 'wrong_answers' => $wrong,
    //                 'skipped_questions' => $skipped,
    //                 'total_questions' => $totalQuestions
    //             ],
    //         ];
    //     } catch (Exception $e) {
    //         return [
    //             'success' => false,
    //             'message' => $e->getMessage(),
    //         ];
    //     }
    // }

    public function submitQuiz($request, $quiz)
    {
        try {
            $student = Auth::guard('sanctum')->user();
            $answers = collect($request->input('answers'));

            $attempt = $this->repo->findActiveAttempt($student->id, $quiz->id);

            if (!$attempt) {
                throw new Exception('No active quiz attempt found.');
            }

            $expired = now()->greaterThan($attempt->end_time);

            // Load questions with correct options (NO N+1)
            $questions = $quiz->questions()->with('options')->get();
            $totalQuestions = $questions->count();

            $score = $correct = $wrong = $skipped = 0;

            // Index answers by question_id
            $answersByQuestion = $answers->keyBy('question_id');

            // Remove old answers if resubmitting
            $attempt->answers()->delete();

            foreach ($questions as $question) {

                $correctOption = $question->options->firstWhere('is_correct', true);
                $answer = $answersByQuestion->get($question->id);

                if (!$answer || empty($answer['selected_option_id'])) {
                    $skipped++;
                    $this->repo->saveAttemptAnswer(
                        $attempt->id,
                        $question,
                        null,
                        $correctOption,
                        false
                    );
                    continue;
                }

                $selectedOption = $question->options
                    ->firstWhere('id', $answer['selected_option_id']);

                $isCorrect = $selectedOption &&
                    $correctOption &&
                    $selectedOption->id === $correctOption->id;

                match ($isCorrect) {
                    true => [$score++, $correct++],
                    false => $wrong++
                };

                $this->repo->saveAttemptAnswer(
                    $attempt->id,
                    $question,
                    $selectedOption,
                    $correctOption,
                    $isCorrect
                );
            }

            $this->repo->updateAttemptResult(
                $attempt,
                $score,
                $correct,
                $wrong,
                $skipped
            );

            return [
                'success' => true,
                'message' => $expired
                    ? 'Time limit exceeded, quiz auto-submitted.'
                    : 'Quiz submitted successfully',
                'data' => [
                    'score' => $score,
                    'correct_answers' => $correct,
                    'wrong_answers' => $wrong,
                    'skipped_questions' => $skipped,
                    'total_questions' => $totalQuestions
                ]
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }


    public function getQuizResult(Quiz $quiz)
    {
        try {
            $student = Auth::guard('sanctum')->user();
            $attempt = $this->repo->findCompletedAttempt($student->id, $quiz->id);

            if (!$attempt) {
                throw new Exception('No completed attempt found for this quiz.');
            }

            $answers = $this->repo->getAttemptAnswers($attempt->id);

            return [
                'success' => true,
                'message' => 'Quiz result fetched successfully',
                'data' => [
                    'quiz_id' => $quiz->id,
                    'score' => $attempt->score,
                    'total_questions' => $attempt->total_questions,
                    'correct_answers' => $attempt->correct_answers,
                    'wrong_answers' => $attempt->wrong_answers,
                    'skipped_questions' => $attempt->skipped_questions,
                    'attempted_at' => $attempt->created_at,
                    'answers' => $answers
                ]
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    public function getResultReview(Quiz $quiz){
        try {
            $student = Auth::guard('sanctum')->user();
            $attempt = $this->repo->findCompletedAttempt($student->id, $quiz->id);

            if (!$attempt) {
                throw new Exception('No completed attempt found for this quiz.');
            }

            $quiz = $this->repo->getQuizWithQuestions($quiz->id);

            $quizAttemptAnswer = QuizAttemptAnswer::where('quiz_attempt_id', $attempt->id)->get()->keyBy('question_id');

            $resultQuestions = $quiz->questions->map(function ($question) use ($quizAttemptAnswer) {
                $answer = $quizAttemptAnswer[$question->id]??null;

                return [
                    'question_id' => $question->id,
                    'question_text' => $question->question_text,
                    'solution' => $question->solution,
                    'options' => $question->options->map(function ($option) use ($answer) {
                        return [
                            'id' => $option->id,
                            'option_text' => $option->option_text,
                            'is_correct' => (bool)$option->is_correct,
                            'is_selected' => $answer?$answer->selected_option_id==$option->id:false,
                        ];
                    }),
                ];
            });

            return [
                'success' => true,
                'message' => 'Quiz result analytics fetched successfully',
                'data' => [
                    'quiz_id' => $quiz->id,
                    'quiz_title' => $quiz->title,
                    'data' => $resultQuestions
                ]
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
}
