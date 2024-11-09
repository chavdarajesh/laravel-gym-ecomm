<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subcategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\Facades\DataTables;

class SubCategoryController extends Controller
{
    //

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Subcategory::all();
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
                    return View::make('admin.subcategorys.status', ['data' => $data])->render();
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at ? Carbon::parse($row->created_at)->setTimezone('Asia/Kolkata')->toDateTimeString() : '';
                })
                ->addColumn('actions', function ($row) {
                    $data['id'] = $row->id;
                    return View::make('admin.subcategorys.actions', ['data' => $data])->render();
                })
                ->rawColumns(['id', 'actions', 'status', 'created_at', 'name', 'description'])
                ->make(true);
        } else {
            return view('admin.subcategorys.index');
        }
    }
    public function create()
    {
        return view('admin.subcategorys.create');
    }
    public function save(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'image' => 'required|file|image|mimes:jpeg,png,jpg,gif|max:5000',
        ]);
        $Subcategory = new Subcategory();
        $Subcategory->name = $request['name'];
        $Subcategory->description = $request['description'];
        $Subcategory->status = 1;
        if ($request->image) {
            if ($request->old_image && file_exists(public_path($request->old_image))) {
                unlink(public_path($request->old_image));
            }
            $folderPath = public_path('custom-assets/upload/admin/images/subcategorys/images/');
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);
            }
            $file = $request->file('image');
            $imageoriginalname = str_replace(" ", "-", $file->getClientOriginalName());
            $imageName = rand(1000, 9999) . time() . $imageoriginalname;
            $file->move($folderPath, $imageName);
            $Subcategory->image = 'custom-assets/upload/admin/images/subcategorys/images/' . $imageName;
        }
        $Subcategory->save();
        if ($Subcategory) {
            return redirect()->route('admin.subcategorys.index')->with('message', 'Subcategory Added Sucssesfully..');
        } else {
            return redirect()->back()->with('error', 'Somthing Went Wrong..');
        }
    }
    public function view($id)
    {
        $Subcategory = Subcategory::find($id);
        if ($Subcategory) {
            return view('admin.subcategorys.view', ['Subcategory' => $Subcategory]);
        } else {
            return redirect()->back()->with('error', 'Subcategory Not Found..!');
        }
    }

    public function edit($id)
    {
        $Subcategory = Subcategory::find($id);
        if ($Subcategory) {
            return view('admin.subcategorys.edit', ['Subcategory' => $Subcategory]);
        } else {
            return redirect()->back()->with('error', 'Subcategory Not Found..!');
        }
    }

    public function update(Request $request)
    {
        $request->merge(['has_old_image' => $request->old_image ? true : false]);
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'image' => [
                'required_if:has_old_image,false',
                'file',
                'image',
                'mimes:jpeg,png,jpg,gif',
                'max:5000',
            ],
        ]);


        $Subcategory = Subcategory::find($request->id);
        if ($Subcategory) {
            $Subcategory->name = $request['name'];
            $Subcategory->description = $request['description'];
            if ($request->image) {
                $folderPath = public_path('custom-assets/upload/admin/images/subcategorys/images/');
                if (!file_exists($folderPath)) {
                    mkdir($folderPath, 0777, true);
                }
                $file = $request->file('image');
                $imageoriginalname = str_replace(" ", "-", $file->getClientOriginalName());
                $imageName = rand(1000, 9999) . time() . $imageoriginalname;
                $file->move($folderPath, $imageName);
                $Subcategory->image = 'custom-assets/upload/admin/images/subcategorys/images/' . $imageName;
                if ($request->old_image && file_exists(public_path($request->old_image))) {
                    unlink(public_path($request->old_image));
                }
            }
            $Subcategory->update();
            if ($Subcategory) {
                return redirect()->route('admin.subcategorys.index')->with('message', 'Subcategory Updated Sucssesfully..');
            } else {
                return redirect()->back()->with('error', 'Somthing Went Wrong..');
            }
        } else {
            return redirect()->back()->with('error', 'Subcategory Not Found..!');
        }
    }

    public function delete($id)
    {
        if ($id) {
            $Subcategory = Subcategory::find($id);
            if ($Subcategory->image && file_exists(public_path($Subcategory->image))) {
                unlink(public_path($Subcategory->image));
            }
            $Subcategory = $Subcategory->delete();
            if ($Subcategory) {
                return redirect()->route('admin.subcategorys.index')->with('message', 'Subcategory Deleted Sucssesfully..');
            } else {
                return redirect()->back()->with('error', 'Somthing Went Wrong..!');
            }
        } else {
            return redirect()->back()->with('error', 'Subcategory Not Found..!');
        }
    }

    public function statusToggle(Request $request)
    {
        if ($request->id) {
            $Subcategory = Subcategory::find($request->id);
            $Subcategory->status = $request->status;
            $Subcategory = $Subcategory->update();
            if ($Subcategory) {
                return response()->json(['success' => 'Status Updated Successfully.']);
            } else {
                return response()->json(['error' => 'Somthing Went Wrong..!']);
            }
        } else {
            return response()->json(['error' => 'Subcategory Not Found..!']);
        }
    }
}
