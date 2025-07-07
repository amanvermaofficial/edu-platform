<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Student extends Authenticatable
{
      protected $fillable = [
        'name',
        'mobile',
        'trade_id',
        'gender',
        'district',
        'dob',
        'mobile_verified_at',
        'completed_profile',
    ];
}
