<?php

namespace App\Services;

use App\Models\Review;
use App\Repositories\ReviewRepository;
use Exception;
use Illuminate\Support\Facades\Auth;

/**
 * Class ReviewService.
 */
class ReviewService
{
    protected $repo;

    public function __construct(ReviewRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getAllReviews()
    {
        try {
            $reviews = $this->repo->all();

            return [
                'success' => true,
                'message' => 'Reviews fetched successfully',
                'data' => $reviews
            ];
        } catch (Exception $e) {
             return [
            'success' => false,
            'message' => $e->getMessage()
        ];
        }
    }

    public function create($data)
    {
        try {
            $student = Auth::guard('sanctum')->user();
            $review = $this->repo->createReview($data, $student);

            return [
                'success' => true,
                'message' => 'Review created successfully',
                'data' => $review
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
}
