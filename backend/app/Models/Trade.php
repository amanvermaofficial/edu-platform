<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trade extends Model
{
    protected $fillable = [
        'name',
        'description',
        'is_active'
    ];

    public function students(){
        return $this->hasMany(Student::class,'trade_id');
    }

    public function courses(){
        return $this->belongsTo(Course::class,'course_trade')
    }

    public function quizzes(){
        return $this->belongsToMany(Quiz::class,'quiz_trade')
    }
}
