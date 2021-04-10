<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductLike;
use App\Notifications\ProductLiked;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductLikeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Product $product)
    {
        if (!$product->hasBeenlikedBy(auth()->user())) {

           $like = $product->likes()->create([
                'user_id' => auth()->user()->id
            ]);

            $product->user->notify(new ProductLiked($like));
            return response()->json(['message' => 'Product successfully liked'], Response::HTTP_CREATED);

        }

        return response()->json([
                'errors' => 'Product already liked by user'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductLike  $productLike
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->likes()->where('user_id', auth()->user()->id)->delete();
        return response([], Response::HTTP_NO_CONTENT);

    }
}
