<?php

namespace App\Repositories;

use App\Models\Course;
use App\Models\Trade;

class TradeRepository{
    public function getAllTrade(){
        return Trade::select('name')->get();
    }

    public function getTradesByCourse(Course $course)
    {
        return $course->trades()
            ->select('trades.id','trades.name','trades.description')
            ->get();
    }
}