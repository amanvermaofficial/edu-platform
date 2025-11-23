<?php

namespace App\Services\Admin;

use App\Repositories\Admin\PermissionRepository;
use Spatie\Permission\Models\Permission;

/**
 * Class PermissionService.
 */
class PermissionService
{
    protected $repo;

    public function __construct(PermissionRepository $repo)
    {
        $this->repo = $repo;
    }

    public function list()
    {
        return $this->repo->getAll();
    }

    public function create($data)
    {
        return $this->repo->create($data);
    }

    public function update(Permission $permission, $data)
    {
        return $this->repo->update($permission, $data);
    }

    public function delete(Permission $permission)
    {
        return $this->repo->delete($permission);
    }
}
