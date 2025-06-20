<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentUpload;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\Facades\DataTables;

class PaymentUploadController extends Controller
{
    //
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = PaymentUpload::with(['user', 'order'])->get();

            return DataTables::of($data)
             ->addColumn('id', function ($row) {
                    return '<strong>' . $row->id . '</strong>';
                })
                ->addColumn('user_id', function ($row) {
                    return '<a target="_blank" href="' . route("admin.users.view", $row->user_id) . '">' . $row->user->name . '</a>';
                })
                ->addColumn('order_id', function ($row) {
                    return '<a target="_blank" href="' . route("admin.orders.view", $row->order_id) . '">' . $row->order_id . '</a>';
                })
                ->addColumn('reference_id', function ($row) {
                    return '<strong>' . $row->reference_id . '</strong>';
                })
                ->addColumn('payment_date_time', function ($row) {
                    return $row->payment_date_time 
                        ? Carbon::parse($row->payment_date_time)->setTimezone('Asia/Kolkata')->toDateTimeString() 
                        : '-';
                })
                ->addColumn('is_verified', function ($row) {
                    return $row->is_verified ? '<span class="badge bg-success">Verified</span>' : '<span class="badge bg-secondary">Pending</span>';
                })
                ->addColumn('request_status', function ($row) {
                    return $row->request_status ? ucfirst($row->request_status) : '-';
                })
                ->addColumn('total_order', function ($row) {
                    return $row->total_order ? '$' . number_format($row->total_order, 2) : '$0.00';
                })
                ->addColumn('actions', function ($row) {
                    $data['id'] = $row->id;
                    return View::make('admin.payment_uploads.actions', ['data' => $data])->render();
                })
                ->rawColumns(['id', 'user_id', 'order_id', 'reference_id', 'is_verified', 'total_order', 'actions'])
                ->make(true);
        } else {
            return view('admin.payment_uploads.index');
        }
    }

    public function delete($id)
    {
        $payment = PaymentUpload::find($id);
        if ($payment) {
            $payment->delete();
            return redirect()->route('admin.payment_uploads.index')->with('message', 'Payment Upload deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'Payment Upload not found.');
        }
    }

    public function view($id)
    {
        $payment = PaymentUpload::with(['user', 'order'])->find($id);
        if ($payment) {
            return view('admin.payment_uploads.view', compact('payment'));
        } else {
            return redirect()->back()->with('error', 'Payment Upload not found.');
        }
    }
}
