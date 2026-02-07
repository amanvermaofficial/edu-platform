<?php

namespace Tests\Feature\Admin;

use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class QuizAttemptTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        Permission::create(['name' => 'quiz-attempts.view']);
        Permission::create(['name' => 'quiz-attempts.show']);

        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo([
            'quiz-attempts.view',
            'quiz-attempts.show',
        ]);

        $this->admin = User::factory()->create();
        $this->admin->assignRole($role);

        $this->actingAs($this->admin);
    }

    public function test_admin_can_view_quiz_attempts_index()
    {
        $response = $this->get(route('admin.quiz-attempts.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.quiz_attempts.index');
    }

    public function test_admin_can_view_single_quiz_attempt()
    {
        $quiz = Quiz::factory()->create();

        $attempt = QuizAttempt::factory()->create([
            'quiz_id' => $quiz->id,
        ]);

        $response = $this->get(
            route('admin.quiz-attempts.show', $attempt)
        );

        $response->assertStatus(200);
        $response->assertViewIs('admin.quiz_attempts.show');
        $response->assertViewHas(['attempt', 'answers']);
    }

    public function test_user_without_permission_cannot_view_attempts()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('admin.quiz-attempts.index'));

        $response->assertForbidden();
    }
}
