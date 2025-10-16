<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\UserProfileController;
use App\Http\Controllers\OrderNotificationController;

Route::group(['prefix' => 'user', 'middleware' => 'userMiddleware'],function(){
        Route::get('homepage',[UserController::class,'homepage'])->name('user#homePage');
        Route::get('category',[UserController::class,'category'])->name('user#category');

        Route::get('aboutUs',[UserController::class,'aboutUs'])->name('user#aboutUs');
        Route::get('contactUs',[UserController::class,'contactUs'])->name('user#contactUs');
        Route::get('policy',[UserController::class,'policy'])->name('user#policy');

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
        Route::post('/notifications/mark-all-read', [OrderNotificationController::class, 'markAllRead'])->name('notifications.markAllRead');
        Route::post('/notifications/mark-single-read', [OrderNotificationController::class, 'markSingleRead'])->name('notifications.markSingleRead');
        Route::get('/user/myNotifications', [OrderNotificationController::class, 'myNotifications'])->name('user#myNotifications');

        Route::group(['prefix' => 'profile'], function () {
        Route::get('change/password', [UserProfileController::class, 'changePasswordPage'])->name('userProfile#changePasswordPage');
        Route::post('change/password', [UserProfileController::class, 'changePassword'])->name('userProfile#changePassword');

        Route::get('edit', [UserProfileController::class, 'editProfile'])->name('userProfile#edit');
        Route::post('update', [UserProfileController::class, 'updateProfile'])->name('userProfile#update');
    });
});
