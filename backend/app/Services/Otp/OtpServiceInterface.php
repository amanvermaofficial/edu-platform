<?php

namespace App\Services\Otp;
use Illuminate\Database\Eloquent\Model;

interface OtpServiceInterface
{
    public function sendOtp(Model $recipient):bool;

    public function verifyOtp(Model $recipient,string $otp): bool;
}
