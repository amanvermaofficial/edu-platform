<?php
namespace App\Repositories;
use App\Models\Student;

class StudentRepository{
    public function findById($id){
        return Student::find($id);
    }

    public function update(Student $student,array $data){
        $student->update($data);
        return $student;
    }
}