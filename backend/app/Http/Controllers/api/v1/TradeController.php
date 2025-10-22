<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Trade;
use App\Services\TradeService;
use Exception;
use Illuminate\Http\Request;

class TradeController extends Controller
{
    protected $service;

    public function __construct(TradeService $service)
    {
        $this->service = $service;
    }
    public function index(){
       $result = $this->service->getAllTrades();

       if($result['success']){
        return $this->successResponse($result['message'],$result['data']);
       }

       return $this->systemErrorResponse($result['message']);
    }
    public function getTradesByCourse(Course $course){
        $result = $this->service->getTradesByCourse($course);

        if($result['success']){
        return $this->successResponse($result['message'],$result['data']);
        }
        
        return $this->systemErrorResponse($result['message']);
    }
}
