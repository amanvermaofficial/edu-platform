<?php

namespace Tests\Feature\Api\V1;

use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StudentPerformanceTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_can_view_performance()
    {
        $student = Student::factory()->create();

        $quiz = Quiz::factory()->create();

        QuizAttempt::factory()->create([
            'student_id' => $student->id,
            'quiz_id' => $quiz->id,
            'score' => 8,
            'total_questions' => 10,
        ]);

         $response = $this->actingAs($student, 'sanctum')
            ->getJson('/api/v1/student/performance');

         $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    'performance' => [
                        'total_quizzes',
                        'average_score',
                        'best_score',
                        'last_attempt',
                    ],
                    'quiz_history'
                ]
            ]);    
    }
}
