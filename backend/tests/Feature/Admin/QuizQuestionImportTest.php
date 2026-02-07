<?php

namespace Tests\Feature\Admin;

use App\Models\Quiz;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;

class QuizQuestionImportTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        Permission::create(['name' => 'quiz-questions.import']);
        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo('quiz-questions.import');

        $this->admin = User::factory()->create();
        $this->admin->assignRole($role);

        $this->actingAs($this->admin);
    }


    public function test_quiz_questions_can_be_imported()
    {
        Excel::fake();

        $quiz = Quiz::factory()->create();

        $file = UploadedFile::fake()->create(
            'questions.xlsx',
            100,
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        );

        $response = $this->post(route('admin.quiz.questions.import.store'), [
            'quiz_id' => $quiz->id,
            'file' => $file,
        ]);

        $response->assertSessionHas('success');

        Excel::assertImported('questions.xlsx');
    }


    public function test_quiz_questions_import_requires_quiz_and_file()
    {
        $response = $this->post(route('admin.quiz.questions.import.store'), []);

        $response->assertSessionHasErrors(['quiz_id', 'file']);
    }


    public function test_user_without_permission_cannot_import_questions()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $quiz = Quiz::factory()->create();

        $file = UploadedFile::fake()->create('questions.xlsx');

        $response = $this->post(route('admin.quiz.questions.import.store'), [
            'quiz_id' => $quiz->id,
            'file' => $file,
        ]);

        $response->assertForbidden();
    }
}
