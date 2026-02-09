<?php

namespace Tests\Feature\Api\V1;

use App\Models\Course;
use App\Models\Student;
use App\Models\Trade;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StudentTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_can_get_profile()
    {
        $student = Student::factory()->create();

        $token = $student->createToken('test-token')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson('/api/v1/student/profile');


        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'id',
                    'name',
                    'email'
                ]
            ]);
    }

    public function test_guest_cannot_get_profile()
    {
        $response = $this->getJson('/api/v1/student/profile');

        $response->assertStatus(401);
    }


    public function test_student_can_update_profile_with_picture()
    {
        Storage::fake('public');

        $student = Student::factory()->create();
        $course = Course::factory()->create();
        $trade = Trade::factory()->create();

        $token = $student->createToken('test')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson('/api/v1/student/update-profile', [
                'name' => 'With Image',
                'email' => 'image@test.com',
                'phone' => '9999999999',
                'state' => 'UP',
                'gender' => 'male',
                'course_id' => $course->id,
                'trade_id' => $trade->id,
                'profile_picture' => UploadedFile::fake()->image('avatar.jpg'),
            ]);

        $response->assertStatus(200);

        $student->refresh();

        Storage::disk('public')->assertExists($student->profile_picture);
    }
}
