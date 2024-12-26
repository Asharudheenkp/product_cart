<?php

use App\Http\Controllers\Api\ProductController;
use App\Models\ProductMaster;
use App\Models\ShoppingCart;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::group(['middleware' => ['api']], function() {
    Route::post('/products', [ProductController::class, 'getProducts'])->name('products');
    Route::post('/products/create', [ProductController::class, 'createProducts'])->name('product.create');
    Route::post('/product/add-to-cart/{product}', [ProductController::class, 'addToCart'])->name('add.to.cart');
    Route::post('/cart', [ProductController::class, 'getCartItems'])->name('get.cart.items');
    Route::post('/apply-coupon', [ProductController::class, 'applyCouponCode'])->name('apply.coupon.code');
});
