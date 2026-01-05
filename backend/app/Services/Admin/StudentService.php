<?php

namespace App\Services\Admin;

use App\Models\Student;
use App\Repositories\Admin\StudentRepository;

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

    public function getStudentDetail(Student $student)
    {
        return $this->repo->findWithRelations($student);
    }

    public function delete(Student$student)
    {
        return $this->repo->delete($student);
    }
}
