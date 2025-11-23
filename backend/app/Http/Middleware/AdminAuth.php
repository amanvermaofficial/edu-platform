<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class AdminAuth extends Middleware
{
    protected function redirectTo($request)
    {
        return route('admin.login');   
    }
}
