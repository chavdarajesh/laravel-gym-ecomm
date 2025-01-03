<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\Facades\DataTables;

class OrderStatusController extends Controller
{
    //
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = OrderStatus::all();
            return DataTables::of($data)
                ->addColumn('id', function ($row) {
                    return '<strong>' . $row->id . '</strong>';
                })
                ->addColumn('name', function ($row) {
                    return strlen($row->name) > 25 ? substr($row->name, 0, 25) . '..' : $row->name;
                })
                ->addColumn('description', function ($row) {
                    return strlen($row->description) > 25 ? substr(strip_tags($row->description), 0, 25) . '..' : strip_tags($row->description);
                })
                ->addColumn('status', function ($row) {
                    $data['id'] = $row->id;
                    $data['status'] = $row->status;
                    return View::make('admin.orderstatus.status', ['data' => $data])->render();
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at ? Carbon::parse($row->created_at)->setTimezone('Asia/Kolkata')->toDateTimeString() : '';
                })
                ->addColumn('actions', function ($row) {
                    $data['id'] = $row->id;
                    return View::make('admin.orderstatus.actions', ['data' => $data])->render();
                })
                ->rawColumns(['id', 'actions', 'status', 'created_at', 'name','description'])
                ->make(true);
        } else {
            return view('admin.orderstatus.index');
        }
    }
    public function create()
    {
        return view('admin.orderstatus.create');
    }
    public function save(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $OrderStatus = new OrderStatus();
        $OrderStatus->name = $request['name'];
        $OrderStatus->description = $request['description'];
        $OrderStatus->status = 1;
        $OrderStatus->save();
        if ($OrderStatus) {
            return redirect()->route('admin.orderstatus.index')->with('message', 'OrderStatus Added Sucssesfully..');
        } else {
            return redirect()->back()->with('error', 'Somthing Went Wrong..');
        }
    }
    public function view($id)
    {
        $OrderStatus = OrderStatus::find($id);
        if ($OrderStatus) {
            return view('admin.orderstatus.view', ['OrderStatus' => $OrderStatus]);
        } else {
            return redirect()->back()->with('error', 'OrderStatus Not Found..!');
        }
    }

    public function edit($id)
    {
        $OrderStatus = OrderStatus::find($id);
        if ($OrderStatus) {
            return view('admin.orderstatus.edit', ['OrderStatus' => $OrderStatus]);
        } else {
            return redirect()->back()->with('error', 'OrderStatus Not Found..!');
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $OrderStatus = OrderStatus::find($request->id);
        if ($OrderStatus) {
            $OrderStatus->name = $request['name'];
            $OrderStatus->description = $request['description'];
            $OrderStatus->update();
            if ($OrderStatus) {
                return redirect()->route('admin.orderstatus.index')->with('message', 'OrderStatus Updated Sucssesfully..');
            } else {
                return redirect()->back()->with('error', 'Somthing Went Wrong..');
            }
        } else {
            return redirect()->back()->with('error', 'OrderStatus Not Found..!');
        }
    }

    public function delete($id)
    {
        if ($id) {
            $OrderStatus = OrderStatus::find($id);
            $OrderStatus = $OrderStatus->delete();
            if ($OrderStatus) {
                return redirect()->route('admin.orderstatus.index')->with('message', 'OrderStatus Deleted Sucssesfully..');
            } else {
                return redirect()->back()->with('error', 'Somthing Went Wrong..!');
            }
        } else {
            return redirect()->back()->with('error', 'OrderStatus Not Found..!');
        }
    }

    public function statusToggle(Request $request)
    {
        if ($request->id) {
            $OrderStatus = OrderStatus::find($request->id);
            $OrderStatus->status = $request->status;
            $OrderStatus = $OrderStatus->update();
            if ($OrderStatus) {
                return response()->json(['success' => 'Status Updated Successfully.']);
            } else {
                return response()->json(['error' => 'Somthing Went Wrong..!']);
            }
        } else {
            return response()->json(['error' => 'OrderStatus Not Found..!']);
        }
    }
}
