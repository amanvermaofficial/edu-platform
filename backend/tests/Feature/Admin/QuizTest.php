<?php

namespace Tests\Feature\Admin;

use App\Models\CourseTrade;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class QuizTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    public function setUp(): void
    {
        parent::setUp();
        $permissions = [
            'quizzes.view',
            'quizzes.create',
            'quizzes.update',
            'quizzes.delete',
        ];
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo($permissions);
        $this->admin = User::factory()->create();
        $this->admin->assignRole($role);
        $this->actingAs($this->admin);
    }
    public function test_quiz_index_page_loads()
    {
        $response = $this->get(route('admin.quizzes.index'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.quizzes.index');
    }

    public function test_quiz_can_be_created()
    {
        $courseTrade = CourseTrade::factory()->create();
        $response = $this->post(route('admin.quizzes.store'), [
            'title' => 'Test Quiz',
            'description' => 'Test Description',
            'course_trade_ids' => [$courseTrade->id]
        ]);

        $response->assertRedirect(route('admin.quizzes.index'));

        $this->assertDatabaseHas('quizzes', [
            'title' => 'Test Quiz',
        ]);
    }

    public function test_quiz_can_be_updated()
    {
        $quiz = Quiz::factory()->create();
        $courseTrade = CourseTrade::factory()->create();
        $response = $this->put(route('admin.quizzes.update', $quiz->id), [
            'title' => 'Updated Title',
            'description' => 'Updated Description',
            'course_trade_ids' => [$courseTrade->id],
        ]);

        $response->assertRedirect(route('admin.quizzes.index'));
        $this->assertDatabaseHas('quizzes', [
            'title' => 'Updated Title',
        ]);
    }

    public function test_quiz_can_be_deleted()
    {
        $quiz = Quiz::factory()->create();

        $response = $this->delete(route('admin.quizzes.destroy', $quiz));

        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('quizzes', [
            'id' => $quiz->id,
        ]);
    }

    public function test_quiz_cannot_be_activated_without_questions()
    {
        $quiz = Quiz::factory()->create([
            'is_active' => false,
        ]);

        $response = $this->post(route('admin.quizzes.toggle-status', $quiz));

        $response->assertSessionHas('error');

        $this->assertFalse($quiz->fresh()->is_active);
    }
}
