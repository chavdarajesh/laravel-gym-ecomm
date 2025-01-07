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
            return redirect()->route('front.products-completed', $order->id)->with('success', 'Payment successful!');
        }

        $order->update([
            'status' => 'pending',
            'payment_status' => 'pending',
            'order_status' => 'pending',
        ]);

        // $provider = new PayPalClient;
        // $provider->setApiCredentials(config('paypal'));
        // $provider->getAccessToken();

        // $response = $provider->createOrder([
        //     "intent" => "CAPTURE",
        //     "purchase_units" => [
        //         [
        //             "amount" => [
        //                 "currency_code" => "USD",
        //                 "value" => $order->total_order,
        //             ],
        //         ],
        //     ],
        // ]);

        // if (isset($response['id'])) {
        //     $order->update(['payment_id' => $response['id']]);
        //     return redirect($response['links'][1]['href']);
        // }

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
        // print_r($response);
        // exit;
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
            return redirect()->route('payment.failed',)->with('error', 'Payment failed.');
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
            return redirect()->route('payment.failed',)->with('error', 'Payment failed.');
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
        return redirect()->route('payment.failed',)->with('error', 'Payment failed.');
    }

    public function successRedirect(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        $response = $provider->capturePaymentOrder($request->query('token'));

        if (!isset($response['id'])) {
            return redirect()->route('payment.failed',)->with('error', 'Payment failed.');
        }
        $order = Order::where('payment_id', $response['id'])->where('user_id', auth()->id())->first();
        if (!$order) {
            return redirect()->route('payment.failed',)->with('error', 'Payment failed.');
        }
        if ($response['status'] === 'COMPLETED') {

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
            ];

            Payment::create($paymentData);

            return redirect()->route('front.products-completed', $order->id)->with('success', 'Payment successful!');
        }
        return redirect()->route('payment.failed')->with('error', 'Payment failed.');
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
        return view('front.products.products-completed');
    }
}
