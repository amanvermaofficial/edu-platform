<?php

namespace App\Repositories;

use App\Models\Review;  

class ReviewRepository{

    public function all(){
        $reviews = Review::with('student:id,name')
        ->where('is_published', true)
        ->latest('published_at')
        ->get();

        return $reviews;
    }

    public function createReview($data, $student){
        return Review::create([
            'student_id' => $student->id,
            'description' => $data['description'],
        ]);
    }
}