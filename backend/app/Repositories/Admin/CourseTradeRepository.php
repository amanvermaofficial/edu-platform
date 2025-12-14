<?php

namespace App\Repositories\Admin;

use App\Models\Course;

class CourseTradeRepository
{
    public function syncTrades(Course $course, $tradeIds)
    {
        return $course->trades()->sync($tradeIds);
    }
}
