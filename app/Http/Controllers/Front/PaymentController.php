<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Payment;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;


class PaymentController extends Controller
{
    //

    public function process($id)
    {
        $order = Order::findOrFail($id);
        if (!$order) {
            return redirect()->back()->with('error', 'Order not found.');
        }

        if ($order->status === 'completed') {
            return redirect()->route('payment.success')->with('success', 'Payment successful!');
        }

        $order->update([
            'status' => 'pending',
            'payment_status' => 'pending',
            'order_status' => 'pending',
        ]);

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $order->total_order,
                    ],
                ],
            ],
        ]);

        if (isset($response['id'])) {
            $order->update(['payment_id' => $response['id']]);
            return redirect($response['links'][1]['href']);
        }

        return redirect()->back()->with('error', 'Unable to process payment.');
    }

    public function successRedirect(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        $response = $provider->capturePaymentOrder($request->query('token'));

        $order = Order::where('payment_id', $response['id'])->first();
        if ($response['status'] === 'COMPLETED') {
            $order->update([
                'status' => 'completed',
                'payment_status' => 'completed',
                'order_status' => 'pending',
            ]);

            $statusId = OrderStatus::where('name', 'Pending')->first()->id;
            $order->statuses()->attach($statusId, [
                'description' => 'Order has been placed but not yet processed.',
            ]);

            Payment::create([
                'transaction_id' => $response['id'],
                'amount' => $order->total_price,
                'payment_method' => 'PayPal',
                'payment_status' => 'Completed',
            ]);

            return redirect()->route('front.products-completed')->with('success', 'Payment successful!');
        }

        return redirect()->route('payment.failed',['id',$order->id])->with('error', 'Payment failed.');
    }

    public function cancelRedirect(Request $request)
    {
        return redirect()->route('payment.cancel')->with('error', 'Payment cancelled.');
    }



    public function cancelGet()
    {
        return view('front.products.products-completed');
    }

    public function failedGet($id)
    {
        $statusId = OrderStatus::where('name', 'Failed')->first()->id;
        $order = Order::findOrFail($id);
        $order->update([
            'status' => 'failed',
            'payment_status' => 'failed',
            'order_status' => 'pending',
        ]);
        $order->statuses()->attach($statusId, [
            'description' => 'Order has failed.',
        ]);
        return view('front.products.products-completed');
    }
}
