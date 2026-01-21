<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    /**
     * Store a new review
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'reviewable_type' => 'required|string|in:App\\Models\\Hotel,App\\Models\\Tour,App\\Models\\Car,App\\Models\\Cruise,App\\Models\\Bus',
            'reviewable_id' => 'required|integer',
            'rating' => 'required|numeric|min:1|max:5',
            'title' => 'nullable|string|max:255',
            'comment' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Check if user has already reviewed this item
        $existingReview = Review::where([
            'user_id' => Auth::id(),
            'reviewable_type' => $request->reviewable_type,
            'reviewable_id' => $request->reviewable_id,
        ])->first();

        if ($existingReview) {
            return response()->json([
                'success' => false,
                'message' => 'You have already reviewed this item.'
            ], 422);
        }

        $review = Review::create([
            'user_id' => Auth::id(),
            'reviewable_type' => $request->reviewable_type,
            'reviewable_id' => $request->reviewable_id,
            'rating' => $request->rating,
            'title' => $request->title,
            'comment' => $request->comment,
            'is_verified' => false, // Can be set based on booking verification
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Review submitted successfully!',
            'review' => $review->load('user:id,name,avatar')
        ]);
    }

    /**
     * Get reviews for a specific item
     */
    public function getReviews(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'reviewable_type' => 'required|string',
            'reviewable_id' => 'required|integer',
            'page' => 'nullable|integer|min:1',
            'per_page' => 'nullable|integer|min:1|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $perPage = $request->get('per_page', 10);
        $page = $request->get('page', 1);

        $reviews = Review::where([
            'reviewable_type' => $request->reviewable_type,
            'reviewable_id' => $request->reviewable_id,
        ])
        ->with('user:id,name,avatar')
        ->orderBy('created_at', 'desc')
        ->paginate($perPage, ['*'], 'page', $page);

        // Calculate average rating and review stats
        $stats = $this->getReviewStats($request->reviewable_type, $request->reviewable_id);

        return response()->json([
            'success' => true,
            'reviews' => $reviews,
            'stats' => $stats
        ]);
    }

    /**
     * Update a review
     */
    public function update(Request $request, Review $review)
    {
        // Check if user owns the review
        if ($review->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'You can only edit your own reviews.'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'rating' => 'required|numeric|min:1|max:5',
            'title' => 'nullable|string|max:255',
            'comment' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $review->update([
            'rating' => $request->rating,
            'title' => $request->title,
            'comment' => $request->comment,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Review updated successfully!',
            'review' => $review->load('user:id,name,avatar')
        ]);
    }

    /**
     * Delete a review
     */
    public function destroy(Review $review)
    {
        // Check if user owns the review or is admin
        if ($review->user_id !== Auth::id() && !Auth::user()->is_admin) {
            return response()->json([
                'success' => false,
                'message' => 'You can only delete your own reviews.'
            ], 403);
        }

        $review->delete();

        return response()->json([
            'success' => true,
            'message' => 'Review deleted successfully!'
        ]);
    }

    /**
     * Mark review as helpful
     */
    public function markHelpful(Request $request, Review $review)
    {
        $validator = Validator::make($request->all(), [
            'helpful' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        if ($request->helpful) {
            $review->increment('helpful_votes');
        } else {
            $review->decrement('helpful_votes');
        }

        return response()->json([
            'success' => true,
            'helpful_votes' => $review->helpful_votes
        ]);
    }

    /**
     * Get review statistics
     */
    private function getReviewStats($reviewableType, $reviewableId)
    {
        $reviews = Review::where([
            'reviewable_type' => $reviewableType,
            'reviewable_id' => $reviewableId,
        ])->get();

        $totalReviews = $reviews->count();
        $averageRating = $totalReviews > 0 ? $reviews->avg('rating') : 0;

        // Rating distribution
        $ratingDistribution = [
            5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0
        ];

        foreach ($reviews as $review) {
            $rating = (int) $review->rating;
            if (isset($ratingDistribution[$rating])) {
                $ratingDistribution[$rating]++;
            }
        }

        return [
            'total_reviews' => $totalReviews,
            'average_rating' => round($averageRating, 1),
            'rating_distribution' => $ratingDistribution,
        ];
    }
}
