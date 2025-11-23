<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\JsonResponse;

abstract class Controller extends BaseController
{
    use AuthorizesRequests,DispatchesJobs,ValidatesRequests;
    protected function successResponse(string $message,$data = []):JsonResponse{
        return response()->json([
            'success'=>true,
            'message'=>$message,
            'data'=>$data
        ]);
    }

    protected function systemErrorResponse(string $message):JsonResponse{
        return response()->json([
            'success'=>false,
            'status'=>'error',
            'message'=>'System error',
            'errors'=>$message,
            'data'=>[]
        ],500);
    }

        protected function validationErrorResponse(string $message, $status=422):JsonResponse
    {
        return response()->json([
            'success' => false,
            'status' => 'error',
            'message' => 'Validation failed!',
            'errors' =>$message,
            'data' => []
        ], $status);
    }
}
