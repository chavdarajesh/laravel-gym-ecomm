<?php
namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Mail\Order\OrderStatusUpdatedMail;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\ReturnRequest;
use App\Models\ReturnRequestProduct;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ReturnRequestController extends Controller
{
    //
    public function returnRequestPost(Request $request, $id)
    {
        $request->validate([
            'reference_id'        => 'required|string|max:255',
            'product_ids'         => 'required|array|min:1',
            'product_ids.*'       => 'exists:products,id',
            'photo_proof'         => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'return_date_time'    => 'required|date_format:Y-m-d\TH:i',
            'bank_account_name'   => 'required|string|max:100',
            'bsb_number'          => 'required|string|max:20',
            'account_no'          => 'required|string|confirmed',
            'account_holder_name' => 'required|string|max:255',
        ]);

        $order = Order::with(['products'])->where('id', $id)->where('user_id', auth()->id())->first();

        if (! $order) {
            return redirect()->back()->with('error', 'Order not found.');
        }

        if ($order->order_status !== 'delivered') {
            return redirect()->route('front.orders.details', $id)->with('error', 'Only delivered orders can be returned.');
        }

        $existingReturn = ReturnRequest::where('order_id', $id)
            ->where('user_id', auth()->id())
            ->where(function ($query) {
                $query->where('is_verified', 0)
                    ->orWhere('request_status', 'approved');
            })
            ->first();

        if ($existingReturn) {
            return redirect()->route('front.orders.details', $id)->with('error', 'A return request for this order is already under review.');
        }

        $returnAddress = SiteSetting::getSiteSettings('return_address');
        if (isset($returnAddress) && isset($returnAddress->value) && $returnAddress != null && $returnAddress->value != '') {
            $returnAddress = $returnAddress->value;
        } else {
            $returnAddress = '';
        }

        if (! $returnAddress) {
            return redirect()->back()->with('error', 'Return address is not set. Please contact support.');
        }

        $returnRequest                      = new ReturnRequest();
        $returnRequest->order_id            = $order->id;
        $returnRequest->user_id             = auth()->id();
        $returnRequest->reference_id        = $request->reference_id;
        $returnRequest->return_date_time    = $request->return_date_time;
        $returnRequest->bank_account_name   = $request->bank_account_name;
        $returnRequest->bsb_number          = $request->bsb_number;
        $returnRequest->account_no          = $request->account_no;
        $returnRequest->account_holder_name = $request->account_holder_name;
        $returnRequest->is_verified         = 0;
        $returnRequest->request_status      = 'pending';
        $returnRequest->sub_total           = 0;
        $returnRequest->shipping_charge     = 0;
        $returnRequest->total_order         = 0;
        $returnRequest->return_reason       = $request->return_reason ?? '';
        $returnRequest->return_address      = $returnAddress ?? '';
        if ($request->hasFile('photo_proof')) {
            $folderPath = public_path('custom-assets/upload/front/images/return-proofs/');
            if (! file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);
            }
            $file         = $request->file('photo_proof');
            $originalName = str_replace(" ", "-", $file->getClientOriginalName());
            $fileName     = rand(1000, 9999) . time() . '_' . $originalName;
            $file->move($folderPath, $fileName);
            $photoPath                  = 'custom-assets/upload/front/images/return-proofs/' . $fileName;
            $returnRequest->photo_proof = $photoPath;
        }
        $returnRequest->save();

        $sub_total = 0;
        foreach ($request->product_ids as $productId) {
            $orderProduct = $order->products->where('id', $productId)->first();

            if ($orderProduct) {
                $quantity    = $orderProduct->pivot->quantity ?? 1;
                $price       = $orderProduct->pivot->price ?? $orderProduct->price ?? 0;
                $size_id     = $orderProduct->pivot->size_id ?? null;
                $flavor_id   = $orderProduct->pivot->flavor_id ?? null;
                $total_price = $quantity * $price;

                $sub_total += $total_price;

                ReturnRequestProduct::create([
                    'return_request_id' => $returnRequest->id,
                    'order_id'          => $order->id,
                    'user_id'           => auth()->id(),
                    'product_id'        => $productId,
                    'quantity'          => $quantity,
                    'price'             => $price,
                    'total_price'       => $total_price,
                    'size_id'           => $size_id,
                    'flavor_id'         => $flavor_id,
                ]);
            }
        }

        $returnRequest->update([
            'sub_total'   => $sub_total,
            'total_order' => $sub_total,
        ]);

        $order->return_status = 'requested';
        $order->save();
        $statusId = OrderStatus::where('key', 'return_requested')->first()->id;
        $order->statuses()->attach($statusId, [
            'description' => 'User requested return. Awaiting admin verification.',
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
        return redirect()->back()->with('success', 'Return request submitted. Awaiting admin verification.');

    }
}
