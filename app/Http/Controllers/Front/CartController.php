<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    //

    public function addToCart(Request $request)
    {
        $request->validate([
            'product' => 'required|exists:products,id',
            'size' => 'required',
            'flavor' => 'required',
        ]);

        $product = Product::findOrFail($request->product);
        $cartItem = Cart::where('user_id', auth()->id())
            ->where('product_id', $request->product)
            ->where('size_id', $request->size)
            ->where('flavor_id', $request->flavor)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += 1;
            $cartItem->save();
        } else {
            // Find the specific size for the product
            $size = $product->sizes()->where('size_id', $request->size)->first();
            if ($size) {
                $price = $size->pivot->price;
            } else {
                $price = 0;
            }
            Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $request->product,
                'size_id' => $request->size,
                'flavor_id' => $request->flavor,
                'quantity' => 1,
                'price' => $price, // Adjust as needed for size/flavor-specific pricing
            ]);
        }
        return redirect()->route('fron')->with('message', 'Product added to cart successfully.');
    }
}
