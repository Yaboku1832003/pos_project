<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;

Route::group(['prefix' => 'user', 'middleware' => 'userMiddleware'],function(){
        Route::get('homepage',[UserController::class,'homepage'])->name('user#homePage');
        Route::get('category',[UserController::class,'category'])->name('user#category');

        Route::get('product/detail/{id}',[UserController::class,'detail'])->name('user#productDetail');
        Route::post('product/review/',[UserController::class,'comment'])->name('user#comment');
        Route::post('product/review/delete',[UserController::class,'deleteComment'])->name('user#commentDelete');

        Route::post('product/cart/addToCart',[UserController::class,'addToCart'])->name('user#addToCart');
        Route::get('product/cart',[UserController::class,'goToCart'])->name('user#cart');

        Route::get('cart/delete',[UserController::class,'cartDelete'])->name('user#cartDelete');
        Route::post('cart/update',[UserController::class,'cartUpdate'])->name('user#cartDelete');


        Route::get('cart/tempStorage',[UserController::class,'tempStorage'])->name('user#tempStorage');
        Route::get('cart/paymentPage',[UserController::class,'paymentPage'])->name('user#paymentPage');

        Route::post('order',[UserController::class,'order'])->name('user#order');
        Route::get('myOrders',[UserController::class,'orderList'])->name('user#orderList');

});
