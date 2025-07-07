<?php

namespace App\Services\Otp;
use App\Services\Otp\OtpLogService;
use Illuminate\Database\Eloquent\Model;
use App\Models\OtpLog;
use Illuminate\Http\Request;
/**
 * Class SmsOtpService.
 */
class SmsOtpService implements OtpServiceInterface
{
    private OtpLogService $otpLogService;

    public function __construct(private Request $request,OtpLogService $otpLogService){
        $this->request= $request;
        $this->otpLogService=$otpLogService;
    }

    public function sendOtp(Model $recipient):bool{
        $otp=rand(100000,999999);
        $this->otpLogService->createOtpLog($recipient,$otp);
        //TODO: send SMS notification once SMS panel is ready
         return true;
    }

    public function verifyOtp(Model $recipient,string $otp):bool{
        $record=$this->otpLogService->getValidOtpRecord($recipient,$otp);

        if($record){
            $record = $this->otpLogService->getValidOtpRecord($recipient,$otp);

            if($record){
                $this->otpLogService->deleteExpiredotps();
                $record->delete();
                return true;
            }

            return false;
        }
    }
}
