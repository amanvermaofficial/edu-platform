<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\QuizDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\QuizRequest;
use App\Models\CourseTrade;
use App\Models\Quiz;
use App\Services\Admin\QuizService;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    protected $service;

    public function __construct(QuizService $service)
    {
        $this->service = $service;

        $this->middleware('permission:quizzes.view')->only('index');
        $this->middleware('permission:quizzes.create')->only(['create', 'store']);
        $this->middleware('permission:quizzes.update')->only(['edit', 'update']);
        $this->middleware('permission:quizzes.delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(QuizDataTable $dataTable)
    {
        return $dataTable->render('admin.quizzes.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courseTrades = CourseTrade::with(['course', 'trade'])->get();
        return view('admin.quizzes.create', compact('courseTrades'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(QuizRequest $request)
    {
        $this->service->create($request->validated());
        return redirect()->route('admin.quizzes.index')
            ->with('success', 'Quiz created successfully');
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
    public function edit(Quiz $quiz)
    {
        $courseTrades = CourseTrade::with(['course', 'trade'])->get();
        return view('admin.quizzes.edit', compact('quiz', 'courseTrades'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(QuizRequest $request, Quiz $quiz)
    {
        $this->service->update($quiz, $request->validated());

        return redirect()->route('admin.quizzes.index')
            ->with('success', 'Quiz updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quiz $quiz)
    {
        $this->service->delete($quiz);
        return back()->with('success', 'Quiz deleted successfully');
    }
}
