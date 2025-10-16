<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseTrade extends Model
{
    protected $table = 'course_trade';
    protected $fillable = ['course_id','trade_id'];

    public function quizzes()
    {
        return $this->belongsToMany(Quiz::class,'quiz_course_trade','course_trade_id','quiz_id');
    }
}
