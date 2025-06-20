<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\Order\OrderStatusUpdatedMail;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\PaymentUpload;
use App\Models\ReturnRequest;
use App\Models\SiteSetting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\Facades\DataTables;

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
                ->addColumn('user', function ($row) {
                    return '<a href="' . route("admin.users.view", $row->user_id) . '">' . $row->user->name . '</a>';
                })
                ->addColumn('payment_status', function ($row) {
                    return $row->payment_status ? ucfirst($row->payment_status) : 'Pending';
                    //for completed one need to link payment upload
                })
                ->addColumn('order_status', function ($row) {
                    return $row->order_status ? ucfirst($row->order_status) : 'Pending';
                })
                ->addColumn('return_status', function ($row) {
                    return $row->return_status ? ucfirst($row->return_status) : '-';
                })
                ->addColumn('total_order', function ($row) {
                    return $row->total_order ? '$' . number_format($row->total_order, 2) : '$0.00';
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at ? Carbon::parse($row->created_at)->setTimezone('Asia/Kolkata')->toDateTimeString() : '';
                })
                ->addColumn('actions', function ($row) {
                    $data['id'] = $row->id;
                    return View::make('admin.orders.actions', ['data' => $data])->render();
                })
                ->rawColumns(['id', 'actions', 'payment_status', 'total_order', 'order_status', 'user', 'created_at'])
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
            $OrderStatus  = OrderStatus::where('status', 1)->where('admin_visible', 1)->where('type', 'order')->get();
            $ReturnStatus = OrderStatus::where('status', 1)->where('admin_visible', 1)->where('type', 'return')->get();
            return view('admin.orders.view', ['Order' => $Order, 'OrderStatus' => $OrderStatus, 'ReturnStatus' => $ReturnStatus]);
        } else {
            return redirect()->back()->with('error', 'Order Not Found..!');
        }
    }

    public function orderUpdateStatus(Request $request, $id)
    {
        if ($id) {

            $request->validate([
                'status' => 'required|string|max:255',
            ]);

            $Order = Order::find($id);

            $orderStatus = OrderStatus::where('id', $request->status)->first();

            if (! $orderStatus) {
                return redirect()->back()->with('error', 'Invalid status selected.');
            }
            if ($orderStatus->key == 'order_cancelled_by_admin') {
                if (($Order->payment_status == 'pending' || $Order->payment_status == 'failed' || $Order->payment_status == 'processing') && $Order->order_status == 'pending') {
                    $Order->update([
                        'order_status'   => 'cancelled',
                        'payment_status' => 'cancelled',
                    ]);
                    $Order->statuses()->attach($orderStatus->id, [
                        'description' => 'Order has been cancelled by the Admin.',
                    ]);

                    if (env('MAIL_USERNAME')) {
                        if ($Order->user && $Order->user->email) {
                            Mail::to($Order->user->email)->send(new OrderStatusUpdatedMail($Order));
                        }
                        $adminEmail = SiteSetting::getSiteSettings('admin_email');
                        if (isset($adminEmail) && isset($adminEmail->value) && $adminEmail != null && $adminEmail->value != '') {
                            $adminEmail = $adminEmail->value;
                        } else {
                            $adminEmail = env('ADMIN_EMAIL', '');
                        }
                        if ($adminEmail) {
                            Mail::to($adminEmail)->send(new OrderStatusUpdatedMail($Order));
                        }
                    }
                } else if ($Order->payment_status == 'completed' && $Order->order_status == 'processing') {

                    return redirect()->back()->with('error', 'Order is in processing state. You cannot cancel this order.');
                }
            } else {
                $Order->statuses()->attach($request->status, [
                    'description' => $request->description ?? '',
                ]);

                if (env('MAIL_USERNAME')) {
                        if ($Order->user && $Order->user->email) {
                            Mail::to($Order->user->email)->send(new OrderStatusUpdatedMail($Order));
                        }
                        $adminEmail = SiteSetting::getSiteSettings('admin_email');
                        if (isset($adminEmail) && isset($adminEmail->value) && $adminEmail != null && $adminEmail->value != '') {
                            $adminEmail = $adminEmail->value;
                        } else {
                            $adminEmail = env('ADMIN_EMAIL', '');
                        }
                        if ($adminEmail) {
                            Mail::to($adminEmail)->send(new OrderStatusUpdatedMail($Order));
                        }
                    }
                $markAsCompleted = $request->input('mark_as_completed');
                if ($markAsCompleted) {
                    $Order->order_status = 'delivered';
                    $Order->save();
                }
            }

            if ($Order) {
                return redirect()->back()->with('success', 'Status Updated Sucssesfully..');
            } else {
                return redirect()->back()->with('error', 'Somthing Went Wrong..!');
            }
        } else {
            return redirect()->back()->with('error', 'Order Not Found..!');
        }
    }

    public function paymentUpdateStatus(Request $request)
    {
        $request->validate([
            'payment_upload_id' => 'required|integer',
            'payment_status'    => 'required|in:approved,rejected',
            'reject_reason'     => 'nullable|string|max:255',
        ]);

        $payment = PaymentUpload::find($request->payment_upload_id);

        if (! $payment) {
            return redirect()->back()->with('error', 'Payment request not found.');
        }
        $payment->request_status = $request->payment_status;
        $payment->is_verified    = 1;
        $payment->save();

        $order = Order::find($payment->order_id);
        if ($order) {
            if ($request->payment_status === 'approved') {
                $order->payment_status = 'completed';
                $order->order_status   = 'processing';
                $order->payment_id     = $payment->id;
                $statusId              = OrderStatus::where('key', 'payment_completed')->first()->id;
                $order->statuses()->attach($statusId, [
                    'description' => 'Payment has been approved.',
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
                $statusId = OrderStatus::where('key', 'order_placed')->first()->id;
                $order->statuses()->attach($statusId, [
                    'description' => 'Order has been placed.',
                    'created_at'  => Carbon::now()->addSeconds(5),
                    'updated_at'  => Carbon::now()->addSeconds(5),
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

            } else {
                $order->payment_status = 'failed';
                $order->order_status   = 'pending';

                $statusId = OrderStatus::where('key', 'payment_failed')->first()->id;
                $order->statuses()->attach($statusId, [
                    'description' => $request->reject_reason ?? 'Payment request was rejected.',
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
                    'description' => 'Please Process Payment again.',
                    'created_at'  => Carbon::now()->addSeconds(5),
                    'updated_at'  => Carbon::now()->addSeconds(5),
                ]);
            }
            $order->save();
        }

        return redirect()->back()->with('success', 'Payment request updated successfully.');
    }

    public function returnUpdateStatus(Request $request)
    {
        $request->validate([
            'return_request_id'    => 'required|integer|exists:return_requests,id',
            'return_status'        => 'required|in:approved,rejected',
            'return_reject_reason' => 'nullable|string|max:255',
        ]);

        $returnRequest = ReturnRequest::find($request->return_request_id);
        if (! $returnRequest) {
            return redirect()->back()->with('error', 'Return request not found.');
        }
        $returnRequest->request_status = $request->return_status;
        $returnRequest->is_verified    = 1;
        $returnRequest->save();

        // Optionally update order status/history
        $order = $returnRequest->order;
        if ($order) {
            if ($request->return_status === 'approved') {
                $order->return_status = 'approved';
                $statusId             = OrderStatus::where('key', 'order_returned')->first()->id ?? null;
                if ($statusId) {
                    $order->statuses()->attach($statusId, [
                        'description' => 'Return request approved by admin.',
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
                }

                $statusId = OrderStatus::where('key', 'refund_processing')->first()->id ?? null;
                if ($statusId) {
                    $order->statuses()->attach($statusId, [
                        'description' => 'Refund is being processed.',
                        'created_at'  => Carbon::now()->addSeconds(5),
                        'updated_at'  => Carbon::now()->addSeconds(5),
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
                }
            } else {
                $order->return_status = 'rejected';
                $statusId             = OrderStatus::where('key', 'return_rejected')->first()->id ?? null;
                if ($statusId) {
                    $order->statuses()->attach($statusId, [
                        'description' => $request->return_reject_reason ?: 'Return request rejected by admin.',
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
                }
            }
            $order->save();
        }

        return back()->with('success', 'Return request status updated successfully.');
    }

    public function updateRefundStatus(Request $request, $id)
    {
        if ($id) {
            $request->validate([
                'refund_status'      => 'required',
                'refund_description' => 'nullable|string|max:1000',
            ]);

            $Order = Order::find($id);

            // $statusId = OrderStatus::where('name', 'Order Refunded')->first()->id ?? null;
            $Order->statuses()->attach($request->refund_status, [
                'description' => $request->refund_description ? $request->refund_description : 'Order has been refunded.',
            ]);

            if (env('MAIL_USERNAME')) {
                        if ($Order->user && $Order->user->email) {
                            Mail::to($Order->user->email)->send(new OrderStatusUpdatedMail($Order));
                        }
                        $adminEmail = SiteSetting::getSiteSettings('admin_email');
                        if (isset($adminEmail) && isset($adminEmail->value) && $adminEmail != null && $adminEmail->value != '') {
                            $adminEmail = $adminEmail->value;
                        } else {
                            $adminEmail = env('ADMIN_EMAIL', '');
                        }
                        if ($adminEmail) {
                            Mail::to($adminEmail)->send(new OrderStatusUpdatedMail($Order));
                        }
                    }
            $Order->return_status = 'refunded';
            $Order->save();

            if ($Order) {
                return redirect()->back()->with('message', 'Status Updated Successfully..');
            } else {
                return redirect()->back()->with('error', 'Something Went Wrong..!');
            }
        } else {
            return redirect()->back()->with('error', 'Order Not Found..!');
        }
    }
}
