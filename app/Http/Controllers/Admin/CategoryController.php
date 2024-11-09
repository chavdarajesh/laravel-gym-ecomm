<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    //
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Category::all();
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
                    return View::make('admin.categorys.status', ['data' => $data])->render();
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at ? Carbon::parse($row->created_at)->setTimezone('Asia/Kolkata')->toDateTimeString() : '';
                })
                ->addColumn('actions', function ($row) {
                    $data['id'] = $row->id;
                    return View::make('admin.categorys.actions', ['data' => $data])->render();
                })
                ->rawColumns(['id', 'actions', 'status', 'created_at', 'name', 'description'])
                ->make(true);
        } else {
            return view('admin.categorys.index');
        }
    }
    public function create()
    {
        $Subcategorys = Subcategory::where('status', 1)->get();
        return view('admin.categorys.create', ['Subcategorys' => $Subcategorys]);
    }
    public function save(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'image' => 'required|file|image|mimes:jpeg,png,jpg,gif|max:5000',
            'subcategories' => 'array',
        ]);
        $Category = new Category();
        $Category->name = $request['name'];
        $Category->description = $request['description'];
        $Category->status = 1;
        if ($request->image) {
            if ($request->old_image && file_exists(public_path($request->old_image))) {
                unlink(public_path($request->old_image));
            }
            $folderPath = public_path('custom-assets/upload/admin/images/categorys/images/');
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);
            }
            $file = $request->file('image');
            $imageoriginalname = str_replace(" ", "-", $file->getClientOriginalName());
            $imageName = rand(1000, 9999) . time() . $imageoriginalname;
            $file->move($folderPath, $imageName);
            $Category->image = 'custom-assets/upload/admin/images/categorys/images/' . $imageName;
        }
        $Category->save();
        $Category->subcategories()->sync($request->subcategories);
        if ($Category) {
            return redirect()->route('admin.categorys.index')->with('message', 'Category Added Sucssesfully..');
        } else {
            return redirect()->back()->with('error', 'Somthing Went Wrong..');
        }
    }
    public function view($id)
    {
        $Category = Category::find($id);
        if ($Category) {
            return view('admin.categorys.view', ['Category' => $Category]);
        } else {
            return redirect()->back()->with('error', 'Category Not Found..!');
        }
    }

    public function edit($id)
    {
        $Category = Category::find($id);
        if ($Category) {
            $Subcategorys = Subcategory::where('status', 1)->get();
            return view('admin.categorys.edit', ['Category' => $Category, 'Subcategorys' => $Subcategorys]);
        } else {
            return redirect()->back()->with('error', 'Category Not Found..!');
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
            'subcategories' => 'array',
        ]);


        $Category = Category::find($request->id);
        if ($Category) {
            $Category->name = $request['name'];
            $Category->description = $request['description'];
            if ($request->image) {
                $folderPath = public_path('custom-assets/upload/admin/images/categorys/images/');
                if (!file_exists($folderPath)) {
                    mkdir($folderPath, 0777, true);
                }
                $file = $request->file('image');
                $imageoriginalname = str_replace(" ", "-", $file->getClientOriginalName());
                $imageName = rand(1000, 9999) . time() . $imageoriginalname;
                $file->move($folderPath, $imageName);
                $Category->image = 'custom-assets/upload/admin/images/categorys/images/' . $imageName;
                if ($request->old_image && file_exists(public_path($request->old_image))) {
                    unlink(public_path($request->old_image));
                }
            }
            $Category->update();
            $Category->subcategories()->sync($request->subcategories);
            if ($Category) {
                return redirect()->route('admin.categorys.index')->with('message', 'Category Updated Sucssesfully..');
            } else {
                return redirect()->back()->with('error', 'Somthing Went Wrong..');
            }
        } else {
            return redirect()->back()->with('error', 'Category Not Found..!');
        }
    }

    public function delete($id)
    {
        if ($id) {
            $Category = Category::find($id);
            foreach ($Category->subcategories as $subCategory) {
                if ($subCategory->image && file_exists(public_path($subCategory->image))) {
                    unlink(public_path($subCategory->image));
                }
                $subCategory->delete();
            }
            if ($Category->image && file_exists(public_path($Category->image))) {
                unlink(public_path($Category->image));
            }
            $Category = $Category->delete();
            if ($Category) {
                return redirect()->route('admin.categorys.index')->with('message', 'Category Deleted Sucssesfully..');
            } else {
                return redirect()->back()->with('error', 'Somthing Went Wrong..!');
            }
        } else {
            return redirect()->back()->with('error', 'Category Not Found..!');
        }
    }

    public function statusToggle(Request $request)
    {
        if ($request->id) {
            $Category = Category::find($request->id);
            $Category->status = $request->status;
            $Category = $Category->update();
            if ($Category) {
                return response()->json(['success' => 'Status Updated Successfully.']);
            } else {
                return response()->json(['error' => 'Somthing Went Wrong..!']);
            }
        } else {
            return response()->json(['error' => 'Category Not Found..!']);
        }
    }
}
