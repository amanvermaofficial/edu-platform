<?php

namespace App\DataTables;

use App\Models\QuizAttempt;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class QuizAttemptDataTable extends DataTable
{
    public function dataTable($query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()

            ->addColumn('student', fn($row) => $row->student?->name ?? '-')
            ->addColumn('quiz', fn($row) => $row->quiz?->title ?? '-')

            ->editColumn(
                'score',
                fn($row) =>
                $row->score . ' / ' . $row->total_questions
            )

            ->addColumn('actions', function ($row) {
                $viewUrl = route('admin.quiz-attempts.show', $row->id);

                return '
                <a href="' . $viewUrl . '" class="btn btn-sm btn-secondary">
                        <i class="fas fa-eye"></i>
                    </a>
                ';
            })

            ->editColumn(
                'created_at',
                fn($row) =>
                $row->created_at?->format('d M Y, h:i A')
            )

          ->rawColumns(['actions']);
    }


    public function query(QuizAttempt $model)
    {
        return $model->with(['student', 'quiz'])->latest();
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('quiz-attempts-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->parameters([
                'responsive' => true,
                'autoWidth' => false,
                'pageLength' => 10,
            ]);
    }

    protected function getColumns()
    {
        return [
            [
                'data' => 'DT_RowIndex',
                'title' => '#',
                'orderable' => false,
                'searchable' => false,
            ],
            [
                'data' => 'student',
                'title' => 'Student',
            ],
            [
                'data' => 'quiz',
                'title' => 'Quiz',
            ],
            [
                'data' => 'total_questions',
                'title' => 'Total Qs',
            ],
            [
                'data' => 'correct_answers',
                'title' => 'Correct',
            ],
            [
                'data' => 'wrong_answers',
                'title' => 'Wrong',
            ],
            [
                'data' => 'score',
                'title' => 'Score',
            ],
            [
                'data' => 'created_at',
                'title' => 'Attempted At',
            ],
            ['data' => 'actions', 'title' => 'Actions', 'orderable' => false, 'searchable' => false],

        ];
    }

    protected function filename(): string
    {
        return 'QuizAttempts_' . date('YmdHis');
    }
}
