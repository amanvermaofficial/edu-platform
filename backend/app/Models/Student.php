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
    'state',
    'district',
    'dob',
    'profile_picture',
    'mobile_verified_at',
    'completed_profile',
  ];

  public function trade()
  {
    return $this->belongsTo(Trade::class, 'trade_id');
  }
}
