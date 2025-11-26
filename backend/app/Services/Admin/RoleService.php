<?php

namespace App\Services\Admin;

use App\Repositories\Admin\RoleRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

/**
 * Class RoleService.
 */
class RoleService
{
    protected $repo;

    public function __construct(RoleRepository $repo)
    {
        $this->repo = $repo;
    }

    public function list()
    {
        return $this->repo->getAll();
    }

    /**
     * Create a new role
     */
    public function create(array $data)
    {
        DB::beginTransaction();
        try {
            $role = $this->repo->createRole($data['name']);
            if (isset($data['permissions']) && is_array($data['permissions'])) {
                $this->repo->syncPermissions($role, $data['permissions']);
            }
            DB::commit();
            return $role;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Role create error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Update existing role
     */
    public function update(Role $role, array $data)
    {
        DB::beginTransaction();
        try {
            $this->repo->updateRole($role, $data['name']);
            if (isset($data['permissions']) && is_array($data['permissions'])) {
                $this->repo->syncPermissions($role, $data['permissions']);
            } else {
                $this->repo->syncPermissions($role, []);
            }
            DB::commit();
            return $role;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Role update error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Delete role
     */
    public function delete(Role $role)
    {
        try {
            if ($this->repo->countAssignedUsers($role) > 0) {
                throw new Exception('Cannot delete role. It is assigned to users.');
            }
            $this->repo->detachPermissions($role);
            $this->repo->delete($role);
            return true;
        } catch (Exception $e) {
            Log::error('Role delete error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Get all permissions for dropdown/checkboxes
     */
    public function getAllPermissions()
    {
        return Permission::orderBy('name')->get();
    }
}
