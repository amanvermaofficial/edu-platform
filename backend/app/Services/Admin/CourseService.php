<?php

namespace App\Services\Admin;

use App\Repositories\Admin\CourseRepository;
use Exception;
use Illuminate\Support\Facades\DB;

class CourseService
{
    protected $repo;

    public function __construct(CourseRepository $repo)
    {
        $this->repo = $repo;
    }

    public function list()
    {
        return $this->repo->getAll();
    }

    public function create(array $data)
    {
            $course = $this->repo->create($data);
            return $course;
    }

    public function update($course, array $data)
    {
            $course = $this->repo->update($course, $data);
            return $course;
    }

    public function delete($course)
    {
        return $this->repo->delete($course);
    }

    /**
     * Useful for populating select dropdowns
     */
    public function getForSelect()
    {
        return \App\Models\Course::orderBy('name')->get();
    }
}
