<?php

namespace App\Services\Otp;
use App\Models\OtpLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;  

/**
 * Class OtpLogService.
 */
class OtpLogService
{
    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }


    public function createOtpLog(Model $recpient,string $otp):OtpLog{
        return OtpLog::create([
            'recipient_id'=>$recpient->id,
            'recipient_ip'=>$this->request->ip(),
            'otp'=>$otp,
            'created_at'=>now(),
        ]);
    }

    public function getValidOtpRecord(Model $recipient,string $otp):?OtpLog{
        return OtpLog::where('recipient_id',$recipient->id)
        ->where('otp',$otp)
        ->where('created_at','>=',now()->subMinutes(10))
        ->first();
    }

    public function deleteExpiredOtps():void {
        OtpLog::where('created_at','<',now()->subMinutes(10))->delete();
    }
}
