<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $table = 'questions';

    protected $fillable = [
        'course_id',
        'trade_id',
        'quiz_id',
        'question_text',
        'solution',
    ];

    public function options(){
        return $this->hasMany(Option::class);
    }

    public function quiz(){
        return $this->belongsTo(Quiz::class);
    }
}
