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
        $order = Order::where('id', $id)->where('user_id', auth()->id())->first();
        if (!$order) {
            return redirect()->back()->with('error', 'Order not found.');
        }

        if ($order->status === 'completed') {
            return redirect()->route('front.orders.details', $order->id)->with('success', 'Payment successful!');
        }

        $order->update([
            'status' => 'pending',
            'payment_status' => 'pending',
            'order_status' => 'pending',
        ]);

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('payment.success.redirect'),
                "cancel_url" => route('payment.cancel.redirect'),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $order->total_order
                    ]
                ]
            ]
        ]);
        if (isset($response['id']) && $response['id'] != null) {
            // redirect to approve href
            $order->update(['payment_id' => $response['id']]);
            $order->update(['payment_token' => $paypalToken]);
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return redirect()->away($links['href']);
                }
            }

            $order->update([
                'status' => 'failed',
                'payment_status' => 'failed',
                'order_status' => 'pending',
            ]);
            $statusId = OrderStatus::where('name', 'Payment Failed')->first()->id;
            $order->statuses()->attach($statusId, [
                'description' => 'Payment has failed.',
            ]);
            return redirect()->route('payment.failed',['id'=>$order->id])->with('error', 'Payment failed.');
        } else {
            $order->update([
                'status' => 'failed',
                'payment_status' => 'failed',
                'order_status' => 'pending',
            ]);
            $statusId = OrderStatus::where('name', 'Payment Failed')->first()->id;
            $order->statuses()->attach($statusId, [
                'description' => 'Payment has failed.',
            ]);
            return redirect()->route('payment.failed',['id'=>$order->id])->with('error', 'Payment failed.');
        }

        $order->update([
            'status' => 'failed',
            'payment_status' => 'failed',
            'order_status' => 'pending',
        ]);
        $statusId = OrderStatus::where('name', 'Payment Failed')->first()->id;
        $order->statuses()->attach($statusId, [
            'description' => 'Payment has failed.',
        ]);
        return redirect()->route('payment.failed',['id'=>$order->id])->with('error', 'Payment failed.');
    }

    public function successRedirect(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        $response = $provider->capturePaymentOrder($request->query('token'));

        if (!isset($response['id'])) {
            return redirect()->route('payment.cancel')->with('error', 'Payment failed.');
        }
        $order = Order::where('payment_id', $response['id'])->where('user_id', auth()->id())->first();
        if (!$order) {
            return redirect()->route('payment.cancel')->with('error', 'Payment failed.');
        }
        if ($response && $response['status'] === 'COMPLETED') {

            $order->update([
                'status' => 'completed',
                'payment_status' => 'completed',
                'order_status' => 'pending',
            ]);
            $statusId = OrderStatus::where('name', 'Payment Completed')->first()->id;
            $order->statuses()->attach($statusId, [
                'description' => 'Payment has been completed.',
            ]);

            $statusId = OrderStatus::where('name', 'Pending')->first()->id;
            $order->statuses()->attach($statusId, [
                'description' => 'Order has been placed but not yet processed.',
            ]);

            $paymentData = [
                'order_id' => $order->id,
                'status' => $response['status'],
                'payment_from' => 'user',
                'payer_email' => $response['payer']['email_address'],
                'payer_name' => $response['payer']['name']['given_name'] . ' ' . $response['payer']['name']['surname'],
                'payer_id' => $response['payer']['payer_id'],
                'business_name' => $response['payment_source']['paypal']['business_name'] ?? null,
                'account_id' => $response['payment_source']['paypal']['account_id'] ?? null,
                'shipping_name' => $response['purchase_units'][0]['shipping']['name']['full_name'],
                'shipping_address' => implode(', ', array_filter([
                    $response['purchase_units'][0]['shipping']['address']['address_line_1'] ?? '',
                    $response['purchase_units'][0]['shipping']['address']['address_line_2'] ?? '',
                    $response['purchase_units'][0]['shipping']['address']['admin_area_2'] ?? '',
                    $response['purchase_units'][0]['shipping']['address']['admin_area_1'] ?? '',
                    $response['purchase_units'][0]['shipping']['address']['postal_code'] ?? '',
                    $response['purchase_units'][0]['shipping']['address']['country_code'] ?? ''
                ])),
                'currency_code' => $response['purchase_units'][0]['payments']['captures'][0]['amount']['currency_code'],
                'amount' => $response['purchase_units'][0]['payments']['captures'][0]['amount']['value'],
                'paypal_fee' => $response['purchase_units'][0]['payments']['captures'][0]['seller_receivable_breakdown']['paypal_fee']['value'],
                'net_amount' => $response['purchase_units'][0]['payments']['captures'][0]['seller_receivable_breakdown']['net_amount']['value'],
                'exchange_rate' => $response['purchase_units'][0]['payments']['captures'][0]['seller_receivable_breakdown']['exchange_rate']['value'] ?? null,
                'payment_id' => $response['id'],
                'user_id' => auth()->id(),
                'payment_method' => 'PayPal',
                'payment_status' => 'completed',
                'payment_token' => $order->payment_token,
                'total_order' => $order->total_order,
                'sub_total' => $order->sub_total,
                'shipping_charge' => $order->shipping_charge,
                'capture_id' => $response['purchase_units'][0]['payments']['captures'][0]['id'] ?? ''
            ];

            Payment::create($paymentData);

            return redirect()->route('front.orders.completed', $order->id)->with('success', 'Payment successful!');
        }
        return redirect()->route('payment.failed',$order->id)->with('error', 'Payment failed.');
    }

    public function cancelRedirect(Request $request)
    {
        return redirect()->route('payment.cancel')->with('error', 'Payment cancelled.');
    }

    public function cancelGet()
    {
        return redirect()->route('front.orders')->with('error', 'Payment cancelled.');
    }

    public function failedGet($id)
    {
        return redirect()->route('front.orders.details',$id)->with('error', 'Payment failed.');
    }

    public function refundPayment($id)
    {
        $order = Order::where('id', $id)->where('user_id', auth()->id())->first();
        if (!$order) {
            return redirect()->back()->with('error', 'Order not found.');
        }

        if ($order->order_status == 'completed' || $order->order_status == 'canceled' || $order->order_status == 'refund') {
            return redirect()->back()->with('error', '"Something went wrong!.');
        }


        $Payment = Payment::where('order_id', $id)->where('payment_from', 'user')->where('status', 'COMPLETED')->where('user_id', auth()->id())->first();
        if (!$Payment) {
            return redirect()->back()->with('error', 'Payment not found.');
        }
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();



        try {
            $transactionId = $Payment->capture_id;
            $amount = $order->sub_total;
            $invoiceId = 'INVOICE_' . $id;
            $resone = 'Cancelled By User';

            $response = $provider->refundCapturedPayment($transactionId, $invoiceId, $amount, $resone);
            if (isset($response['status']) && $response['status'] === 'COMPLETED') {
                $order = Order::where('id', $id)->where('user_id', auth()->id())->first();

                $order->update([
                    'status' => 'completed',
                    'payment_status' => 'refund',
                    'order_status' => 'refund',
                ]);

                $statusId = OrderStatus::where('name', 'Cancelled By User')->first()->id;
                $order->statuses()->attach($statusId, [
                    'description' => 'Order has been canceled by the user.',
                ]);


                $statusId = OrderStatus::where('name', 'Refunded')->first()->id;
                $order->statuses()->attach($statusId, [
                    'description' => 'Order has been refunded.',
                ]);


                $paymentData = [
                    'order_id' => $order->id,
                    'status' => $response['status'],
                    'payment_from' => 'store',
                    'total_order' => $amount,
                    'sub_total' => $amount,
                    'shipping_charge' => 0,
                    'paypal_fee' => 0,
                    'net_amount' => $amount,
                    'payment_id' => $response['id'],
                    'user_id' => auth()->id(),
                    'payment_method' => 'PayPal',
                    'payment_status' => 'completed',
                    'capture_id' => $transactionId ?? ''
                ];

                Payment::create($paymentData);

                return redirect()->route('front.orders')->with('message', 'Refund successful.');
            } else {
                return redirect()->back()->with('error', 'Refund failed.');
            }
        } catch (\Exception $e) {
            // return redirect()->back()->with('error', $e->getMessage());
            return redirect()->back()->with('error', '"Something went wrong!.');
        }
    }
}
