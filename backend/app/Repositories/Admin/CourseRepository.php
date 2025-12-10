<?php

namespace App\Repositories\Admin;

use App\Models\Course;

class CourseRepository
{
    public function getAll()
    {
        return Course::query();
    }

    public function find($id)
    {
        return Course::findOrFail($id);
    }

    public function create(array $data)
    {
        return Course::create($data);
    }

    public function update(Course $course, array $data)
    {
        $course->update($data);
        return $course;
    }

    public function delete(Course $course)
    {
        return $course->delete();
    }
}
