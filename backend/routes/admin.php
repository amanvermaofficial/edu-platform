<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('admin.index');
});
Route::get('/login', function () {
    return view('admin.auth.login');
});
