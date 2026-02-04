<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class PermissionTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        // Required permissions for permission module
        Permission::create(['name' => 'permissions.view']);
        Permission::create(['name' => 'permissions.create']);
        Permission::create(['name' => 'permissions.update']);
        Permission::create(['name' => 'permissions.delete']);

        // Admin user
        $this->admin = User::factory()->create();
        $this->admin->givePermissionTo([
            'permissions.view',
            'permissions.create',
            'permissions.update',
            'permissions.delete',
        ]);
    }

    public function test_admin_can_view_permission_list()
    {
        $this->actingAs($this->admin);
        $this->get(route('admin.permissions.index'))
            ->assertStatus(200);
    }

    public function test_admin_can_open_create_permission_page()
    {
        $response = $this
            ->actingAs($this->admin)
            ->get(route('admin.permissions.create'));

        $response->assertStatus(200);
    }

    public function test_admin_can_create_permission(): void
    {
        $response = $this
            ->actingAs($this->admin)
            ->post(route('admin.permissions.store'),[
                'name' => 'users.view'
            ]);

        $response->assertRedirect(route('admin.permissions.index'));

        $this->assertDatabaseHas('permissions', [
            'name' => 'users.view'
        ]);
    }

     public function admin_can_open_edit_permission_page()
    {
        $permission = Permission::create(['name' => 'users.view']);
        $response = $this
            ->actingAs($this->admin)
            ->get(route('admin.permissions.edit', $permission));

        $response->assertStatus(200);
    }

    public function test_admin_can_update_permission()
    {
        $permission = Permission::create(['name' => 'old.permission']);
        $response = $this
            ->actingAs($this->admin)
            ->put(route('admin.permissions.update', $permission),[
                'name' => 'new.permission'
            ]);

        $response->assertRedirect(route('admin.permissions.index'));

        $this->assertDatabaseHas('permissions', [
            'name' => 'new.permission'
        ]);
    }
    
    public function test_admin_can_delete_permission()
    {
        $permission = Permission::create(['name' => 'users.view']);
        $response = $this
            ->actingAs($this->admin)
            ->delete(route('admin.permissions.destroy', $permission));

        $response->assertRedirect(route('admin.permissions.index'));

        $this->assertDatabaseMissing('permissions', [
            'id' => $permission->id,
        ]);
    }

    public function user_without_permission_cannot_access_permission_module()
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get(route('admin.permissions.index'));

        $response->assertStatus(403);
    }
    
}
