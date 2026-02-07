<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Trade;
use App\Models\CourseTrade;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseTradeFactory extends Factory
{
    protected $model = CourseTrade::class;

    public function definition(): array
    {
        return [
            'course_id' => Course::factory(),
            'trade_id' => Trade::factory(),
        ];
    }
}
