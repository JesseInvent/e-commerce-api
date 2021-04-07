<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources\OrderResource;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        if ($product->wasCreatedBy(auth()->user())) {
            $orders = $product->orders()->paginate(20);
            return response()->json(OrderResource::collection($orders), Response::HTTP_OK);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderRequest $request, Product $product)
    {
        $order = $product->orders()->create(array_merge($request->all(), [
            'user_id' => auth()->user()->id,
            'paid_status' => false
        ]));

        // notify user

        return response()->json(new OrderResource($order), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        if ($order->wasCreatedBy(auth()->user()) || $order->belongsToProductCreatedBy(auth()->user()) ) {
            return response()->json(new OrderResource($order), Response::HTTP_OK);
        }

        return response()->json(['errors' => 'User not permitted to carry out this task'], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        if ($order->wasCreatedBy(auth()->user()) || $order->belongsToProductCreatedBy(auth()->user()) ) {
            $order->delete();
            return response([], Response::HTTP_NO_CONTENT);
        }

        return response()->json(['errors' => 'User not permitted to carry out this task, user must be creator of order or owner of product'], Response::HTTP_BAD_REQUEST);
    }
}
