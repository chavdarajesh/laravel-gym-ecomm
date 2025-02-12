<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderAddress;
use App\Models\OrderStatus;
use App\Models\Payment;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    //

    public function checkout(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|email',
            'address_line_1' => 'required|string',
            // 'address_line_2' => 'string',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10',
            'country' => 'required|string|max:255',
            'payment_type' => 'required|string',
        ]);


        $cartItems = Cart::where('user_id', auth()->id())->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('message', 'No items in the cart.');
        }

        $subTotal = Cart::where('user_id', auth()->id())->sum('total_price');

        $shippingChargeValue = SiteSetting::getSiteSettings('shipping_charges');
        if(isset($shippingChargeValue) && isset($shippingChargeValue->value) && $shippingChargeValue != null && $shippingChargeValue->value != ''){
            $shippingCharge = $shippingChargeValue->value;
        }else{
            $shippingCharge = 0;
        }

        $shipping_free_amount = SiteSetting::getSiteSettings('shipping_free_amount');
        if(isset($shipping_free_amount) && isset($shipping_free_amount->value) && $shipping_free_amount != null && $shipping_free_amount->value != '' && $subTotal >= $shipping_free_amount->value){
            $shippingCharge = 0;
        }

        $total_order = $subTotal + $shippingCharge; // Add delivery charge
        // Create an order
        // Store Address
        $address = OrderAddress::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address_line_1' => $request->address_line_1,
            'address_line_2' => $request->address_line_2 ? $request->address_line_2 : '',
            'city' => $request->city,
            'state' => $request->state,
            'postal_code' => $request->postal_code,
            'country' => $request->country,
        ]);

        $order = Order::create([
            'user_id' => auth()->id(),
            'total_order' => $total_order,
            'sub_total' => $subTotal,
            'shipping_charge' => $shippingCharge,
            'payment_type' => $request->payment_type,
            'payment_status' => 'pending',
            'order_status' => 'pending',
            'order_address_id' => $address->id,
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

        // if ($request->payment_type == 'cod') {
        //     $order->update([
        //         'status' => 'completed',
        //         'payment_status' => 'pending',
        //         'order_status' => 'pending',
        //     ]);
        //     $statusId = OrderStatus::where('name', 'Pending')->first()->id;
        //     $order->statuses()->attach($statusId, [
        //         'description' => 'Order has been placed but not yet processed.',
        //     ]);
        //     return redirect()->route('front.products-completed', ['id' => $order->id])->with('success', 'Order placed successfully!');
        // }
        // Redirect to payment
        // $statusId = OrderStatus::where('name', 'Payment Pending')->first()->id;
        // $order->statuses()->attach($statusId, [
        //     'description' => 'Payment is pending.',
        // ]);
        return redirect()->route('payment.process', ['id' => $order->id]);
    }

    public function orders()
    {
        $orders = Order::where('user_id', auth()->id())->orderBy('created_at', 'desc')
            ->get();
        return view('front.orders.index', compact('orders'));
    }

    public function ordersDetails($id)
    {
        $order = Order::where('user_id', auth()->id())->where('id', $id)->first();
        if (!$order) {
            return redirect()->route('front.orders')->with('error', 'Order not found.');
        }
        $latestStatus = $order->latestStatus()->first();

        $refundPayments = Payment::where('order_id', $id)->where('payment_from', 'store')->where('user_id', auth()->id())->get();

        return view('front.orders.details', compact('order','latestStatus','refundPayments'));
    }

    public function ordersCancel($id)
    {
        $order = Order::where('user_id', auth()->id())->where('id', $id)->first();

        if (!$order) {
            return redirect()->route('front.orders')->with('error', 'Order not found.');
        }
        if ($order->order_status != 'pending') {
            return redirect()->route('front.orders-details', $id)->with('error', 'Only pending orders can be canceled.');
        }
        // return redirect()->route('front.orders-details', $id)->with('success', 'Order has been canceled.');
        return redirect()->route('front.products-refund', $id)->with('success', 'Order has been canceled.');
    }
}
