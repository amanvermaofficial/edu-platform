<?php

namespace App\Services\Admin;


use App\Models\Review;
use App\Repositories\Admin\ReviewRepository;

/**
 * Class ReviewService.
 */
class ReviewService
{
    protected $reviewRepository;
    public function __construct(ReviewRepository $reviewRepository){
        $this->reviewRepository = $reviewRepository;
    }

    public function getForDataTable()
    {
        return $this->reviewRepository->query();
    }

    public function getReview(int $id): Review
    {
        return $this->reviewRepository->findById($id);
    }

      public function toggleStatus(Review $review): Review
    {
        return $this->reviewRepository->togglePublish($review);
    }

    public function delete(Review $review): bool
    {
        return $this->reviewRepository->delete($review);
    }


}
