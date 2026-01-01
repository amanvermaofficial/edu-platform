<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\CourseDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CourseRequest;
use App\Models\Course;
use App\Services\Admin\CourseService;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    protected $service;

    public function __construct(CourseService $service)
    {
        $this->service = $service;

        $this->middleware('permission:courses.view')->only(['index']);
        $this->middleware('permission:courses.create')->only(['create', 'store']);
        $this->middleware('permission:courses.edit')->only(['edit', 'update']);
        $this->middleware('permission:courses.delete')->only(['destroy']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(CourseDataTable $dataTable)
    {
        return $dataTable->render('admin.courses.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.courses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CourseRequest $request)
    {
        $this->service->create($request->validated());
        return redirect()->route('admin.courses.index')->with('success', 'Course created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        return view('admin.courses.edit', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CourseRequest $request, Course $course)
    {
        $this->service->update($course, $request->validated());
        return redirect()->route('admin.courses.index')->with('success', 'Course updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        $this->service->delete($course);
        return redirect()->route('admin.courses.index')->with('success', 'Course deleted successfully.');
    }
}
