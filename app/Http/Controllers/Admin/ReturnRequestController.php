<?php

namespace App\Http\Controllers\Admin;

use App\Models\ReturnRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;

class ReturnRequestController extends Controller
{
    //
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = ReturnRequest::with(['user', 'order'])->get();

            return DataTables::of($data)
                ->addColumn('id', fn($row) => '<strong>' . $row->id . '</strong>')
                ->addColumn('user_id', fn($row) => '<a target="_blank" href="' . route("admin.users.view", $row->user_id) . '">' . $row->user->name . '</a>')
                ->addColumn('order_id', fn($row) => '<a target="_blank" href="' . route("admin.orders.view", $row->order_id) . '">' . $row->order_id . '</a>')
                ->addColumn('reference_id', fn($row) => $row->reference_id)
                ->addColumn('return_date_time', fn($row) => Carbon::parse($row->return_date_time)->setTimezone('Asia/Kolkata')->toDateTimeString())
                ->addColumn('is_verified', fn($row) => $row->is_verified ? '<span class="badge bg-success">Verified</span>' : '<span class="badge bg-secondary">Pending</span>')
                ->addColumn('request_status', fn($row) => ucfirst($row->request_status ?? '-'))
                ->addColumn('total_order', fn($row) => '$' . number_format($row->total_order, 2))
                ->addColumn('actions', fn($row) => View::make('admin.return_requests.actions', ['data' => ['id' => $row->id]])->render())
                ->rawColumns(['id', 'user_id', 'order_id', 'is_verified', 'total_order', 'actions'])
                ->make(true);
        }

        return view('admin.return_requests.index');
    }

    public function view($id)
    {
        $return = ReturnRequest::with(['user', 'order'])->find($id);
        if (!$return) {
            return redirect()->back()->with('error', 'Return request not found.');
        }

        return view('admin.return_requests.view', compact('return'));
    }

    public function delete($id)
    {
        $return = ReturnRequest::find($id);
        if ($return) {
            $return->delete();
            return redirect()->route('admin.return_requests.index')->with('message', 'Return request deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'Return request not found.');
        }
    }
}
