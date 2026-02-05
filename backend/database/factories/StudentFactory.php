<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Trade;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'google_id' => null,
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->numerify('9#########'),
            'course_id' => Course::factory(),
            'trade_id' => Trade::factory(),
            'gender' => $this->faker->randomElement(['male', 'female']),
            'state' => $this->faker->state,
            'profile_picture' => null,
            'mobile_verified_at' => now(),
            'completed_profile' => true,
        ];
    }
}
