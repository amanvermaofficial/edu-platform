<?php

namespace Tests\Feature\Admin;

use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class StudentTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $permissions = [
            'students.view',
            'students.delete',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission, 'guard_name' => 'web']
            );
        }


        $this->admin = User::factory()->create();
        $this->admin->givePermissionTo(['students.view', 'students.delete']);
    }

    public function test_admin_can_view_students_list()
    {
        Student::factory()->count(3)->create();

        $response = $this
            ->actingAs($this->admin)
            ->get(route('admin.students.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.students.index');
    }

    public function test_admin_can_view_student_details()
    {
        $student = Student::factory()->create();

        $response = $this
            ->actingAs($this->admin)
            ->get(route('admin.students.show', $student));

        $response->assertStatus(200);
        $response->assertViewIs('admin.students.show');
        $response->assertViewHas('student');
    }

    public function test_admin_can_delete_student()
    {
        $student = Student::factory()->create();

        $response = $this
            ->actingAs($this->admin)
            ->delete(route('admin.students.destroy', $student));

        $response->assertRedirect(route('admin.students.index'));

        $this->assertDatabaseMissing('students', [
            'id' => $student->id,
        ]);
    }

    public function test_user_without_permission_cannot_view_students()
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get(route('admin.students.index'));

        $response->assertStatus(403);
    }

    public function test_user_without_permission_cannot_delete_student()
    {
        $user = User::factory()->create();
        $student = Student::factory()->create();

        $response = $this
            ->actingAs($user)
            ->delete(route('admin.students.destroy', $student));

        $response->assertStatus(403);
    }
}
