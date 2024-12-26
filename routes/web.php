<?php

use Inertia\Inertia;
use App\Models\ShoppingCart;
use Illuminate\Http\Request;
use App\Models\ProductMaster;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/cart', [HomeController::class, 'showCart'])->name('cart');
