<?php

namespace Tests\Feature\Admin;

use App\Models\Trade;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class TradeTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        // Permissions
        Permission::create(['name' => 'trades.view']);
        Permission::create(['name' => 'trades.create']);
        Permission::create(['name' => 'trades.edit']);
        Permission::create(['name' => 'trades.delete']);

        // Admin user
        $this->admin = User::factory()->create();
        $this->admin->givePermissionTo([
            'trades.view',
            'trades.create',
            'trades.edit',
            'trades.delete',
        ]);
    }

    public function test_admin_can_view_trades()
    {
        $this->actingAs($this->admin);
        $response = $this->get(route('admin.trades.index'));
        $response->assertStatus(200);
    }

    public function test_admin_can_open_create_trade_page()
    {
        $this->actingAs($this->admin);
        $response = $this->get(route('admin.trades.create'));
        $response->assertStatus(200);
    }

    public function test_admin_can_create_trade()
    {
        $this->actingAs($this->admin);
        $response = $this->post(route('admin.trades.store'), [
            'name' => 'Trade 1',
            'description' => 'Description 1',
            'is_active' => true
        ]);
        $response->assertRedirect(route('admin.trades.index'));
        $this->assertDatabaseHas('trades', [
            'name' => 'Trade 1',
        ]);
    }

    public function test_admin_can_open_edit_trade_page()
    {
        $trade = Trade::factory()->create();
        $this->actingAs($this->admin);
        $response = $this->get(route('admin.trades.edit', $trade));
        $response->assertStatus(200);
    }

    public function test_admin_can_update_trade()
    {
        $trade = Trade::factory()->create([
            'name' => 'Old Trade',
        ]);
        $this->actingAs($this->admin);
        $response = $this->put(route('admin.trades.update', $trade), [
            'name' => 'New Trade',
            'description' => 'Updated description',
            'is_active' => false
        ]);
        $response->assertRedirect(route('admin.trades.index'));
        $this->assertDatabaseHas('trades', [
            'name' => $trade->id,
            'name' => 'New Trade',
        ]);
    }

    public function test_admin_can_delete_trade()
    {
        $trade = Trade::factory()->create();
        $this->actingAs($this->admin);
        $response = $this->delete(route('admin.trades.destroy', $trade));
        $response->assertRedirect(route('admin.trades.index'));
        $this->assertDatabaseMissing('trades', [
            'id' => $trade->id,
        ]);
    }

    public function test_user_without_permission_cannot_access_trades()
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get(route('admin.trades.index'));

        $response->assertStatus(403);
    }
}
