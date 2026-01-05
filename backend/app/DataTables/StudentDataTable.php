<?php

namespace App\DataTables;

use App\Models\Student;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class StudentDataTable extends DataTable
{
    /**
     * Build DataTable class.
     */
    public function dataTable($query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()

            ->editColumn('name', function ($row) {
                return $row->name ?? '-';
            })

            ->editColumn('phone', function ($row) {
                return $row->phone;
            })

            ->editColumn('email', function ($row) {
                return $row->email ?? '-';
            })

            ->editColumn('course', function ($row) {
                return $row->course?->name ?? '-';
            })

            ->editColumn('trade', function ($row) {
                return $row->trade?->name ?? '-';
            })

            ->editColumn('gender', function ($row) {
                return ucfirst($row->gender) ?? '-';
            })

            ->editColumn('created_at', function ($row) {
                return $row->created_at
                    ? $row->created_at->format('d M Y')
                    : '-';
            })

            ->addColumn('actions', function ($row) {
                $viewUrl   = route('admin.students.show', $row->id);
                $deleteUrl = route('admin.students.destroy', $row->id);

                $buttons = '<div class="btn-group">';

                if (auth()->user()->can('students.view')) {
                    $buttons .= '<a href="'.$viewUrl.'" class="btn btn-sm btn-secondary">
                        <i class="fas fa-eye"></i>
                    </a>';
                }

                if (auth()->user()->can('students.delete')) {
                    $buttons .= '
                    <form action="'.$deleteUrl.'" method="POST" style="display:inline">
                        '.csrf_field().method_field('DELETE').'
                        <button class="btn btn-sm btn-danger">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>';
                }

                $buttons .= '</div>';

                return $buttons;
            })

            ->rawColumns(['actions'])
            ->setRowId('id');
    }

    /**
     * Get query source.
     */
    public function query(Student $model)
    {
        return $model->newQuery()->with(['course', 'trade']);
    }

    /**
     * Optional HTML builder.
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('students-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->parameters([
                'responsive' => true,
                'autoWidth'  => false,
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
                'data'  => 'name',
                'title' => 'Name',
            ],
            [
                'data'  => 'phone',
                'title' => 'Phone',
            ],
            [
                'data'  => 'email',
                'title' => 'Email',
            ],
            [
                'data'  => 'course',
                'name'  => 'course.name',
                'title' => 'Course',
            ],
            [
                'data'  => 'trade',
                'name'  => 'trade.name',
                'title' => 'Trade',
            ],
            [
                'data'  => 'gender',
                'title' => 'Gender',
                'className' => 'text-center',
            ],
            [
                'data'  => 'created_at',
                'title' => 'Joined At',
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

    protected function filename(): string
    {
        return 'Students_' . date('YmdHis');
    }
}
