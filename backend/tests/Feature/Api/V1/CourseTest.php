<?php

namespace Tests\Feature\Api\V1;

use App\Models\Course;
use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CourseTest extends TestCase
{
    use RefreshDatabase;

     public function test_authenticated_student_can_get_courses()
    {
        Course::factory()->count(3)->create();

        $student = Student::factory()->create();
        $token = $student->createToken('test-token')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->getJson('/api/v1/courses');

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'success',
                    'message',
                    'data'=>[
                        'courses'=>[
                            '*'=>[
                                'id',
                                'name',
                                'description'
                            ]
                        ]
                    ]
                ]);
    }
}
