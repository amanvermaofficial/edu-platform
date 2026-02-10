<?php

namespace Tests\Feature\Api\V1;

use App\Models\Course;
use App\Models\CourseTrade;
use App\Models\Option;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\Student;
use App\Models\Trade;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class QuizTest extends TestCase
{
    use RefreshDatabase;

    protected function authHeader()
    {
        $student = Student::factory()->create();
        $token = $student->createToken('test')->plainTextToken;

        return [
            'Authorization' => 'Bearer ' . $token,
        ];
    }

    protected function createQuizWithQuestion()
    {
        $quiz = Quiz::factory()->create(['duration' => 60]);

        $question = Question::factory()->create([
            'quiz_id' => $quiz->id
        ]);

        $correct = Option::factory()->create([
            'question_id' => $question->id,
            'is_correct' => true
        ]);

        Option::factory()->count(3)->create([
            'question_id' => $question->id,
            'is_correct' => false
        ]);

        return [$quiz, $question, $correct];
    }

    public function test_can_get_quizzes_for_course_trade()
    {
        $course = Course::factory()->create();
        $trade  = Trade::factory()->create();

        $courseTrade = CourseTrade::create([
            'course_id' => $course->id,
            'trade_id'  => $trade->id,
        ]);

        Quiz::factory()->count(3)->create([
            'is_active' => true,
        ])->each(fn($quiz) => $quiz->courseTrades()->attach($courseTrade->id));

        $response = $this->withHeaders($this->authHeader())
            ->getJson("/api/v1/courses/{$course->id}/trades/{$trade->id}/quizzes");


        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => ['quizzes']
            ]);
    }

    public function test_can_show_quiz()
    {
        [$quiz] = $this->createQuizWithQuestion();

        $response = $this->withHeaders($this->authHeader())
            ->getJson("/api/v1/quizzes/{$quiz->id}");


        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'quiz' => [
                        'questions'
                    ]
                ]
            ]);
    }

    public function test_student_can_start_quiz()
    {
        [$quiz] = $this->createQuizWithQuestion();

        $response = $this->withHeaders($this->authHeader())
            ->postJson("/api/v1/quizzes/{$quiz->id}/start");


        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Quiz started successfully',
            ]);
    }

    public function test_student_cannot_start_completed_quiz()
    {
        $student = Student::factory()->create();
        [$quiz] = $this->createQuizWithQuestion();

        QuizAttempt::create([
            'student_id' => $student->id,
            'quiz_id' => $quiz->id,
            'total_questions' => 1,
            'score' => 1,
            'start_time' => now(),
            'end_time' => now(),
        ]);

        $token = $student->createToken('test')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])
            ->postJson("/api/v1/quizzes/{$quiz->id}/start");

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'COMPLETED'
            ]);
    }

    public function test_student_can_submit_quiz()
    {
        $student = Student::factory()->create();
        [$quiz, $question, $correct] = $this->createQuizWithQuestion();
        QuizAttempt::create([
            'student_id' => $student->id,
            'quiz_id' => $quiz->id,
            'total_questions' => 1,
            'start_time' => now(),
            'end_time' => now()->addMinute(),
        ]);

        $token = $student->createToken('test')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson("/api/v1/quizzes/{$quiz->id}/submit", [
                'answers' => [
                    [
                        'question_id' => $question->id,
                        'selected_option_id' => $correct->id
                    ]
                ]
            ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true
            ]);
    }

    public function test_student_can_view_quiz_result()
    {
        $student = Student::factory()->create();
        [$quiz] = $this->createQuizWithQuestion();

         QuizAttempt::create([
            'student_id' => $student->id,
            'quiz_id' => $quiz->id,
            'total_questions' => 1,
            'score' => 1,
            'correct_answers' => 1,
            'wrong_answers' => 0,
            'skipped_questions' => 0,
            'start_time' => now(),
            'end_time' => now(),
        ]);

        $token = $student->createToken('test')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer '.$token)
            ->getJson("/api/v1/quizzes/{$quiz->id}/result");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'score',
                    'total_questions',
                    'correct_answers'
                ]
            ]);

    }
}
