<?php

namespace App\Repositories;

use App\Models\Course;

class CourseRepository{
    public function getAllCourses(){
        return Course::select('id','name','description')->get();
    }
}