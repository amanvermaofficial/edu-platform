<?php

namespace App\Imports;

use App\Models\Option;
use App\Models\Question;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class QuizQuestionImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    protected $quizId;
    protected $inserted = 0;

    public function __construct($quizId)
    {
        $this->quizId = $quizId;
    }


    public function collection(Collection $rows)
    {
        DB::beginTransaction();
        try {
            foreach ($rows as $index => $row) {
                if (empty($row['question'])) {
                    continue;
                }

                $row =  $row->map(fn($v) => is_string($v) ? trim($v) : $v);

                if (
                    Question::where('quiz_id', $this->quizId)
                    ->where('question_text', $row['question'])
                    ->exists()
                ) {
                    continue;
                }

                $options = [
                    'A' => $row['option_a'] ?? null,
                    'B' => $row['option_b'] ?? null,
                    'C' => $row['option_c'] ?? null,
                    'D' => $row['option_d'] ?? null,
                ];

                if (in_array(null, $options, true)) {
                    throw new Exception('Invalid correct option at row' . ($index + 2));
                }

                if (!in_array($row['correct_option'], $options, true)) {
                    throw new Exception('Invalid correct option at row' . ($index + 2));
                }

                $question = Question::create([
                    'quiz_id' => $this->quizId,
                    'question_text' => $row['question'],
                ]);

                foreach ($options as $key => $text) {
                    Option::create([
                        'question_id' => $question->id,
                        'option_text' => $text,
                        'is_correct' => ($row['correct_option'] === $text),
                    ]);
                }
                 $this->inserted++;
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function getInsertedCount(): int
    {
        return $this->inserted;
    }
}
