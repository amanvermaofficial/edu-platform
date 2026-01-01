<?php

namespace App\DataTables;

use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class PermissionDataTable extends DataTable
{
    public function dataTable($query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('actions', function ($row) {
                $editUrl = route('admin.permissions.edit', $row->id);
                $deleteUrl = route('admin.permissions.destroy', $row->id);

                $buttons = '<div class="btn-group">';

                if (auth()->user()->can('permissions.edit')) {
                    $buttons .= '<a href="' . $editUrl . '" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>';
                }

                if (auth()->user()->can('permissions.delete')) {
                    $buttons .= '<form action="' . $deleteUrl . '" method="POST" style="display:inline">' . csrf_field() . method_field('DELETE') . '<button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button></form>';
                }

                $buttons .= '</div>';

                return $buttons;
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at ? $row->created_at->format('d M Y, h:i A') : '-';
            })
            ->rawColumns(['actions'])
            ->setRowId('id');
    }

    public function query(Permission $model)
    {
        return $model->newQuery();
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('permissions-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1, 'asc')  // Name se sort karo
            ->parameters([
                'responsive' => true,
                'autoWidth' => false,
                'lengthMenu' => [[10, 25, 50, -1], [10, 25, 50, 'All']],
                'pageLength' => 10,
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
                'width' => '5%',
                'className' => 'text-center'
            ],
            [
                'data' => 'name',
                'name' => 'name',
                'title' => 'Permission Name',
                'width' => '50%'
            ],
            [
                'data' => 'created_at',
                'name' => 'created_at',
                'title' => 'Created At',
                'width' => '25%',
                'className' => 'text-center'
            ],
            [
                'data' => 'actions',
                'name' => 'actions',
                'title' => 'Actions',
                'orderable' => false,
                'searchable' => false,
                'width' => '20%',
                'className' => 'text-center'
            ],
        ];
    }

    protected function filename(): string
    {
        return 'Permissions_' . date('YmdHis');
    }
}
