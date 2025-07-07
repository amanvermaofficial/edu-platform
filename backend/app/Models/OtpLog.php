<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtpLog extends Model
{
    protected $fillable = [
    'recipient_id',
    'recipient_ip',
    'otp'
    ];
}
