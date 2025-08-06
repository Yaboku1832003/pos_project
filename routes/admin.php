<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use Illuminate\Support\Facades\Route;

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
        Route::get('list/{action?}', [ProductController::class, 'list'])->name('product#list');
        Route::get('lowAmt', [ProductController::class, 'lowAmount'])->name('product#lowAmt');

    });
});
