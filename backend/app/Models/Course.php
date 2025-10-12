<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    public function trades(){
        return $this->belongsToMany(Trade::class,'course_trade')
    }

    public function quizzes(){
        return $this->belongsToMany(Quiz::class,'course_quiz')
    }

    public function trades(){
        return $this->hasMany(Trade::class)
    }
}
