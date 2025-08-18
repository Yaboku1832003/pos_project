<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;

Route::group(['prefix' => 'user', 'middleware' => 'userMiddleware'],function(){
        Route::get('homepage',[UserController::class,'homepage'])->name('user#homePage');
        Route::get('category',[UserController::class,'category'])->name('user#category');

        Route::get('product/detail/{id}',[UserController::class,'detail'])->name('user#productDetail');
        Route::post('product/review/',[UserController::class,'comment'])->name('user#comment');
});
