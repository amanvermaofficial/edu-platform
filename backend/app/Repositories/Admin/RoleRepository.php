<?php

namespace App\Repositories\Admin;

use Exception;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class RoleRepository
{
    public function getAll()
    {
        return Role::with('permissions')->orderBy('name')->get();
    }

    public function createRole(string $name)
    {
        return Role::create(['name' => $name]);
    }

    public function updateRole(Role $role, string $name)
    {
        return $role->update(['name' => $name]);
    }

    public function syncPermissions(Role $role, array $permissionIds)
    {
        return $role->permissions()->sync($permissionIds);
    }

    public function delete(Role $role)
    {
        return $role->delete();
    }

    public function detachPermissions(Role $role)
    {
        return $role->syncPermissions([]);
    }

    public function countAssignedUsers(Role $role)
    {
        return $role->users()->count();
    }
}
