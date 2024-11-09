<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Subcategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\Facades\DataTables;

class BrandController extends Controller
{
    //
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Brand::all();
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
                    return View::make('admin.brands.status', ['data' => $data])->render();
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at ? Carbon::parse($row->created_at)->setTimezone('Asia/Kolkata')->toDateTimeString() : '';
                })
                ->addColumn('actions', function ($row) {
                    $data['id'] = $row->id;
                    return View::make('admin.brands.actions', ['data' => $data])->render();
                })
                ->rawColumns(['id', 'actions', 'status', 'created_at', 'name', 'description'])
                ->make(true);
        } else {
            return view('admin.brands.index');
        }
    }
    public function create()
    {
        $Categorys = Category::where('status', 1)->get();
        return view('admin.brands.create', ['Categorys' => $Categorys]);
    }
    public function save(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'image' => 'required|file|image|mimes:jpeg,png,jpg,gif|max:5000',
            'categories' => 'array',
            'subcategories' => 'array',
        ]);
        $Brand = new Brand();
        $Brand->name = $request['name'];
        $Brand->description = $request['description'];
        $Brand->status = 1;
        if ($request->image) {
            if ($request->old_image && file_exists(public_path($request->old_image))) {
                unlink(public_path($request->old_image));
            }
            $folderPath = public_path('custom-assets/upload/admin/images/brands/images/');
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);
            }
            $file = $request->file('image');
            $imageoriginalname = str_replace(" ", "-", $file->getClientOriginalName());
            $imageName = rand(1000, 9999) . time() . $imageoriginalname;
            $file->move($folderPath, $imageName);
            $Brand->image = 'custom-assets/upload/admin/images/brands/images/' . $imageName;
        }
        $Brand->save();
        $Brand->categories()->sync($request->categories);
        $Brand->subcategories()->sync($request->subcategories);
        if ($Brand) {
            return redirect()->route('admin.brands.index')->with('message', 'Brand Added Sucssesfully..');
        } else {
            return redirect()->back()->with('error', 'Somthing Went Wrong..');
        }
    }
    public function view($id)
    {
        $Brand = Brand::find($id);
        if ($Brand) {
            return view('admin.brands.view', ['Brand' => $Brand]);
        } else {
            return redirect()->back()->with('error', 'Brand Not Found..!');
        }
    }

    public function edit($id)
    {
        $Brand = Brand::find($id);
        if ($Brand) {
            $Categorys = Category::where('status', 1)->get();
            $categoryIds = $Brand->categories->pluck('id')->toArray();
            $subcategories = Subcategory::whereHas('categories', function ($query) use ($categoryIds) {
                $query->whereIn('categories.id', $categoryIds);
            })->get();
            return view('admin.brands.edit', ['Brand' => $Brand, 'Categorys' => $Categorys, 'subcategories' => $subcategories]);
        } else {
            return redirect()->back()->with('error', 'Brand Not Found..!');
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
            'categories' => 'array',
            'subcategories' => 'array',
        ]);


        $Brand = Brand::find($request->id);
        if ($Brand) {
            $Brand->name = $request['name'];
            $Brand->description = $request['description'];
            if ($request->image) {
                $folderPath = public_path('custom-assets/upload/admin/images/brands/images/');
                if (!file_exists($folderPath)) {
                    mkdir($folderPath, 0777, true);
                }
                $file = $request->file('image');
                $imageoriginalname = str_replace(" ", "-", $file->getClientOriginalName());
                $imageName = rand(1000, 9999) . time() . $imageoriginalname;
                $file->move($folderPath, $imageName);
                $Brand->image = 'custom-assets/upload/admin/images/brands/images/' . $imageName;
                if ($request->old_image && file_exists(public_path($request->old_image))) {
                    unlink(public_path($request->old_image));
                }
            }
            $Brand->update();
            $Brand->categories()->sync($request->categories);
            $Brand->subcategories()->sync($request->subcategories);
            if ($Brand) {
                return redirect()->route('admin.brands.index')->with('message', 'Brand Updated Sucssesfully..');
            } else {
                return redirect()->back()->with('error', 'Somthing Went Wrong..');
            }
        } else {
            return redirect()->back()->with('error', 'Brand Not Found..!');
        }
    }

    public function delete($id)
    {
        if ($id) {
            $Brand = Brand::find($id);
            if ($Brand->image && file_exists(public_path($Brand->image))) {
                unlink(public_path($Brand->image));
            }
            $Brand = $Brand->delete();
            if ($Brand) {
                return redirect()->route('admin.brands.index')->with('message', 'Brand Deleted Sucssesfully..');
            } else {
                return redirect()->back()->with('error', 'Somthing Went Wrong..!');
            }
        } else {
            return redirect()->back()->with('error', 'Brand Not Found..!');
        }
    }

    public function statusToggle(Request $request)
    {
        if ($request->id) {
            $Brand = Brand::find($request->id);
            $Brand->status = $request->status;
            $Brand = $Brand->update();
            if ($Brand) {
                return response()->json(['success' => 'Status Updated Successfully.']);
            } else {
                return response()->json(['error' => 'Somthing Went Wrong..!']);
            }
        } else {
            return response()->json(['error' => 'Brand Not Found..!']);
        }
    }

    public function subcategories(Request $request)
    {
        if ($request->category_ids) {
            $categoryIds = $request->input('category_ids');
            $subcategories = Subcategory::whereHas('categories', function ($query) use ($categoryIds) {
                $query->whereIn('categories.id', $categoryIds);
            })->get();
            if ($subcategories) {
                return response()->json(['subcategories' => $subcategories]);
            } else {
                return response()->json(['error' => 'Somthing Went Wrong..!']);
            }
        } else {
            return response()->json(['error' => 'Sub Categories Not Found..!']);
        }
    }
}
