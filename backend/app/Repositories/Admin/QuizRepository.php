<?php

namespace App\Repositories\Admin;

use App\Models\Quiz;

class QuizRepository
{
    public function getAll(){
        return Quiz::latest();
    }

     public function create(array $data)
    {
        return Quiz::create($data);
    }

    public function update(Quiz $quiz, array $data)
    {
        $quiz->update($data);
        return $quiz;
    }

    public function delete(Quiz $quiz)
    {
        return $quiz->delete();
    }

    public function syncCourseTrades(Quiz $quiz, array $courseTradeIds)
    {
        $quiz->courseTrades()->sync($courseTradeIds);
    }
}