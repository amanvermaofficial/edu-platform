<?php

namespace App\Repositories;

use App\Models\Review;

class ReviewRepository
{

    public function all()
    {
        return Review::with('student:id,name,profile_picture')
            ->where('is_published', true)
            ->latest('published_at')
            ->get()
            ->map(function ($review) {

                if ($review->student && $review->student->profile_picture) {

                    $photo = $review->student->profile_picture;

                    if (str_starts_with($photo, 'http')) {
                        $review->student->profile_picture = $photo;
                    }
                    else {
                        $review->student->profile_picture = asset('storage/' . $photo);
                    }
                }

                return $review;
            });
    }


    public function createReview($data, $student)
    {
        return Review::create([
            'student_id' => $student->id,
            'description' => $data['description'],
        ]);
    }
}
