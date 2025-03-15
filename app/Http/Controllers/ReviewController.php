<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewRequest;
use App\Models\Review;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Mockery\Exception;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $reviews = Review::with(['user', 'book'])
                ->get()
                ->makeHidden(['created_at', 'updated_at', 'user', 'book'])
                ->map(function ($review) {
                    $review['username'] = $review->user->name;
                    $review['book_title'] = $review->book->title;
                    return $review;
                });
            if ($reviews->isEmpty()) {
                return response()->json(['error' => 'There are no reviews yet.'], 404);
            }
            return response()->json(['message' => 'Successfully get all reviews.', 'data' => $reviews]);
        } catch (Exception $e) {
            print $e->getMessage();
            return response()->json($e->getMessage(), 500);
        }
    }


    /**
     * Display a listing of the reviews for the book.
     */
    public function reviewsForBook(string $book_id): JsonResponse
    {
        try {
            $reviews = Review::where('book_id', $book_id)
                ->get()
                ->makeHidden(['book_id', 'created_at', 'updated_at', 'user'])
                ->map(function ($review) {
                    $review['username'] = $review->user->name;
                    return $review;
                });

            if ($reviews->isEmpty()) {
                return response()->json(['error' => "This book doesn't have any reviews."], 404);
            }

            return response()->json(['message' => 'Successfully get reviews for book.', 'data' => $reviews]);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }

    }

    /**
     * Display a listing of the reviews for the user.
     */
    public function reviewsForUser(string $user_id): JsonResponse
    {
        try {
            $reviews = Review::where('user_id', $user_id)
                ->get()
                ->makeHidden(['user_id', 'created_at', 'updated_at', 'book'])
                ->map(function ($review) {
                    $review['title'] = $review->book->title;
                    return $review;
                });

            if ($reviews->isEmpty()) {
                return response()->json(['error' => "This user doesn't have any reviews."], 404);
            }

            return response()->json(['message' => 'Successfully get reviews for user.', 'data' => $reviews]);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReviewRequest $request): JsonResponse
    {
        try {
            $review = Review::create($request->validated());
            return response()->json(['message' => 'Successfully review created.', 'data' => $review], 201);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        try {
            $review = Review::where('id', $id)
                ->get()
                ->makeHidden('created_at', 'updated_at', 'user', 'book')
                ->map(function ($review) {
                    $review['username'] = $review->user->name;
                    $review['book_title'] = $review->book->title;
                    return $review;
                });

            return response()->json(['message' => 'Successfully get review..', 'data' => $review]);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ReviewRequest $request, string $id): JsonResponse
    {
        try {
            $review = Review::find($id);
            if (!$review) {
                throw new Exception("This review doesn't exist");
            }
            $review->update($request->validated());
            return response()->json(['message' => 'Review updated', 'review' => $review], 201);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            if ($id === "") {
                throw new Exception("ID is required.");
            }
            $review = Review::find($id);
            if ($review == null) {
                throw new Exception("This review doesn't exist");
            }
            $review->delete();
            return response()->json('Review has been deleted');
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }
}
