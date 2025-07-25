<?php
namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Mail\Order\OrderStatusUpdatedMail;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\PaymentUpload;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class StaticPaymentController extends Controller
{
    //

    public function paymentUploadGet($id)
    {
        $order = Order::where('id', $id)->where('user_id', auth()->id())->first();
        if (! $order) {
            return redirect()->back()->with('error', 'Order not found.');
        }
        if ($order->payment_status !== 'pending' && $order->payment_status !== 'failed' && $order->payment_status !== 'processing') {
            return redirect()->route('front.orders.details', $id)->with('error', 'Payment for this order has already been processed.');
        }
        if ($order->order_status !== 'pending') {
            return redirect()->route('front.orders.details', $id)->with('error', 'Order is Completed or Cancelled. Payment cannot be processed.');
        }
        $existingPendingPayment = PaymentUpload::where('order_id', $id)
            ->where('user_id', auth()->id())
            ->where(function ($query) {
                $query->where('is_verified', 0)
                    ->orWhere(function ($subQuery) {
                        $subQuery->where('is_verified', 1)
                            ->whereIn('request_status', ['approved']);
                    });
            })
            ->first();

        if ($existingPendingPayment) {
            return redirect()->route('front.orders.details', $id)->with('error', 'A payment for this order is already under review.');
        }
        $bankDetails = [
            'account_holder_name'   => SiteSetting::getSiteSettings('account_holder_name')->value ?? '',
            'account_no' => SiteSetting::getSiteSettings('account_no')->value ?? '',
            'bsb_number'      => SiteSetting::getSiteSettings('bsb_number')->value ?? '',
            'bank_account_name'      => SiteSetting::getSiteSettings('bank_account_name')->value ?? '',
        ];
        if (! $bankDetails['account_holder_name'] || ! $bankDetails['account_no'] || ! $bankDetails['bsb_number'] || ! $bankDetails['bank_account_name']) {
            return redirect()->back()->with('error', 'Bank details are not set. Please contact support.');
        }
        return view('front.payment.process-order', compact('order','bankDetails'));
    }

    public function paymentUploadPost(Request $request, $id)
    {
        $request->validate([
            'reference_id'      => 'required|string|max:255',
            'payment_date_time' => 'required|date_format:Y-m-d\TH:i',
            'payment_method'    => 'required|string|max:100',
            'attachment'        => 'required|file|mimes:jpg,jpeg,png,pdf',
        ]);

        $order = Order::where('id', $id)->where('user_id', auth()->id())->first();
        if (! $order) {
            return redirect()->back()->with('error', 'Order not found.');
        }
        if ($order->order_status !== 'pending') {
            return redirect()->route('front.orders.details', $id)->with('error', 'Order is Completed or Cancelled. Payment cannot be processed.');
        }
        if ($order->payment_status !== 'pending' && $order->payment_status !== 'failed' && $order->payment_status !== 'processing') {
            return redirect()->route('front.orders.details', $id)->with('error', 'Payment for this order has already been processed.');
        }
        $existingPendingPayment = PaymentUpload::where('order_id', $id)
            ->where('user_id', auth()->id())
            ->where(function ($query) {
                $query->where('is_verified', 0)
                    ->orWhere(function ($subQuery) {
                        $subQuery->where('is_verified', 1)
                            ->whereIn('request_status', ['approved']);
                    });
            })
            ->first();
        if ($existingPendingPayment) {
            return redirect()->route('front.orders.details', $id)->with('error', 'A payment for this order is already under review.');
        }

        $payment                    = new PaymentUpload();
        $payment->user_id           = Auth::id();
        $payment->order_id          = $id;
        $payment->reference_id      = $request->reference_id;
        $payment->payment_date_time = $request->payment_date_time;
        $payment->payment_method    = $request->payment_method;
        $payment->sub_total         = $order->sub_total;
        $payment->shipping_charge   = $order->shipping_charge ?? 0;
        $payment->total_order       = $order->total_order;
        $payment->is_verified       = 0;
        $payment->request_status    = 'pending';

        // Handle file upload
        if ($request->hasFile('attachment')) {
            $folderPath = public_path('custom-assets/upload/front/images/payment-upload/attachment/');
            if (! file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);
            }

            $file              = $request->file('attachment');
            $imageoriginalname = str_replace(" ", "-", $file->getClientOriginalName());
            $imageName         = rand(1000, 9999) . time() . '_' . $imageoriginalname;
            $file->move($folderPath, $imageName);

            $payment->attachment_path = 'custom-assets/upload/front/images/payment-upload/attachment/' . $imageName;
        }

        $payment->save();
        $order->update([
            'payment_status' => 'processing',
        ]);
        $statusId = OrderStatus::where('key', 'payment_processing')->first()->id;
        $order->statuses()->attach($statusId, [
            'description' => 'Payment is being processed. Please wait for admin verification.',
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
        return redirect()->route('front.orders.completed', $id)->with('success', 'Payment submitted. Awaiting admin verification.');
    }
}
