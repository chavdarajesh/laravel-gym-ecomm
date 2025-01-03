<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //

    public function checkout(Request $request)
    {

        $cartItems = Cart::where('user_id', auth()->id())->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('message', 'No items in the cart.');
        }

        $total_price = $cartItems->sum(function ($cartItem) {
            return $cartItem->price * $cartItem->quantity;
        });

        // Create an order
        $order = Order::create([
            'user_id' => auth()->id(),
            'price' => $total_price,
            'payment_type' => $request->payment_type,
        ]);

        // Attach products to the order

        foreach ($cartItems as $product) {
            $order->products()->attach($product['product_id'], [ // Removed extra space
                'user_id' => $product['user_id'],
                'quantity' => $product['quantity'],
                'price' => $product['price'],
                'total_price' => $product['price'] * $product['quantity'],
                'size_id' => $product['size_id'],
                'flavor_id' => $product['flavor_id'],
            ]);
        }
        $cartItems->each->delete();

        if($request->payment_type == 'cod') {
            $order->update([
                'status' => 'completed',
            ]);
            return redirect()->route('front.products-completed',['id' => $order->id])->with('success', 'Order placed successfully!');
        }
        // Redirect to payment
        return redirect()->route('payment.process', ['id' => $order->id]);
    }
}
