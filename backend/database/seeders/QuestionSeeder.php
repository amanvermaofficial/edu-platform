<?php

namespace Database\Seeders;

use App\Models\Quiz;
use App\Models\Question;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $quizzes = Quiz::all();

       foreach($quizzes as $quiz){
        for($i =1;$i<=5;$i++){
            Question::create([
                'quiz_id'=>$quiz->id,
                'question_text'=>"Question $i for Quiz {$quiz->id}"
            ]);
        }
       }
    }
}
