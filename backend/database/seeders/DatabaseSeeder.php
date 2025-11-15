<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $permissionedUser = User::factory()->create([
            'name' => 'Permissioned User',
            'email' => 'staff@example.com',
            'password' => 'password'
        ]);

        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => 'password'
        ]);

        $admin_role = Role::create(['name' => 'admin']);
        $staff_role = Role::create(['name' => 'staff_manager']);

        $permissions = [
            'view roles',
            'create roles',
            'update roles',
            'delete roles',
            'view staff',
            'create staff',
            'update staff',
            'delete staff',
            'reset staff password',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $admin_role->givePermissionTo($permissions);
        $staff_role->givePermissionTo([
            'view roles',
            'view staff',
            'create staff',
            'update staff',
            'reset staff password'
        ]);
        $admin->assignRole('admin');
        $permissionedUser->assignRole('staff_manager');
    }
}
