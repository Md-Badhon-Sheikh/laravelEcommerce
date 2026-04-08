<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Brand\BrandController;
use App\Http\Controllers\Admin\Category\CategoryController;
use App\Http\Controllers\Admin\Product\ProductController;
use App\Http\Middleware\AuthAdmin;


Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home.index');


Route::middleware(['auth'])->group(function () {
    Route::get('/account-dashboard', [UserController::class, 'index'])->name('user.index');
});


Route::middleware(['auth', 'AuthAdmin'])->group(function () {
    Route::group(['prefix' => 'admin'], function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');

        // BrandController routes
        Route::get('/brands', [BrandController::class, 'brands'])->name('brands');
        Route::get('/brands/add', [BrandController::class, 'add_brand'])->name('add.brand');
        Route::post('/brands/store', [BrandController::class, 'store_brand'])->name('store.brand');
        Route::get('/brands/edit/{id}', [BrandController::class, 'brand_edit'])->name('edit.brand');
        Route::post('/brands/update/{id}', [BrandController::class, 'brand_update'])->name('update.brand');
        Route::delete('/brands/delete/{id}', [BrandController::class, 'delete_brand'])->name('delete.brand');

        // CategoryController routes
        Route::get('/categories', [CategoryController::class, 'categories'])->name('categories');
        Route::get('/categories/add', [CategoryController::class, 'add_category'])->name('add.category');
        Route::post('/categories/store', [CategoryController::class, 'store_category'])->name('store.category');
        Route::get('/categories/edit/{id}', [CategoryController::class, 'category_edit'])->name('edit.category');
        Route::post('/categories/update/{id}', [CategoryController::class, 'category_update'])->name('update.category');
        Route::delete('/categories/delete/{id}', [CategoryController::class, 'delete_category'])->name('delete.category');


        // ProductController routes
        Route::get('/products', [ProductController::class, 'products'])->name('products');
    }); 
});