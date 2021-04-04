<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductLikeController;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/', function () {
    return response()->json(['Welcome to E-commerce API'], Response::HTTP_OK);
});

Route::get('product/search', [ProductController::class, 'search']);
Route::post('product/{product}/like', [ProductLikeController::class, 'store'])->name('product.like');
Route::delete('product/{product}/like', [ProductLikeController::class, 'destroy'])->name('product.unlike');
Route::get('product/{product}/review', [ReviewController::class, 'index'])->name('review.index');
Route::post('product/{product}/review', [ReviewController::class, 'store'])->name('review.store');


Route::apiResource('product', ProductController::class);
Route::apiResource('review', ReviewController::class);
Route::apiResource('reply', ReplyController::class);

Route::group([
    'prefix' => 'auth'
], function () {
        Route::get('me', [AuthController::class, 'me']);
        Route::post('login', [AuthController::class, 'login']);
        Route::post('signup', [AuthController::class, 'signup']);
        Route::post('logout', [AuthController::class, 'logout']);
});
