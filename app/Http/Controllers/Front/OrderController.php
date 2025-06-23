<?php
namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Mail\Order\OrderStatusUpdatedMail;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderAddress;
use App\Models\OrderStatus;
use App\Models\Payment;
use App\Models\SiteSetting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    //

    public function checkout(Request $request)
    {

        $request->validate([
            'name'           => 'required|string|max:255',
            'phone'          => 'required|string|max:15',
            'email'          => 'required|email',
            'address_line_1' => 'required|string',
            // 'address_line_2' => 'string',
            'city'           => 'required|string|max:255',
            'state'          => 'required|string|max:255',
            'postal_code'    => 'required|string|max:10',
            'country'        => 'required|string|max:255',
            'payment_type'   => 'required|string',
        ]);

        $cartItems = Cart::where('user_id', auth()->id())->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('message', 'No items in the cart.');
        }

        $subTotal = Cart::where('user_id', auth()->id())->sum('total_price');

        $shippingChargeValue = SiteSetting::getSiteSettings('shipping_charges');
        if (isset($shippingChargeValue) && isset($shippingChargeValue->value) && $shippingChargeValue != null && $shippingChargeValue->value != '') {
            $shippingCharge = $shippingChargeValue->value;
        } else {
            $shippingCharge = 0;
        }

        $shipping_free_amount = SiteSetting::getSiteSettings('shipping_free_amount');
        if (isset($shipping_free_amount) && isset($shipping_free_amount->value) && $shipping_free_amount != null && $shipping_free_amount->value != '' && $subTotal >= $shipping_free_amount->value) {
            $shippingCharge = 0;
        }

        $total_order = $subTotal + $shippingCharge;

        $address = OrderAddress::create([
            'user_id'        => Auth::id(),
            'name'           => $request->name,
            'phone'          => $request->phone,
            'email'          => $request->email,
            'address_line_1' => $request->address_line_1,
            'address_line_2' => $request->address_line_2 ? $request->address_line_2 : '',
            'city'           => $request->city,
            'state'          => $request->state,
            'postal_code'    => $request->postal_code,
            'country'        => $request->country,
        ]);

        $order = Order::create([
            'user_id'          => auth()->id(),
            'total_order'      => $total_order,
            'sub_total'        => $subTotal,
            'shipping_charge'  => $shippingCharge,
            'payment_type'     => $request->payment_type,
            'payment_status'   => 'pending',
            'order_status'     => 'pending',
            'return_status'    => 'none',
            'order_address_id' => $address->id,
        ]);

        foreach ($cartItems as $product) {
            $order->products()->attach($product['product_id'], [ // Removed extra space
                'user_id'     => $product['user_id'],
                'quantity'    => $product['quantity'],
                'price'       => $product['price'],
                'total_price' => $product['price'] * $product['quantity'],
                'size_id'     => $product['size_id'],
                'flavor_id'   => $product['flavor_id'],
            ]);
        }

        $cartItems->each->delete();

        $statusId = OrderStatus::where('key', 'order_created')->first()->id;
        $order->statuses()->attach($statusId, [
            'description' => 'Order has been Created.',
        ]);
        if (env('MAIL_USERNAME')) {
            if ($order->user && $order->user->email) {
                Mail::to($order->user->email)->send(new OrderStatusUpdatedMail($order));
            }
            $adminEmail = SiteSetting::getSiteSettings('admin_email');
            if (isset($adminEmail) && isset($adminEmail->value) && $adminEmail != null && $adminEmail->value != '') {
                $adminEmail = $adminEmail->value;
            } else {
                $adminEmail = env('ADMIN_EMAIL', '');
            }
            if ($adminEmail) {
                Mail::to($adminEmail)->send(new OrderStatusUpdatedMail($order));
            }
        }

        $statusId = OrderStatus::where('key', 'payment_pending')->first()->id;
        $order->statuses()->attach($statusId, [
            'description' => 'Payment is pending. Please complete the payment to process the order.',
            'created_at'  => Carbon::now()->addSeconds(5),
            'updated_at'  => Carbon::now()->addSeconds(5),
        ]);

        return redirect()->route('front.orders.payment-upload.get', ['id' => $order->id]);
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
        if (! $order) {
            return redirect()->route('front.orders')->with('error', 'Order not found.');
        }
        $latestStatus  = $order->latestStatus()->first();
        $returnAddress = SiteSetting::getSiteSettings('return_address');
        if (isset($returnAddress) && isset($returnAddress->value) && $returnAddress != null && $returnAddress->value != '') {
            $returnAddress = $returnAddress->value;
        } else {
            $returnAddress = 'No return address set.';
        }
        $refundPayments = Payment::where('order_id', $id)->where('payment_from', 'store')->where('user_id', auth()->id())->get();

        return view('front.orders.details', compact('order', 'latestStatus', 'refundPayments', 'returnAddress'));
    }

    public function ordersCancel($id)
    {
        $order = Order::where('user_id', auth()->id())->where('id', $id)->first();

        if (! $order) {
            return redirect()->route('front.orders')->with('error', 'Order not found.');
        }
        if ($order->order_status != 'pending' && $order->order_status != 'processing') {
            return redirect()->route('front.orders.details', $id)->with('error', 'Order is delivered or cancelled. You cannot cancel this order.');
        }
        if (($order->payment_status == 'pending' || $order->payment_status == 'failed' || $order->payment_status == 'processing') && $order->order_status == 'pending') {
            $order->update([
                'order_status'   => 'cancelled',
                'payment_status' => 'cancelled',
            ]);
            $statusId = OrderStatus::where('key', 'order_cancelled')->first()->id;
            $order->statuses()->attach($statusId, [
                'description' => 'Order has been cancelled by the user.',
            ]);

            if (env('MAIL_USERNAME')) {
                if ($order->user && $order->user->email) {
                    Mail::to($order->user->email)->send(new OrderStatusUpdatedMail($order));
                }
                $adminEmail = SiteSetting::getSiteSettings('admin_email');
                if (isset($adminEmail) && isset($adminEmail->value) && $adminEmail != null && $adminEmail->value != '') {
                    $adminEmail = $adminEmail->value;
                } else {
                    $adminEmail = env('ADMIN_EMAIL', '');
                }
                if ($adminEmail) {
                    Mail::to($adminEmail)->send(new OrderStatusUpdatedMail($order));
                }
            }

            return redirect()->route('front.orders.details', $id)->with('success', 'Order has been cancelled successfully.');
        } else if ($order->payment_status == 'completed' && $order->order_status == 'processing') {

            return redirect()->route('front.orders.details', $id)->with('error', 'Order is already processed. You cannot cancel this order.');

            // need to send a mail regarding refund from 
            // need to get bank details for payment
            // $order->update([
            //     'order_status' => 'cancelled',
            //     'payment_status' => 'cancelled',
            //     'refund_status' => 'requested',
            // ]);
            // $statusId = OrderStatus::where('name', 'Order Cancelled')->first()->id;
            // $order->statuses()->attach($statusId, [
            //     'description' => 'Order has been cancelled by the user.',
            // ]);
            // $statusId = OrderStatus::where('name', 'redund inicted')->first()->id;
            // $order->statuses()->attach($statusId, [
            //     'description' => 'rrrrrrrrrr.',
            // ]);
            // show a bank details get page and data 

        } else {
            return redirect()->route('front.orders.details', $id)->with('error', 'Order is delivered or cancelled. You cannot cancel this order.');
        }
    }

}
