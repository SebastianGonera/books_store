<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\ReviewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(BookController::class)
    ->group(function () {
        Route::get('books', 'index');
        Route::get('books/{id}', 'show');
        Route::post('books', 'store');
        Route::put('books/{id}', 'update');
        Route::delete('books/{id}', 'destroy');
    });

Route::controller(ReviewController::class)
    ->group(function () {
        Route::get('reviews', 'index');
        Route::get('reviews/book/{book_id}', 'reviewsForBook');
        Route::get('reviews/user/{user_id}', 'reviewsForUser');
        Route::get('reviews/{id}/', 'show');
        Route::post('reviews', 'store');
        Route::put('reviews/{id}', 'update');
        Route::delete('reviews/{id}', 'destroy');
    });

Route::controller(CartItemController::class)
    ->group(function () {
       Route::get('carts/user/{user_id}', 'index');
       Route::post('carts', 'store');
       Route::put('carts/{id}', 'update');
       Route::delete('carts/{id}', 'destroy');
    });

Route::controller(OrderItemController::class)
    ->group(function () {
        Route::get('items/order/{id}', 'index');
        Route::post('items/order', 'store');
        Route::put('items/order/{id}', 'update');
        Route::delete('items/order/{id}', 'destroy');
    });

Route::controller(OrderController::class)
->group(function () {
  Route::get('orders', 'index');
  Route::get('orders/{id}', 'show');
  Route::post('orders', 'store');
  Route::put('orders/{id}', 'update');
  Route::delete('orders/{id}', 'destroy');
});
