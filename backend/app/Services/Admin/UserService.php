<?php

namespace App\Services\Admin;

use App\Models\User;
use App\Repositories\Admin\RoleRepository;
use App\Repositories\Admin\UserRepository;
use Exception;
use Illuminate\Support\Facades\DB;

/**
 * Class UserService.
 */
class UserService
{

    public function __construct(UserRepository $repo, RoleRepository $roleRepo)
    {
        $this->repo = $repo;
        $this->roleRepo = $roleRepo;
    }

    public function getAllRoles()
    {
        return $this->roleRepo->getAll();
    }

    public function create(array $data)
    {
        DB::beginTransaction();
        try {
            $user = $this->repo->create($data);
            if (isset($data['role'])) {
                $user->assignRole($data['role']);
            }
            DB::commit();

            return $user;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update($user, array $data)
    {
        DB::beginTransaction();
        try {
            $user = $this->repo->update($user, $data);
            if (isset($data['role'])) {
                $user->syncRoles([$data['role']]);
            }
            DB::commit();

            return $user;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function delete($user)
    {
        return $this->repo->delete($user);
    }

    public function resetPassword(User $user, array $data)
    {
        try {
            return $this->repo->updatePassword($user, $data['password']);
        } catch (Exception $e) {
            throw $e;
        }
    }
}
