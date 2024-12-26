<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\ProductMaster;
use App\Models\ShoppingCart;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
            return Inertia::render('Welcome', [
                'products' => ProductMaster::select('id', 'product_image', 'product_name', 'price')->get()
            ]);
    }

    public function showCart(Request $request) {
        $cartItems = DB::table('shopping_carts as sc')
                        ->join('product_masters as pm', 'pm.id', '=', 'sc.product_id')
                        ->where(function ($query) use ($request) {
                            if (auth()->check()) {
                                $query->where('user_id', auth()->id());
                            } else {
                                $query->where('session_id', $request->session()->get('cart_id'));
                            }
                        })
                        ->select('product_name', 'price')
                        ->get();
        return Inertia::render('Cart', [
            'items' => $cartItems,
        ]);
    }
}
