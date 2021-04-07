<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductLikeController;
use App\Http\Controllers\ReviewLikeController;
use Symfony\Component\HttpFoundation\Response;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/', function () {
    return response()->json(['Welcome to E-commerce API'], Response::HTTP_OK);
});

Route::get('product/search', [ProductController::class, 'search']);
Route::post('product/{product}/like', [ProductLikeController::class, 'store'])->name('product.like');
Route::delete('product/{product}/like', [ProductLikeController::class, 'destroy'])->name('product.unlike');
Route::get('product/{product}/review', [ReviewController::class, 'index'])->name('product.getReviews');
Route::post('product/{product}/review', [ReviewController::class, 'store'])->name('product.createReviews');
Route::get('product/{product}/order', [ReviewController::class, 'index'])->name('product.getOrders');
Route::post('product/{product}/order', [ReviewController::class, 'store'])->name('product.createOrder');

Route::post('review/{review}/like', [ReviewLikeController::class, 'store'])->name('review.like');
Route::delete('review/{review}/like', [ReviewLikeController::class, 'destroy'])->name('review.unlike');
Route::post('review/{review}/reply', [ReplyController::class, 'store'])->name('reply.store');
Route::delete('review/{review}/reply', [ReplyController::class, 'destroy'])->name('reply.destroy');

Route::apiResource('product', ProductController::class);
Route::apiResource('review', ReviewController::class);
Route::apiResource('reply', ReplyController::class);
Route::apiResource('order', ReplyController::class);


Route::group([
    'prefix' => 'auth'
], function () {
        Route::get('me', [AuthController::class, 'me']);
        Route::post('login', [AuthController::class, 'login']);
        Route::post('signup', [AuthController::class, 'signup']);
        Route::post('logout', [AuthController::class, 'logout']);
});
