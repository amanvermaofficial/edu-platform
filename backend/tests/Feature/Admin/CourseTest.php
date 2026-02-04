<?php

namespace Tests\Feature\Admin;

use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class CourseTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        Permission::create(['name' => 'courses.view']);
        Permission::create(['name' => 'courses.create']);
        Permission::create(['name' => 'courses.edit']);
        Permission::create(['name' => 'courses.delete']);

        // Admin user
        $this->admin = User::factory()->create();
        $this->admin->givePermissionTo([
            'courses.view',
            'courses.create',
            'courses.edit',
            'courses.delete',
        ]);
    }

    public function test_admin_can_view_courses_list()
    {
        $response = $this
            ->actingAs($this->admin)
            ->get(route('admin.courses.index'));

        $response->assertStatus(200);
    }


    public function test_admin_can_open_create_course_page()
    {
        $response = $this
            ->actingAs($this->admin)
            ->get(route('admin.courses.create'));

        $response->assertStatus(200);
    }

    public function test_admin_can_create_course()
    {
        $response = $this
            ->actingAs($this->admin)
            ->post(route('admin.courses.store'), [
                'name' => 'Electrician',
                'description' => 'Electrician description',
            ]);

        $response->assertRedirect(route('admin.courses.index'));

        $this->assertDatabaseHas('courses', [
            'name' => 'Electrician',
        ]);
    }

    public function test_admin_can_open_edit_course_page()
    {
        $course = Course::factory()->create();

        $response = $this
            ->actingAs($this->admin)
            ->get(route('admin.courses.edit', $course));

        $response->assertStatus(200);
    }

    public function test_admin_can_update_course()
    {
        $course = Course::factory()->create([
            'name' => 'Old Course',
            'description' => 'Old Course description',
        ]);

        $response = $this
            ->actingAs($this->admin)
            ->put(route('admin.courses.update', $course), [
                'name' => 'New Course',
                'description' => 'New Course description',
            ]);

        $response->assertRedirect(route('admin.courses.index'));

        $this->assertDatabaseHas('courses', [
            'name' => 'New Course',
            'description' => 'New Course description',
        ]);
    }

    public function test_admin_can_delete_course()
    {
        $course = Course::factory()->create();

        $response = $this
            ->actingAs($this->admin)
            ->delete(route('admin.courses.destroy', $course));

        $response->assertRedirect(route('admin.courses.index'));

        $this->assertDatabaseMissing('courses', [
            'id' => $course->id,
        ]);
    }

    public function test_user_without_permission_cannot_access_course_module()
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get(route('admin.courses.index'));

        $response->assertStatus(403);
    }
}
