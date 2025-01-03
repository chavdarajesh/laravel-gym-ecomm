<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;


class PaymentController extends Controller
{
    //

    public function process($orderId)
    {
        $order = Order::findOrFail($orderId);

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $order->total_price,
                    ],
                ],
            ],
        ]);

        if (isset($response['id'])) {
            // Store the PayPal order ID for reference
            $order->update(['payment_id' => $response['id']]);
            return redirect($response['links'][1]['href']);
        }

        return redirect()->back()->with('error', 'Unable to process payment.');
    }

    public function success(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        $response = $provider->capturePaymentOrder($request->query('token'));

        if ($response['status'] === 'COMPLETED') {
            // Update order and payment status
            $order = Order::where('payment_id', $response['id'])->first();
            $order->update(['status' => 'completed']);

            Payment::create([
                'transaction_id' => $response['id'],
                'amount' => $order->total_price,
                'payment_method' => 'PayPal',
                'payment_status' => 'Completed',
            ]);

            return redirect()->route('payment.success')->with('success', 'Payment successful!');
        }

        return redirect()->route('payment.failed')->with('error', 'Payment failed.');
    }

    public function cancel()
    {
        return redirect('/orders')->with('error', 'Payment cancelled.');
    }

    public function failed()
    {
        return redirect('/orders')->with('error', 'Payment failed.');
    }
}
