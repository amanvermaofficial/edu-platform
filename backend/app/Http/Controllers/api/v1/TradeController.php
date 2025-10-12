<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Trade;
use Exception;
use Illuminate\Http\Request;

class TradeController extends Controller
{
    public function getTradesByCourse(Course $course){
        try {
            $trades = $course->trades()->select('id', 'name', 'description')->get();

           return $this->successResponse('Trades fetched successfully',['trades'=>$trades])
        } catch (Exception $e) {
            return $this->systemErrorResponse($e->getMessage())
        }
    }
}
