<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\ReviewRequest;
use App\Http\Resources\ReviewResource;
use Symfony\Component\HttpFoundation\Response;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        $reviews = $product->reviews()->get();
        return response()->json(ReviewResource::collection($reviews), Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReviewRequest $request, Product $product)
    {
        $review = $product->reviews()->create([
                                        'review' => $request->review,
                                        'user_id' => auth()->user()->id
                                    ]);
        // notify user

        return response()->json(new ReviewResource($review), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show(Review $review)
    {
        return response()->json(new ReviewResource($review), Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Review $review)
    {
        if ($review->ownedBy(auth()->user())) {

            $review->update($request->all());
            return response()->json(['Updated'], Response::HTTP_ACCEPTED);

        }

        return response()->json(['errors' => 'Review not owned by user'], Response::HTTP_BAD_REQUEST);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
        $review->delete();
        return response([], Response::HTTP_NO_CONTENT);
    }
}
