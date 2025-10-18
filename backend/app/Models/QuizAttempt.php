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
        'corrrect_answers',
        'wrong_answers'
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
