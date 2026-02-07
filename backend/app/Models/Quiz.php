<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
  use HasFactory;
  protected $fillable = ['title', 'description', 'duration', 'total_marks', 'is_active'];

  protected $casts = [
    'is_active' => 'boolean',
  ];


  public function courseTrades()
  {
    return $this->belongsToMany(CourseTrade::class, 'quiz_course_trade', 'quiz_id', 'course_trade_id');
  }

  public function questions()
  {
    return $this->hasMany(Question::class);
  }
}
