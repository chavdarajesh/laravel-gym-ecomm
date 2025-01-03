<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //

    public function checkout(Request $request)
    {
        // Validate the request
        $request->validate([
            'products' => 'required|array',
            'products.*.id' => 'required|integer',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        // Create an order
        $order = Order::create([
            'user_id' => auth()->id(),
            'total_price' => $request->total_price,
        ]);

        // Attach products to the order
        foreach ($request->products as $product) {
            $order->products()->attach($product['id'], [
                'quantity' => $product['quantity'],
                'price' => $product['price'],
            ]);
        }

        // Redirect to payment
        return redirect()->route('payment.process', ['order_id' => $order->id]);
    }
}
