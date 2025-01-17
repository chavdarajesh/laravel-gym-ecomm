<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\Facades\DataTables;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class OrderController extends Controller
{
    //
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = Order::all();
            return DataTables::of($data)
                ->addColumn('id', function ($row) {
                    return '<strong>' . $row->id . '</strong>';
                })
                ->addColumn('payment_id', function ($row) {
                    return $row->payment_id;
                })
                ->addColumn('total_order', function ($row) {
                    return $row->total_order;
                })
                ->addColumn('status', function ($row) {
                    return $row->status;
                })
                ->addColumn('actions', function ($row) {
                    $data['id'] = $row->id;
                    return View::make('admin.orders.actions', ['data' => $data])->render();
                })
                ->rawColumns(['id', 'actions', 'payment_id', 'total_order', 'status'])
                ->make(true);
        } else {
            return view('admin.orders.index');
        }
    }

    public function delete($id)
    {
        if ($id) {
            $Order = Order::find($id);
            $Order = $Order->delete();
            if ($Order) {
                return redirect()->route('admin.orders.index')->with('message', 'Order Deleted Sucssesfully..');
            } else {
                return redirect()->back()->with('error', 'Somthing Went Wrong..!');
            }
        } else {
            return redirect()->back()->with('error', 'Order Not Found..!');
        }
    }

    public function view($id)
    {
        $Order = Order::find($id);
        if ($Order) {
            $OrderStatus = OrderStatus::where('status', 1)->get();
            return view('admin.orders.view', ['Order' => $Order, 'OrderStatus' => $OrderStatus]);
        } else {
            return redirect()->back()->with('error', 'Order Not Found..!');
        }
    }


    public function updateStatus(Request $request, $id)
    {
        if ($id) {

            $request->validate([
                'status' => 'required|string|max:255'
            ]);

            $Order = Order::find($id);

            $Order->statuses()->attach($request->status, [
                'description' => $request->description,
            ]);
            $markAsCompleted = $request->input('mark_as_completed');
            if ($markAsCompleted) {
                $Order->order_status = 'completed';
                $Order->save();
            }
            if ($Order) {
                return redirect()->back()->with('message', 'Status Updated Sucssesfully..');
            } else {
                return redirect()->back()->with('error', 'Somthing Went Wrong..!');
            }
        } else {
            return redirect()->back()->with('error', 'Order Not Found..!');
        }
    }


    public function refundPayment(Request $request,$id)
    {
        $order = Order::where('id', $id)->first();
        if (!$order) {
            return redirect()->back()->with('error', 'Order not found.');
        }

        $Payment = Payment::where('order_id', $id)->where('payment_from', 'user')->where('status', 'COMPLETED')->first();
        if (!$Payment) {
            return redirect()->back()->with('error', 'Payment not found.');
        }
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        try {
            $transactionId = $Payment->capture_id;
            $amount = $request->refund ? $request->refund : $order->sub_total;
            $invoiceId = 'INVOICE_' . $id;
            $resone = 'Cancelled By Admin';

            $response = $provider->refundCapturedPayment($transactionId, $invoiceId, $amount, $resone);
            if (isset($response['status']) && $response['status'] === 'COMPLETED') {
                $order = Order::where('id', $id)->first();

                $order->update([
                    'status' => 'completed',
                    'payment_status' => 'refund',
                    'order_status' => 'refund',
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
                    'user_id' => $order->user_id,
                    'payment_method' => 'PayPal',
                    'payment_status' => 'completed',
                    'capture_id' => $transactionId ?? ''
                ];

                Payment::create($paymentData);
                return redirect()->back()->with('message', 'Refund successful.');
            } else {
                return redirect()->back()->with('error', 'Refund failed.');
            }
        } catch (\Exception $e) {
            // return redirect()->back()->with('error', $e->getMessage());
            return redirect()->back()->with('error', '"Something went wrong!.');
        }
    }
}
