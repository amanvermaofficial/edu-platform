<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
  protected $fillable = ['name','description', 'duration', 'total_marks']

  public function courses(){
    return $this->belongsToMany(Course::class,'course_quiz')
  }

  public function trades(){
      $this->belongsToMany(Trade::class,'trade_quiz');
  }

  public function questions(){
    return $this->hasMany(Question::class);
  }

}
