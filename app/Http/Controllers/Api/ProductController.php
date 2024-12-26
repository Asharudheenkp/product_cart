<?php

namespace App\Http\Controllers\Api;

use App\Models\ShoppingCart;
use Illuminate\Http\Request;
use App\Models\ProductMaster;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function getProducts(Request $request)
    {
        $products = ProductMaster::select('product_image', 'product_name', 'price')->get();
        return response()->json(['status' => true, 'products' => $products]);
    }

    public function createProducts(Request $request)
    {
        DB::beginTransaction();
        try {
            $product = ProductMaster::create([
                'product_image' => $request->product_image,
                'product_name' => $request->product_name,
                'price' => $request->price,
            ]);
            DB::commit();
            return response()->json(['status' => true, 'product' => $product, 'message' => 'Product added successfully']);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(['status' => false, 'message' => 'Something went wrong!']);
        }
    }

    public function addToCart(Request $request, ProductMaster $product)
    {

        try {
            DB::beginTransaction();
            $data = [
                'product_id' => $product->id,
                'quantity' => $request->get('quantity', 1),
            ];

            if (auth()->check()) {
                $key = 'user_id';
                $value = auth()->id();
                $data[$key] = $value;
            } else {

                $key = 'session_id';
                $value =  session()->get('cart_id') ?? session()->put('cart_id', rand(1000, 50000)) ;
                $data[$key] = $value;
            }

            ShoppingCart::updateOrCreate(
                ['product_id' => $product->id, $key => $value],
                $data
            );
            DB::commit();
            return response()->json([
                'status' => true,
                'product' => $product,
                'message' => 'Product added to cart successfully',
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'status' => false,
                'message' => 'Failed to add product to cart!',
                'error' => $th->getMessage(),
            ]);
        }
    }

    public function getCartItems(Request $request)
    {
        try {
            $cartItems = ShoppingCart::where(function ($query) {
                if (auth()->check()) {
                    $query->where('user_id', auth()->id());
                } else {
                    $query->where('session_id', session()->getId());
                }
            })->get();

            return response()->json([
                'status' => true,
                'cart_items' => $cartItems,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to retrieve cart items!',
                'error' => $th->getMessage(),
            ]);
        }
    }

    public function applyCouponCode(Request $request)
    {
        if ($request->total_price < 500 ) {
            return response()->json([
                'status' => false,
                'message' => 'To apply coupon code the total price must be greater than $500!',
            ]);
        }

        if ($request->coupon_code == "OFFER1") {
            $discount = ($request->total_price*10)/100 > 75 ? 75 : ($request->total_price*10)/100;
            return response()->json([
                'status' => true,
                'discount' =>  $discount,
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'This coupon is not valid!',
            ]);
        }
    }
}
