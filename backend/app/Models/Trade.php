<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trade extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'is_active'
    ];

    public function students(){
        return $this->hasMany(Student::class,'trade_id');
    }

    public function courses(){
        return $this->belongsToMany(Course::class,'course_trade', 'trade_id','course_id');
    }

    public function quizzes(){
        return $this->belongsToMany(Quiz::class,'quiz_course_trade','trade_id','quiz_id');
    }
}
