<?php

namespace App\DataTables;

use App\Models\Quiz;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class QuizDataTable extends DataTable
{
    /**
     * Build DataTable class.
     */
    public function dataTable($query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()

            ->editColumn('title', function ($row) {
                return ucfirst($row->title);
            })

            ->editColumn('duration', function ($row) {
                return $row->duration ? $row->duration . ' seconds' : '-';
            })

            ->editColumn('total_marks', function ($row) {
                return $row->total_marks ?? '-';
            })

            ->editColumn('created_at', function ($row) {
                return $row->created_at
                    ? $row->created_at->format('d M Y, h:i A')
                    : '-';
            })

            ->addColumn('status', function ($row) {
                return $row->is_active
                    ? '<span class="badge badge-success">Active</span>'
                    : '<span class="badge badge-secondary">Inactive</span>';
            })

            ->addColumn('toggle', function ($row) {

                if (!auth()->user()->can('quizzes.update')) {
                    return '-';
                }

                $toggleUrl = route('admin.quizzes.toggle-status', $row->id);

                return '
        <form action="' . $toggleUrl . '" method="POST" style="display:inline">
            ' . csrf_field() . '
            <button type="submit"
                class="btn btn-sm ' . ($row->is_active ? 'btn-warning' : 'btn-success') . '"
                onclick="return confirm(\'Are you sure?\')">
                ' . ($row->is_active ? 'Deactivate' : 'Activate') . '
            </button>
        </form>
    ';
            })


            ->addColumn('actions', function ($row) {
                $editUrl   = route('admin.quizzes.edit', $row->id);
                $deleteUrl = route('admin.quizzes.destroy', $row->id);

                $buttons = '<div class="btn-group">';

                if (auth()->user()->can('quizzes.edit')) {
                    $buttons .= '<a href="' . $editUrl . '" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>';
                }

                if (auth()->user()->can('quizzes.delete')) {
                    $buttons .= '
                    <form action="' . $deleteUrl . '" method="POST" style="display:inline">
                        ' . csrf_field() . method_field('DELETE') . '
                        <button class="btn btn-sm btn-danger">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>';
                }

                $buttons .= '</div>';

                return $buttons;
            })

            ->rawColumns(['actions', 'status', 'toggle'])

            ->setRowId('id');
    }

    /**
     * Get query source.
     */
    public function query(Quiz $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional HTML builder.
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('quizzes-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1, 'asc')
            ->parameters([
                'responsive' => true,
                'autoWidth'  => false,
                'lengthMenu' => [[10, 25, 50, -1], [10, 25, 50, 'All']],
                'pageLength' => 10,
            ]);
    }

    /**
     * Table columns.
     */
    protected function getColumns()
    {
        return [
            [
                'data'       => 'DT_RowIndex',
                'name'       => 'DT_RowIndex',
                'title'      => '#',
                'orderable'  => false,
                'searchable' => false,
                'width'      => '5%',
                'className'  => 'text-center',
            ],
            [
                'data'  => 'title',
                'name'  => 'title',
                'title' => 'Quiz Name',
            ],
            [
                'data'  => 'duration',
                'name'  => 'duration',
                'title' => 'Duration',
                'className' => 'text-center',
            ],
            [
                'data'  => 'total_marks',
                'name'  => 'total_marks',
                'title' => 'Total Marks',
                'className' => 'text-center',
            ],
            [
                'data'  => 'created_at',
                'name'  => 'created_at',
                'title' => 'Created At',
                'className' => 'text-center',
            ],
            [
                'data' => 'status',
                'title' => 'Status',
                'orderable' => false,
                'searchable' => false,
                'className' => 'text-center',
            ],
            [
                'data' => 'toggle',
                'title' => 'Toggle',
                'orderable' => false,
                'searchable' => false,
                'className' => 'text-center',
            ],
            [
                'data'       => 'actions',
                'name'       => 'actions',
                'title'      => 'Actions',
                'orderable'  => false,
                'searchable' => false,
                'width'      => '15%',
                'className'  => 'text-center',
            ],
        ];
    }

    /**
     * Export filename.
     */
    protected function filename(): string
    {
        return 'Quizzes_' . date('YmdHis');
    }
}
