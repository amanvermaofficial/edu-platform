<?php

namespace App\Repositories\Admin;

use App\Models\User;
use Exception;

class UserRepository
{
    public function create(array $data)
    {
        return User::create($data);
    }

    public function update(User $user, array $data)
    {
        $user->update($data);
        return $user;
    }

    public function delete(User $user)
    {
        return $user->delete();
    }

    public function updatePassword(User $user, string $password)
    {
        return $user->update([
            'password' => $password,
        ]);
    }
}
