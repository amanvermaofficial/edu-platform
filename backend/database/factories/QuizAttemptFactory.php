<?php

namespace Database\Factories;

use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\Student;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

use function Symfony\Component\Clock\now;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\QuizAttempt>
 */
class QuizAttemptFactory extends Factory
{
    protected $model = QuizAttempt::class;
    public function definition(): array
    {
        $start = Carbon::now();
        $end = $start->copy()->addMinutes(10);
        return [
            'student_id' => Student::factory(),
            'quiz_id' => Quiz::factory(),
            'score' => 0,
            'total_questions' => 10,
            'correct_answers' => 0,
            'wrong_answers' => 0,
            'skipped_questions' => 0,
            'start_time' => $start,
            'end_time' => $end,
            'duration' => 600,
        ];
    }

    public function completed():static{
        return $this->state(fn () => [
            'score' => 7,
            'correct_answers' => 7,
            'wrong_answers' => 3,
            'skipped_questions' => 0,
        ]);
    }

    public function expired(): static
    {
        return $this->state(fn () => [
            'end_time' => now()->subMinutes(5),
        ]);
    }
}
