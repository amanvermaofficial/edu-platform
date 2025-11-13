<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizAttempt extends Model
{
    protected $fillable = [
        'student_id',
        'quiz_id',
        'score',
        'total_questions',
        'correct_answers',
        'wrong_answers',
        'start_time',
        'end_time',
        'duration',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function quiz(){
        return $this->belongsTo(Quiz::class);
    }

    public function answers()
    {
        return $this->hasMany(QuizAttemptAnswer::class);
    }
}
