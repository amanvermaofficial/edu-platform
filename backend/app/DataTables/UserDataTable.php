<?php

namespace App\DataTables;

use App\Models\User;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class UserDataTable extends DataTable
{
    public function dataTable($query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()

            // USER NAME
            ->editColumn('name', function ($row) {
                return ucfirst($row->name);
            })

            // ROLES WITH MULTIPLE BADGE COLORS
            ->addColumn('roles', function ($row) {

                if ($row->roles->isEmpty()) {
                    return '<span class="badge badge-secondary">No Role</span>';
                }

                return $row->roles->map(function ($role, $index) {
                    return match ($index) {
                        0 => '<span class="badge badge-primary">' . $role->name . '</span>', // First role
                        1 => '<span class="badge badge-success">' . $role->name . '</span>', // Second role
                        default => '<span class="badge badge-warning">' . $role->name . '</span>', // Others
                    };
                })->implode(' ');
            })

            // ACTION BUTTONS
            ->addColumn('actions', function ($row) {

                $editUrl   = route('admin.users.edit', $row->id);
                $deleteUrl = route('admin.users.destroy', $row->id);
                $resetUrl  = route('admin.users.reset-password', $row->id);  // NEW RESET PASSWORD ROUTE

                $buttons = '<div class="btn-group">';

                if (auth()->user()->can('users.edit')) {
                    $buttons .= '
        <a href="' . $editUrl . '" class="btn btn-sm btn-info ms-1">
            <i class="fas fa-edit"></i>
        </a>
    ';
                }

                if (auth()->user()->can('user.reset-password')) {
                    $buttons .= '
        <a href="' . $resetUrl . '" class="btn btn-sm btn-warning mx-1">
            <i class="fas fa-key"></i>
        </a>
    ';
                }

                if (auth()->user()->can('users.delete')) {
                    $buttons .= '
        <form action="' . $deleteUrl . '" method="POST" style="display:inline">
            ' . csrf_field() . method_field('DELETE') . '
            <button class="btn btn-sm btn-danger">
                <i class="fas fa-trash"></i>
            </button>
        </form>
    ';
                }

                $buttons .= '</div>';

                return $buttons;
            })

            ->editColumn(
                'created_at',
                fn($row) =>
                $row->created_at ? $row->created_at->format('d M Y, h:i A') : '-'
            )

            ->rawColumns(['roles', 'actions'])
            ->setRowId('id');
    }


    public function query(User $model)
    {
        return $model->with('roles')->newQuery();
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('users-table')
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
                'data' => 'email',
                'name' => 'email',
                'title' => 'Email',
            ],
            [
                'data' => 'roles',
                'name' => 'roles.name',
                'title' => 'Role(s)',
                'orderable' => false,
                'searchable' => false,
            ],
            [
                'data' => 'created_at',
                'name' => 'created_at',
                'title' => 'Created At',
                'className' => 'text-center',
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
        return 'Users_' . date('YmdHis');
    }
}
