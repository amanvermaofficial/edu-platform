<?php

namespace Tests\Feature\Api\V1;

use App\Models\Course;
use App\Models\Trade;
use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TradeTest extends TestCase
{
    use RefreshDatabase;

    protected function authHeader()
    {
        $student = Student::factory()->create();
        $token = $student->createToken('test')->plainTextToken;

        return [
            'Authorization' => 'Bearer ' . $token,
        ];
    }


    public function it_returns_all_trades()
    {
        Trade::factory()->count(3)->create();

        $response = $this->withHeaders($this->authHeader())
            ->getJson('/api/v1/trades');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Trades fetched successfully.',
            ])
            ->assertJsonStructure([
                'data' => [
                    'trades' => [
                        '*' => ['id', 'name', 'description']
                    ]
                ]
            ]);
    }


    public function it_returns_trades_by_course()
    {
        $course = Course::factory()->create();
        $trade1 = Trade::factory()->create();
        $trade2 = Trade::factory()->create();

       
        $course->trades()->attach([$trade1->id, $trade2->id]);

        $response = $this->withHeaders($this->authHeader())
            ->getJson("/api/v1/courses/{$course->id}/trades");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Trades fetched successfully.',
            ])
            ->assertJsonCount(2, 'data.trades');
    }
}
