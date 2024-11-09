<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Flavor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\Facades\DataTables;

class FlavorController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Flavor::all();
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
                    return View::make('admin.flavors.status', ['data' => $data])->render();
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at ? Carbon::parse($row->created_at)->setTimezone('Asia/Kolkata')->toDateTimeString() : '';
                })
                ->addColumn('actions', function ($row) {
                    $data['id'] = $row->id;
                    return View::make('admin.flavors.actions', ['data' => $data])->render();
                })
                ->rawColumns(['id', 'actions', 'status', 'created_at', 'name'])
                ->make(true);
        } else {
            return view('admin.flavors.index');
        }
    }
    public function create()
    {
        return view('admin.flavors.create');
    }
    public function save(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $Flavor = new Flavor();
        $Flavor->name = $request['name'];
        $Flavor->status = 1;
        $Flavor->save();
        if ($Flavor) {
            return redirect()->route('admin.flavors.index')->with('message', 'Flavor Added Sucssesfully..');
        } else {
            return redirect()->back()->with('error', 'Somthing Went Wrong..');
        }
    }
    public function view($id)
    {
        $Flavor = Flavor::find($id);
        if ($Flavor) {
            return view('admin.flavors.view', ['Flavor' => $Flavor]);
        } else {
            return redirect()->back()->with('error', 'Flavor Not Found..!');
        }
    }

    public function edit($id)
    {
        $Flavor = Flavor::find($id);
        if ($Flavor) {
            return view('admin.flavors.edit', ['Flavor' => $Flavor]);
        } else {
            return redirect()->back()->with('error', 'Flavor Not Found..!');
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $Flavor = Flavor::find($request->id);
        if ($Flavor) {
            $Flavor->name = $request['name'];
            $Flavor->update();
            if ($Flavor) {
                return redirect()->route('admin.flavors.index')->with('message', 'Flavor Updated Sucssesfully..');
            } else {
                return redirect()->back()->with('error', 'Somthing Went Wrong..');
            }
        } else {
            return redirect()->back()->with('error', 'Flavor Not Found..!');
        }
    }

    public function delete($id)
    {
        if ($id) {
            $Flavor = Flavor::find($id);
            $Flavor = $Flavor->delete();
            if ($Flavor) {
                return redirect()->route('admin.flavors.index')->with('message', 'Flavor Deleted Sucssesfully..');
            } else {
                return redirect()->back()->with('error', 'Somthing Went Wrong..!');
            }
        } else {
            return redirect()->back()->with('error', 'Flavor Not Found..!');
        }
    }

    public function statusToggle(Request $request)
    {
        if ($request->id) {
            $Flavor = Flavor::find($request->id);
            $Flavor->status = $request->status;
            $Flavor = $Flavor->update();
            if ($Flavor) {
                return response()->json(['success' => 'Status Updated Successfully.']);
            } else {
                return response()->json(['error' => 'Somthing Went Wrong..!']);
            }
        } else {
            return response()->json(['error' => 'Flavor Not Found..!']);
        }
    }
}
