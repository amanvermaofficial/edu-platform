<?php

namespace App\DataTables;

use App\Models\Course;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class CourseDataTable extends DataTable
{
    public function dataTable($query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()

            ->editColumn('name', function ($row) {
                return ucfirst($row->name);
            })

              ->addColumn('actions', function ($row) {
                $editUrl = route('admin.courses.edit', $row->id);
                $deleteUrl = route('admin.courses.destroy', $row->id);
                
                return '
                    <div class="btn-group" role="group">
                        <a href="' . $editUrl . '" class="btn btn-sm btn-info" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="' . $deleteUrl . '" method="POST" onsubmit="return confirm(\'Are you sure you want to delete this permission?\')" style="display:inline-block; margin-left: 5px;">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                ';
            })


            

            ->rawColumns(['courses', 'actions'])
            ->setRowId('id');
    }


    public function query(Course $model)
    {
        return $model->newQuery();
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('courses-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1, 'asc')
            ->parameters([
                'responsive' => true,
                'autoWidth' => false,
                'lengthMenu' => [[10, 25, 50, -1], [10, 25, 50, 'All']],
                'pageLength'   => 10,
            ]);
    }

    protected function getColumns()
    {
        return [
            [
                'data' => 'DT_RowIndex',
                'name' => 'DT_RowIndex',
                'title' => '#',
                'orderable' => false,
                'searchable' => false,
                'className' => 'text-center',
                'width' => '5%',
            ],
            [
                'data' => 'name',
                'name' => 'name',
                'title' => 'Name',
            ],
            [
                'data' => 'description',
                'name' => 'description',
                'title' => 'Description',
            ],
            [
                'data' => 'actions',
                'name' => 'actions',
                'title' => 'Actions',
                'orderable' => false,
                'searchable' => false,
                'className' => 'text-center',
                'width' => '15%',
            ],
        ];
    }

    protected function filename(): string
    {
        return 'Courses_' . date('YmdHis');
    }
}
