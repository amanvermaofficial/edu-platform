<?php

namespace Database\Seeders;

use App\Models\CourseTrade;
use App\Models\Quiz;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courseTrades=CourseTrade::all();
        foreach($courseTrades as $ct){
            for($i=1;$i<=3;$i++){
                $quiz=Quiz::create([
                    'title'=>"Quiz $i for Course {$ct->course_id}-Trade{$ct->trade_id}",
                    'description'=>'This is a sample quiz for testing.'
                ]);

                $quiz->courseTrades()->attach($ct->id);
            }
        }
    }
}
