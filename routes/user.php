<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;

Route::group(['prefix' => 'user', 'middleware' => 'userMiddleware'],function(){
        Route::get('dashboard',[UserController::class,'dashboard'])->name('user#dashboard');
});
