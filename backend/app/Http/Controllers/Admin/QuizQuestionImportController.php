<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\QuizQuestionImport;
use App\Models\Quiz;
use Exception;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class QuizQuestionImportController extends Controller
{
    public function create()
    {
        $quizzes = Quiz::all();
        return view('admin.quiz_questions.import', compact('quizzes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'quiz_id' => 'required|exists:quizzes,id',
            'file' => 'required|mimes:csv,xlsx',
        ]);

        try {
            $import = new QuizQuestionImport($request->quiz_id);
            Excel::import(
                $import,
                $request->file
            );
            return back()->with('success', $import->getInsertedCount() . ' questions imported successfully!');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
