<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\OrderNotificationController;

Route::group(['prefix' => 'user', 'middleware' => 'userMiddleware'],function(){
        Route::get('homepage',[UserController::class,'homepage'])->name('user#homePage');
        Route::get('category',[UserController::class,'category'])->name('user#category');

        Route::get('product/detail/{id}',[UserController::class,'detail'])->name('user#productDetail');
        Route::post('product/review/',[UserController::class,'comment'])->name('user#comment');
        Route::post('product/review/delete',[UserController::class,'deleteComment'])->name('user#commentDelete');

        Route::post('product/cart/addToCart',[CartController::class,'addToCart'])->name('user#addToCart');
        Route::get('product/cart',[CartController::class,'goToCart'])->name('user#cart');

        Route::get('cart/delete',[CartController::class,'cartDelete'])->name('user#cartDelete');
        Route::post('cart/update',[CartController::class,'cartUpdate'])->name('user#cartDelete');


        Route::get('cart/tempStorage',[CartController::class,'tempStorage'])->name('user#tempStorage');
        Route::get('cart/paymentPage',[CartController::class,'paymentPage'])->name('user#paymentPage');
        Route::get('order/details/{orderCode}',[CartController::class,'orderDetails'])->name('user#orderDetails');
        Route::post('order',[UserController::class,'order'])->name('user#order');

        Route::get('/notifications/count', [OrderNotificationController::class, 'getNotificationCount'])->name('user#notificationCount');
        Route::post('/notifications/mark-as-read', [OrderNotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
        Route::get('/user/my-orders', [OrderNotificationController::class, 'myOrders'])->name('user#myOrders');
});
