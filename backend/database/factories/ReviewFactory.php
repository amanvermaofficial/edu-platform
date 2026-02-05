<?php

namespace Database\Factories;

use App\Models\Review;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Review::class;
    public function definition(): array
    {
        return [
            'student_id'=> Student::factory(),
            'description' => $this->faker->sentence(),
            'is_published' => $this->faker->boolean(),
        ];
    }
}
