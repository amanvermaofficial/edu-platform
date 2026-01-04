<?php

namespace App\Services;

use Auth;
use Exception;
use App\Repositories\StudentRepository;

/**
 * Class StudentService.
 */
class StudentService
{
    protected $repo;

    public function __construct(StudentRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getProfile()
    {
        try {
            $student = Auth::guard('sanctum')->user()->load(['course','trade']); // Auth::user()->load('course','trade');

            if (!$student) {
                return [
                    'success' => false,
                    'status' => 401,
                    'message' => 'Unauthenticated',
                    'data' => null
                ];
            }

            return [
                'success' => true,
                'status' => 200,
                'message' => 'Profile fetched successfully',
                'data' => $student
            ];
        } catch (Exception $e) {
            return [
                'success'=>false,
                'status'=>500,
                'message'=>$e->getMessage()
            ];
        }
    }

    public function updateProfile($request){
        try {
            $user = Auth::user();
            $data = $request->only(['name','email','course_id','trade_id','gender','state']);

            if($request->hasFile('profile_picture')){
                $path =$request->file('profile_picture')->store('profile_pictures','public');
                $data['profile_picture'] = $path;
            }

               $data['completed_profile'] = 1;

               $updatedUser = $this->repo->update($user, $data);
               $updatedUser->load(['course','trade']);

            return [
                'success' => true,
                'status' => 200,
                'message' => 'Profile updated successfully',
                'data' => $updatedUser
            ];
        } catch (Exception $e) {
              return [
                'success' => false,
                'status' => 500,
                'message' => $e->getMessage()
            ];
        }
    }
}
