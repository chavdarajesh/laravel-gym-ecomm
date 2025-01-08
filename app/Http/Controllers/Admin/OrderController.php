<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Http\Request;
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
}
