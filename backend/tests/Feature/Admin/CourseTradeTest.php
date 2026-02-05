<?php

namespace Tests\Feature\Admin;

use App\Models\Course;
use App\Models\Trade;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class CourseTradeTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        Permission::create(['name' => 'courses.map-trades']);

        $this->admin = User::factory()->create();
        $this->admin->givePermissionTo('courses.map-trades');
    }

    public function test_admin_can_view_course_trade_mapping_page()
    {
        $course = Course::factory()->create();

        $response = $this
            ->actingAs($this->admin)
            ->get(route('admin.courses.map-trades', $course));

        $response->assertStatus(200);
        $response->assertViewIs('admin.course_trade.index');
        $response->assertViewHas('course');
        $response->assertViewHas('trades');
        $response->assertViewHas('mappedTrades');
    }

    public function test_admin_can_map_trades_to_courses()
    {
        $course = Course::factory()->create();
        $trade = Trade::factory()->count(3)->create();

        $tradeIds = $trade->pluck('id')->toArray();

        $response = $this
            ->actingAs($this->admin)
            ->post(route('admin.courses.map-trades', $course), [
                'trade_ids' => $tradeIds,
            ]);

        $response->assertRedirect(route('admin.courses.index'));

        foreach ($tradeIds as $tradeId) {
            $this->assertDatabaseHas('course_trade', [
                'course_id' => $course->id,
                'trade_id' => $tradeId,
            ]);
        }
    }

    public function test_admin_can_unmap_trades_from_courses()
    {
        $course = Course::factory()->create();
        $trade = Trade::factory()->count(2)->create();

        $course->trades()->sync($trade->pluck('id')->toArray());

        $response = $this
            ->actingAs($this->admin)
            ->post(
                route('admin.courses.map-trades.update', $course),
                ['trade_ids' => []]
            );

        $response->assertRedirect(route('admin.courses.index'));
        $this->assertDatabaseMissing('course_trade', [
            'course_id' => $course->id,
        ]);
    }

    public function user_without_permission_cannot_access_mapping()
    {
        $user = User::factory()->create();
        $course = Course::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get(route('admin.courses.map-trades', $course));

        $response->assertStatus(403);
    }
}
