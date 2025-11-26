<?php

namespace App\Repositories\Admin;

use Spatie\Permission\Models\Permission;

class PermissionRepository
{
    public function getAll(){
        return Permission::orderBy('name')->get();
    }

    public function find($id)
    {
        return Permission::findOrFail($id);
    }

    public function create(array $data){
        return Permission::create($data);
    }

    public function update(Permission $permission,array $data){
        return tap($permission)->update($data);
    }

    public function delete(Permission $permission)
    {
        return $permission->delete();
    }
}