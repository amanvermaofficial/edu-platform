<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'description',
    ];

    public function trades(){
        return $this->belongsToMany(Trade::class,'course_trade','course_id', 'trade_id');
    }

    public function quizzes(){
        return $this->belongsToMany(Quiz::class,'quiz_course_trade','course_id','quiz_id');
    }

}
