<?php

namespace App\Services;

use App\Models\Course;
use App\Repositories\TradeRepository;
use Exception;

/**
 * Class TradeService.
 */
class TradeService
{
    protected $repo;

    public function __construct(TradeRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getAllTrades(){
        try{
            $trades = $this->repo->getAllTrade();
            return ['success'=>true,'data'=>['trades'=>$trades],'message'=>'Trades fetched successfully.'];
        }catch(Exception $e){
            return ['success'=>false,'message'=>$e->getMessage()];
        }
    }

    public function getTradesByCourse(Course $course){
        try {
            $trades = $this->repo->getTradesByCourse($course);
            return ['success'=>true,'data'=>['trades'=>$trades],'message'=>'Trades fetched successfully.'];
        } catch (Exception $e) {
            return ['success'=>false,'message'=>$e->getMessage()];
        }
    }
}
