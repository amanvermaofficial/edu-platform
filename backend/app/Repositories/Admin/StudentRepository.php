<?php

namespace App\Repositories\Admin;

use App\Models\Student;

class StudentRepository
{
    public function findWithRelations(Student $student)
    {
        return $student->load(['course', 'trade']);
    }

    public function delete(Student $student)
    {
        return $student->delete();
    }
}
