<?php

namespace Tests\Feature\Admin;

use App\Models\Review;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReviewTest extends TestCase
{
    use RefreshDatabase;

    protected function adminLogin()
    {
        $admin = User::factory()->create();
        $this->actingAs($admin);

        return $admin;
    }

    public function test_admin_can_view_reviews_list()
    {
        $admin = $this->adminLogin();
        $this->get(route('admin.reviews.index'))
            ->assertStatus(200)
            ->assertViewIs('admin.reviews.index');
    }

    public function test_admin_can_view_single_review()
    {
        $admin = $this->adminLogin();

        $review = Review::factory()->create();
        $response = $this->get(route('admin.reviews.show', $review));

        $response->assertStatus(200);
        $response->assertViewIs('admin.reviews.show');
        $response->assertViewHas('review', $review);
    }

    public function test_admin_can_toggle_review_status()
    {
        $admin = $this->adminLogin();
        $review = Review::factory()->create([
            'is_published' => false
        ]);

        $this->post(route('admin.reviews.toggle-status', $review));

        $this->assertDatabaseHas('reviews', [
            'id' => $review->id,
            'is_published' => true
        ]);
    }

    public function test_admin_can_delete_review()
    {
        $this->adminLogin();

        $review = Review::factory()->create();

        $response = $this->delete(route('admin.reviews.destroy', $review));

        $response->assertRedirect(route('admin.reviews.index'));

        $this->assertDatabaseMissing('reviews', [
            'id' => $review->id
        ]);
    }
}
