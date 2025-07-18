<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use PayPal\Api\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use PayPal\Api\Amount;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Refund;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PayPalController extends Controller
{

    private $_api_context;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        /** setup PayPal api context **/
        // $paypal_conf = config('paypal');
        // $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_conf['client_id'], $paypal_conf['secret']));
        // $this->_api_context->setConfig($paypal_conf['settings']);
    }


    public function payWithPaypal()
    {
        return view('front.paywithpaypal');
    }

    /**
     * Store a details of payment with paypal.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function postPaymentWithpaypal(Request $request)
    {

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
                        "value" => $request->get('amount')
                    ]
                ]
            ]
        ]);
        print_r($response);
        exit;
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
        // $payer = new Payer();
        // $payer->setPaymentMethod('paypal');

        // $item_1 = new Item();

        // $item_1->setName('Test 1')
        //     /** item name **/
        //     ->setCurrency('USD')
        //     ->setQuantity(1)
        //     ->setPrice($request->get('amount'));
        // /** unit price **/

        // $item_list = new ItemList();
        // $item_list->setItems(array($item_1));

        // $amount = new Amount();
        // $amount->setCurrency('USD')
        //     ->setTotal($request->get('amount'));

        // $transaction = new Transaction();
        // $transaction->setAmount($amount)
        //     ->setItemList($item_list)
        //     ->setDescription('Your transaction description');

        // $redirect_urls = new RedirectUrls();
        // $redirect_urls->setReturnUrl(URL::route('payment.status'))
        //     /** Specify return URL **/
        //     ->setCancelUrl(URL::route('payment.status'));

        // $payment = new Payment();
        // $payment->setIntent('Sale')
        //     ->setPayer($payer)
        //     ->setRedirectUrls($redirect_urls)
        //     ->setTransactions(array($transaction));
        // /** dd($payment->create($this->_api_context));exit; **/
        // try {
        //     $payment->create($this->_api_context);
        // } catch (\PayPal\Exception\PPConnectionException $ex) {
        //     if (config('app.debug')) {
        //         return redirect()->back()->with('error', 'Payment failed.');
        //         /** echo "Exception: " . $ex->getMessage() . PHP_EOL; **/
        //         /** $err_data = json_decode($ex->getData(), true); **/
        //         /** exit; **/
        //     } else {
        //         return redirect()->back()->with('error', 'Some error occur, sorry for inconvenient.');
        //         /** die('Some error occur, sorry for inconvenient'); **/
        //     }
        // }

        // foreach ($payment->getLinks() as $link) {
        //     if ($link->getRel() == 'approval_url') {
        //         $redirect_url = $link->getHref();
        //         break;
        //     }
        // }

        // /** add payment ID to session **/
        // Session::put('paypal_payment_id', $payment->getId());

        // if (isset($redirect_url)) {
        //     /** redirect to paypal **/
        //     return redirect()->away($redirect_url);
        // }
        // return redirect()->back()->with('error', 'Unknown error occurred.');
    }

    public function getPaymentStatus(Request $request)
    {
        echo '----';
        /** Get the payment ID before session clear **/
        $payment_id = Session::get('paypal_payment_id');

        echo '----'.$payment_id.'=====';
        /** clear the session payment ID **/
        if (empty($request->get('PayerID')) || empty($request->get('token'))) {
            return redirect()->back()->with('error', 'Payment failed.');
        }
        $payment = Payment::get($payment_id, $this->_api_context);
        /** PaymentExecution object includes information necessary **/
        /** to execute a PayPal account payment. **/
        /** The payer_id is added to the request query parameters **/
        /** when the user is redirected from paypal back to your site **/
        $execution = new PaymentExecution();
        $execution->setPayerId($request->get('PayerID'));
        /**Execute the payment **/
        $result = $payment->execute($execution, $this->_api_context);
        /** dd($result);exit; /** DEBUG RESULT, remove it later **/
        if ($result->getState() == 'approved') {
            print_r($result);
            exit;
            /** it's all right **/
            /** Here Write your database logic like that insert record or value in database if you want **/
            return redirect()->back()->with('success', 'Payment successful!');
        }
        Session::forget('paypal_payment_id');
        return redirect()->back()->with('error', 'Payment failed.');
    }

    public function refund($tran_id)
    {
        $paypal_conf = config('paypal');

        $paymentPayment = new Payment();
        $paymentInfo = $paymentPayment->get($tran_id, $this->_api_context);

        $transaction = $paymentInfo->getTransactions();

        if (empty($transaction[0])) {
            return false;
        }

        $relatedResource = $transaction[0]->getRelatedResources();
        if (empty($relatedResource[0])) {
            return false;
        }

        $sale = $relatedResource[0]->getSale();

        $refund = new Refund();
        $amt = (new Amount())->setTotal(50)->setCurrency('USD');
        $refund->setAmount($amt);
        $refund->setReason('Sale refund');

        $refundSuccess  = $sale->refund($refund, $this->_api_context);

        print_r($refundSuccess);
        exit;
        if ($refundSuccess->getState() == 'approved') {
            return redirect()->back()->with('success', 'Refund Success!');
        }
    }
}
