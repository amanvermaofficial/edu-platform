<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ReviewDataTable;
use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Services\Admin\ReviewService;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    protected $reviewService;
    public function __construct(ReviewService $reviewService)
    {
        $this->reviewService = $reviewService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(ReviewDataTable $dataTable)
    {
        return $dataTable->render('admin.reviews.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Review $review)
    {
        $review->load('student:id,name,profile_picture');
        return view('admin.reviews.show', compact('review'));
    }

    public function toggleStatus(Review $review)
    {
        //dd('HIT', $review->id, $review->is_published);
        $this->reviewService->toggleStatus($review);
        return back()->with('success', 'Review status updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        $this->reviewService->delete($review);
        return redirect()
            ->route('admin.reviews.index')
            ->with('success', 'Review deleted successfully');
    }
}
