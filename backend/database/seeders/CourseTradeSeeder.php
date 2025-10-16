<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseTrade;
use App\Models\Trade;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseTradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      $courses = Course::all();
      $trades = Trade::all();

        foreach ($courses as $course) {
            foreach ($trades as $trade) {
                CourseTrade::create([
                    'course_id' => $course->id,
                    'trade_id' => $trade->id,
                ]);
            }
        }
    }
}
