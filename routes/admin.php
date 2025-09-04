<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
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

    Route::group(['prefix' => 'profile'], function () {
        Route::get('change/password', [ProfileController::class, 'changePasswordPage'])->name('profile#changePassword');
        Route::post('change/password', [ProfileController::class, 'changePassword'])->name('profile#changePassword');

        Route::get('edit', [ProfileController::class, 'editProfile'])->name('profile#edit');
        Route::post('update', [ProfileController::class, 'updateProfile'])->name('profile#update');
    });


    //superadmin only start (protected with middleWare)
    Route::middleware('superAdminMiddleware')->group(function () {
        //one
        Route::prefix('payment')->group(function () {
            Route::get('createPage', [AdminController::class, 'createPaymentMethodPage'])->name('payment#paymentMethod');
            Route::post('create/method', [AdminController::class, 'createMethod'])->name('payment#storeMethod');

            Route::get('delete/{id}', [AdminController::class, 'deleteMethod'])->name('payment#delete');

            Route::get('edit/{id}', [AdminController::class, 'editMethod'])->name('payment#edit');
            Route::post('update/{id}', [AdminController::class, 'updateMethod'])->name('payment#update');

        });

        //two
        //one and two are the same with different writing style

        Route::group(['prefix' => 'account'], function () {
            Route::get('create/newAdmin', [AdminController::class, 'createAdminPage'])->name('account#newAdminPage');
            Route::post('create/newAdmin', [AdminController::class, 'createAdmin'])->name('account#createNewAdmin');

            Route::get('delete/admin/{id}',[AdminController::class, 'deleteAdmin'])->name('account#deleteAdmin');
            Route::get('delete/user/{id}',[AdminController::class, 'deleteUser'])->name('account#deleteUser');

            Route::get('admin/list', [AdminController::class, 'adminList'])->name('account#adminList');
            Route::get('user/list', [AdminController::class, 'userList'])->name('account#userList');

        });

    });
     //superadmin only end (protected with middleWare)

     Route::group(['prefix' => 'order'],function(){
        Route::get('list',[OrderController::class,'orderList'])->name('admin#orderList');
        Route::get('details/{orderCode}',[OrderController::class,'orderDetails'])->name('admin#orderDetails');
        Route::get('/payment/download/{id}', [PaymentController::class, 'download'])->name('payment#download');
     });
});
