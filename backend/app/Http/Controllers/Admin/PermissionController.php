<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\PermissionDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PermissionRequest;
use App\Services\Admin\PermissionService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function __construct(PermissionService $service)
    {
        $this->middleware('permission:view.permissions')->only('index');
        $this->middleware('permission:create.permissions')->only(['create', 'store']);
        $this->middleware('permission:update.permissions')->only(['edit', 'update']);
        $this->middleware('permission:delete.permissions')->only('destroy');

        $this->service = $service;
    }

    public function index(PermissionDataTable $dataTable)
    {
         return $dataTable->render('admin.permissions.index');
    }

    public function create()
    {
        return view('admin.permissions.create');
    }

    public function store(PermissionRequest $request)
    {
        $this->service->create($request->validated());

        return redirect()->route('admin.permissions.index')->with('success', 'Permission Created!');
    }

    public function edit(Permission $permission)
    {
        return view('admin.permissions.edit', compact('permission'));
    }

    public function update(PermissionRequest $request, Permission $permission)
    {

        $this->service->update($permission, $request->validated());

        return redirect()->route('admin.permissions.index')->with('success', 'Permission Updated!');
    }

    public function destroy(Permission $permission)
    {
        $this->service->delete($permission);
        return redirect()->route('admin.permissions.index')->with('success', 'Permission Deleted!');
    }
}
