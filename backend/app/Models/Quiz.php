<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
  protected $fillable = ['title','description', 'duration', 'total_marks'];

  public function courseTrades(){
    return $this->belongsToMany(CourseTrade::class,'quiz_course_trade','quiz_id','course_trade_id');
  }

  public function questions(){
    return $this->hasMany(Question::class);
  }

}
