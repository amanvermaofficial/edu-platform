<?php

namespace App\Repositories\Admin;

use App\Models\Review;

class ReviewRepository
{
    public function query()
    {
        return Review::with('student:id,name');
    }

    public function findById(int $id): Review
    {
        return Review::with('student:id,name,profile_picture')->findOrFail($id);
    }

    public function togglePublish(Review $review): Review
    {
        $newStatus = ! $review->is_published;

        $review->update([
            'is_published' => $newStatus,
            'published_at' => $newStatus ? now() : null,
        ]);

        return $review->refresh();
    }


    public function delete(Review $review): bool
    {
        return $review->delete();
    }
}
