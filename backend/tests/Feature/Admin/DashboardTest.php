<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DashboardTest extends TestCase
{
     use RefreshDatabase;

    public function test_admin_can_access_dashboard()
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)
            ->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.dashboard.index');
    }

    public function test_dashboard_receives_required_counts()
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)
            ->get(route('admin.dashboard'));

        $response->assertViewHasAll([
            'studentsCount',
            'quizzesCount',
            'attemptsCount',
            'pendingReviews',
            'publishedReviews',
            'coursesCount',
            'tradesCount',
        ]);
    }
}
