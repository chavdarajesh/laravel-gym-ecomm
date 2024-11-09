<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Size;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\Facades\DataTables;

class SizeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Size::all();
            return DataTables::of($data)
                ->addColumn('id', function ($row) {
                    return '<strong>' . $row->id . '</strong>';
                })
                ->addColumn('name', function ($row) {
                    return strlen($row->name) > 25 ? substr($row->name, 0, 25) . '..' : $row->name;
                })
                ->addColumn('status', function ($row) {
                    $data['id'] = $row->id;
                    $data['status'] = $row->status;
                    return View::make('admin.sizes.status', ['data' => $data])->render();
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at ? Carbon::parse($row->created_at)->setTimezone('Asia/Kolkata')->toDateTimeString() : '';
                })
                ->addColumn('actions', function ($row) {
                    $data['id'] = $row->id;
                    return View::make('admin.sizes.actions', ['data' => $data])->render();
                })
                ->rawColumns(['id', 'actions', 'status', 'created_at', 'name'])
                ->make(true);
        } else {
            return view('admin.sizes.index');
        }
    }
    public function create()
    {
        return view('admin.sizes.create');
    }
    public function save(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $Size = new Size();
        $Size->name = $request['name'];
        $Size->status = 1;
        $Size->save();
        if ($Size) {
            return redirect()->route('admin.sizes.index')->with('message', 'Size Added Sucssesfully..');
        } else {
            return redirect()->back()->with('error', 'Somthing Went Wrong..');
        }
    }
    public function view($id)
    {
        $Size = Size::find($id);
        if ($Size) {
            return view('admin.sizes.view', ['Size' => $Size]);
        } else {
            return redirect()->back()->with('error', 'Size Not Found..!');
        }
    }

    public function edit($id)
    {
        $Size = Size::find($id);
        if ($Size) {
            return view('admin.sizes.edit', ['Size' => $Size]);
        } else {
            return redirect()->back()->with('error', 'Size Not Found..!');
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $Size = Size::find($request->id);
        if ($Size) {
            $Size->name = $request['name'];
            $Size->update();
            if ($Size) {
                return redirect()->route('admin.sizes.index')->with('message', 'Size Updated Sucssesfully..');
            } else {
                return redirect()->back()->with('error', 'Somthing Went Wrong..');
            }
        } else {
            return redirect()->back()->with('error', 'Size Not Found..!');
        }
    }

    public function delete($id)
    {
        if ($id) {
            $Size = Size::find($id);
            $Size = $Size->delete();
            if ($Size) {
                return redirect()->route('admin.sizes.index')->with('message', 'Size Deleted Sucssesfully..');
            } else {
                return redirect()->back()->with('error', 'Somthing Went Wrong..!');
            }
        } else {
            return redirect()->back()->with('error', 'Size Not Found..!');
        }
    }

    public function statusToggle(Request $request)
    {
        if ($request->id) {
            $Size = Size::find($request->id);
            $Size->status = $request->status;
            $Size = $Size->update();
            if ($Size) {
                return response()->json(['success' => 'Status Updated Successfully.']);
            } else {
                return response()->json(['error' => 'Somthing Went Wrong..!']);
            }
        } else {
            return response()->json(['error' => 'Size Not Found..!']);
        }
    }
}
