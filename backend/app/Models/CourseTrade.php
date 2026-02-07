<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseTrade extends Model
{
    use HasFactory;
    protected $table = 'course_trade';
    protected $fillable = ['course_id','trade_id'];

     /**
     * Course relation
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Trade relation
     */
    public function trade()
    {
        return $this->belongsTo(Trade::class);
    }

    public function quizzes()
    {
        return $this->belongsToMany(Quiz::class,'quiz_course_trade','course_trade_id','quiz_id');
    }
}
