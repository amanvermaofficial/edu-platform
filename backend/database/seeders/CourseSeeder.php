<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          $courses = [
            ['name' => 'CTS', 'description' => 'Craftsmen Training Scheme'],
            ['name' => 'CITS', 'description' => 'Craft Instructor Training Scheme'],
            ['name' => 'Apprenticeship', 'description' => 'Apprenticeship Training Program'],
        ];

        foreach ($courses as $course) {
            Course::create($course);
        }
    }
}
