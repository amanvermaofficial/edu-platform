<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Trade;
use App\Services\Admin\CourseTradeService;
use Illuminate\Http\Request;

class CourseTradeController extends Controller
{
    public function index(Course $course)
    {
         return view('admin.course_trade.index', [
            'course' => $course,
            'trades' => Trade::orderBy('name')->get(),
            'mappedTrades' => $course->trades->pluck('id')->toArray(),
        ]);
    }


    public function update(Request $request, Course $course, CourseTradeService $service)
    {
        $request->validate([
            'trade_ids' => 'nullable|array',
        ]);

        $service->updateMapping($course, $request->trade_ids ?? []);

        return redirect()
            ->route('admin.courses.index')
            ->with('success', 'Trades mapped successfully!');
    }
}
