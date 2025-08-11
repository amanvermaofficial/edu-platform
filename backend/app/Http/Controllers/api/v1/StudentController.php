<?php

namespace App\Http\Controllers\api\v1;
use App\Http\Controllers\Controller;
use App\Http\Requests\Student\updateProfileRequest;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    
   public function updateProfile(updateProfileRequest $request){
    $user = Auth::user();

    $data = $request->only(['name','trade_id','gender','dob','state','district']);

    if($request->hasFile('profile_picture')){
        $path = $request->file('profile_picture')->store('profile_pictures','public');
        $data['profile_picture'] = $path;
    }

    $data['completed_profile'] = 1;

    $user->update($data);

    return response()->json([
        'success'=>true,
        'message'=>'Profile updated successfully',
        'data' => $user
    ]);
   }
}
