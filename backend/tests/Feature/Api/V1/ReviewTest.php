<?php

namespace Tests\Feature\Api\V1;

use App\Models\Review;
use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ReviewTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_fetch_all_testimonials()
    {
        Review::factory()->count(3)->create([
            'is_published' => true
        ]);

        $response = $this->getJson('/api/v1/testimonials');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data'
            ]);
    }

    public function test_authenticated_student_can_create_a_review()
    {
        $student = Student::factory()->create();

        Sanctum::actingAs($student);
        $payload = [
            'description' => 'This is a test review'
        ];

        $response = $this->postJson('/api/v1/reviews', $payload);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Review created successfully'
            ]);

        $this->assertDatabaseHas('reviews', [
            'description' => 'This is a test review',
            'student_id' => $student->id
        ]);
    }

    public function test_guest_cannot_create_a_review()
    {
        $payload = [
            'description' => 'Unauthorized review'
        ];

        $response = $this->postJson('/api/v1/reviews', $payload);

        $response->assertStatus(401);
    }

    public function test_review_description_is_required()
    {
        $student = Student::factory()->create();
        Sanctum::actingAs($student);

        $response = $this->postJson('/api/v1/reviews', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['description']);
    }
}
