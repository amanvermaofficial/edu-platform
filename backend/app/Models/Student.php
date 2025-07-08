<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Student extends Authenticatable
{
  use HasApiTokens;
  protected $fillable = [
    'name',
    'phone',
    'trade_id',
    'gender',
    'district',
    'dob',
    'mobile_verified_at',
    'completed_profile',
  ];
}
