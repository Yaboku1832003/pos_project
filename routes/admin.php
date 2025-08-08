<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\CategoryController;

Route::group(['prefix' => 'admin', 'middleware' => 'adminMiddleware'], function () {
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('admin#dashboard');

    Route::group(['prefix' => 'category'], function () {
        Route::get('list', [CategoryController::class, 'list'])->name('category#list');
        Route::post('create', [CategoryController::class, 'create'])->name('category#create');
        Route::get('delete/{id}', [CategoryController::class, 'delete'])->name('category#delete');
        Route::get('edit/{id}', [CategoryController::class, 'edit'])->name('category#edit');
        Route::post('update/{id}', [CategoryController::class, 'update'])->name('category#update');
    });

    Route::group(['prefix' => 'product'], function () {
        Route::get('createPage', [ProductController::class, 'categoryList'])->name('product#createPage');
        Route::post('create', [ProductController::class, 'create'])->name('product#create');
        Route::get('delete/{id}', [ProductController::class, 'delete'])->name('product#delete');
        Route::get('edit/{id}', [ProductController::class, 'edit'])->name('product#edit');
        Route::post('update', [ProductCOntroller::class, 'update'])->name('product#update');
        Route::get('list/{action?}', [ProductController::class, 'list'])->name('product#list');
        Route::get('lowAmt', [ProductController::class, 'lowAmount'])->name('product#lowAmt');

    });

    Route::group(['prefix' => 'profile'], function() {
        Route::get('change/password',[ProfileController::class,'changePasswordPage'])->name('profile#changePassword');
        Route::post('change/password',[ProfileController::class,'changePassword'])->name('profile#changePassword');
    });
});
