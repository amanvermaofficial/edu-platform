<?php

namespace App\Services\Otp;
use App\Models\OtpLog;

/**
 * Class OtpLogService.
 */
class OtpLogService
{
    public function createOtpLog(Model $recpient,string $otp):OtpLog{
        return OtpLog::create([
            'recipient_id'=>$recpient->id,
            'recipient_ip'=>$this->request->ip(),
            'otp'=>$otp,
            'created_at'=>now(),
        ]);
    }

    public function getValidOtpRecord(Model $recpient,string $otp):?OtpLog{
        return OtpLog::where('recipient_id',$recpient->id)
        ->where('otp',$otp)
        ->where('created_at','>=',now()->subMinutes(10))
        ->first();
    }

    public function deleteExpiredOtps():void {
        OtpLog::where('created_at','<',now()->subMintues(10))->delete();
    }
}
