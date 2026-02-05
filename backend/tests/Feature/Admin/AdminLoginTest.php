<?php

namespace Tests\Feature\Admin\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminLoginTest extends TestCase
{
    use RefreshDatabase;
    public function test_login_page_can_be_opened()
    {
        $response = $this->get(route('admin.login'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.auth.login');
    }

    public function test_admin_can_login_with_valid_credentials()
    {
        $admin = User::factory()->create([
            'email' => 'xy@example.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this->post(route('admin.login'), [
            'email' => 'xy@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticatedAs($admin);
    }

    public function test_admin_cannot_login_with_invalid_credentials()
    {
        User::factory()->create([
            'email' => 'admin@test.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this->post(route('admin.login'), [
            'email' => 'xy@example.com',
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors();

        $this->assertGuest();
    }

    public function test_admin_can_logout()
    {
        $admin = User::factory()->create();

        $response = $this
            ->actingAs($admin)
            ->post(route('admin.logout'));

        $response->assertRedirect(route('admin.login'));
        $this->assertGuest();
    }
}

