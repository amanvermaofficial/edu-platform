<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\StudentDataTable;
use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Services\Admin\StudentService;
use Exception;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    protected $service;

    public function __construct(StudentService $service)
    {
        $this->service = $service;

        $this->middleware('permission:students.view')->only(['index','show']);
        $this->middleware('permission:students.delete')->only(['destroy']);
    }

    public function index(StudentDataTable $dataTable){
        return $dataTable->render('admin.students.index');
    }

    public function show(Student $student){
        $student = $this->service->getStudentDetail($student);
        return view('admin.students.show', compact('student'));
    }

    public function destroy(Student $student){
        try {
            $this->service->delete($student);

            return redirect()
                ->route('admin.students.index')
                ->with('success', 'Student deleted successfully.');
        } catch (Exception $e) {
               return back()->with('error', $e->getMessage());
        }
    }

}
