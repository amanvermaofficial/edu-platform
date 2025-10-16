<?php

namespace Database\Seeders;

use App\Models\Option;
use App\Models\Question;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $questions = Question::all();

        foreach ($questions as $question) {
            $options = [
                ['option_text' => 'Option A', 'is_correct' => false],
                ['option_text' => 'Option B', 'is_correct' => false],
                ['option_text' => 'Option C', 'is_correct' => true],
                ['option_text' => 'Option D', 'is_correct' => false],
            ];

            foreach ($options as $opt) {
                Option::create([
                    'question_id' => $question->id,
                    'option_text' => $opt['option_text'],
                    'is_correct' => $opt['is_correct'],
                ]);
            }
        }
    }
}
