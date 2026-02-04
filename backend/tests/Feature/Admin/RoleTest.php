<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RoleTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        // permissions
        Permission::create(['name' => 'roles.view']);
        Permission::create(['name' => 'roles.create']);
        Permission::create(['name' => 'roles.edit']);
        Permission::create(['name' => 'roles.delete']);

        // admin user
        $this->admin = User::factory()->create();
        $this->admin->givePermissionTo([
            'roles.view',
            'roles.create',
            'roles.edit',
            'roles.delete',
        ]);
    }

    public function test_admin_can_view_roles(): void
    {
        $this->actingAs($this->admin);
        $this->get(route('admin.roles.index'))
            ->assertStatus(200);
    }

    public function test_admin_can_open_create_role_page()
    {
        $response = $this
            ->actingAs($this->admin)
            ->get(route('admin.roles.create'));

        $response->assertStatus(200);
    }

    public function test_admin_can_create_role(): void
    {
        $permission = Permission::create(['name' => 'users.view']);
        $response = $this
        ->actingAs($this->admin)
        ->post(route('admin.roles.store'),[
            'name' => 'Editor',
            'permissions' => [$permission->id]
        ]);

        $response->assertRedirect(route('admin.roles.index'));

        $this->assertDatabaseHas('roles', [
            'name' => 'Editor'
        ]);
    }

    public function test_admin_can_edit_role()
    {
        $role = Role::create(['name'=>'Manager']);
        $response = $this
        ->actingAs($this->admin)
        ->get(route('admin.roles.edit', $role));

        $response->assertStatus(200);
    }

    public function test_admin_can_update_role()
    {
        $role = Role::create(['name'=>'Manager']);
        $permission = Permission::create(['name' => 'users.view']);
        $response = $this
        ->actingAs($this->admin)
        ->put(route('admin.roles.update', $role),[
            'name' => 'Manager',
            'permissions' => [$permission->id]
        ]);

        $response->assertRedirect(route('admin.roles.index'));

        $this->assertDatabaseHas('roles', [
            'name' => 'Manager'
        ]);
    }

    public function test_admin_can_delete_role()
    {
        $role = Role::create(['name'=>'Temp Role']);
        $response = $this
        ->actingAs($this->admin)
        ->delete(route('admin.roles.destroy', $role));

        $response->assertRedirect(route('admin.roles.index'));

        $this->assertDatabaseMissing('roles', [
            'id' => $role->id,
        ]);
    }

    public function test_user_without_permission_cannot_access_roles()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $this->get(route('admin.roles.index'))
            ->assertStatus(403);
    }
}
