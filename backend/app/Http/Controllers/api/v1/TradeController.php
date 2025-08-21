<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Trade;
use Illuminate\Http\Request;

class TradeController extends Controller
{
    public function index(){
        $trades = Trade::all();
        return response()->json([
            'success'=>true,
            'message'=>'Trades fetched successfully',
            'trades' => $trades
        ]);
    }
}
