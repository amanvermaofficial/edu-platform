<?php

namespace App\DataTables;

use App\Models\Review;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class ReviewDataTable extends DataTable
{
    /**
     * Build DataTable class.
     */
    public function dataTable($query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()

            ->editColumn('student', function ($row) {
                return $row->student?->name ?? '-';
            })

            ->editColumn('description', function ($row) {
                return strlen($row->description) > 60
                    ? substr($row->description, 0, 60) . '...'
                    : $row->description;
            })

            ->editColumn('created_at', function ($row) {
                return $row->created_at
                    ? $row->created_at->format('d M Y, h:i A')
                    : '-';
            })

            ->editColumn('published_at', function ($row) {
                return $row->published_at
                    ? $row->published_at->format('d M Y, h:i A')
                    : '-';
            })

            ->addColumn('status', function ($row) {
                return $row->is_published
                    ? '<span class="badge badge-success">Published</span>'
                    : '<span class="badge badge-warning">Pending</span>';
            })

            ->addColumn('actions', function ($row) {
                $viewUrl   = route('admin.reviews.show', $row->id);
                $deleteUrl = route('admin.reviews.destroy', $row->id);

                $buttons = '<div class="btn-group">';

                if (auth()->user()->can('reviews.view')) {
                    $buttons .= '<a href="' . $viewUrl . '" class="btn btn-sm btn-info">
                        <i class="fas fa-eye"></i>
                    </a>';
                }

                if (auth()->user()->can('reviews.delete')) {
                    $buttons .= '
                        <form action="' . $deleteUrl . '" method="POST" style="display:inline">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button class="btn btn-sm btn-danger"
                                onclick="return confirm(\'Delete this review?\')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>';
                }

                $buttons .= '</div>';

                return $buttons;
            })

            ->rawColumns(['status', 'actions'])

            ->setRowId('id');
    }

    /**
     * Get query source.
     */
    public function query(Review $model)
    {
        return $model->newQuery()->select('reviews.*')
            ->with('student:id,name');
    }

    /**
     * Optional HTML builder.
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('reviews-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1, 'desc')
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
                'title'      => '#',
                'orderable'  => false,
                'searchable' => false,
                'className'  => 'text-center',
            ],
            [
                'data'  => 'student',
                'name'  => 'student.name',
                'title' => 'Student',
            ],
            [
                'data'  => 'description',
                'name'  => 'description',
                'title' => 'Review',
            ],
            [
                'data'  => 'status',
                'title' => 'Status',
                'orderable'  => false,
                'searchable' => false,
                'className'  => 'text-center',
            ],
            [
                'data'  => 'published_at',
                'title' => 'Published At',
                'className' => 'text-center',
            ],
            [
                'data'  => 'created_at',
                'title' => 'Created At',
                'className' => 'text-center',
            ],
            [
                'data'       => 'actions',
                'title'      => 'Actions',
                'orderable'  => false,
                'searchable' => false,
                'className'  => 'text-center',
            ],
        ];
    }

    /**
     * Export filename.
     */
    protected function filename(): string
    {
        return 'Reviews_' . date('YmdHis');
    }
}
