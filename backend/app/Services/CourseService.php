<?php

namespace App\Services;

use App\Repositories\CourseRepository;
use Exception;

/**
 * Class CourseService.
 */
class CourseService
{
    protected $repo;

    public function __construct(CourseRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getAllCourses(){
        try {
            $courses = $this->repo->getAllCourses();
            return [
                'success'=>true,
                'data'=>['courses'=>$courses],
                'message'=>'Courses fetched successfully.'
            ];
        } catch (Exception $e) {
            return [
                'success'=>false,
                'message'=>$e->getMessage()
            ];
        }
    }
}
