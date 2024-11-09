<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Size;
use App\Models\Flavor;
use App\Models\Subcategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    //
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Product::all();
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
                    return View::make('admin.products.status', ['data' => $data])->render();
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at ? Carbon::parse($row->created_at)->setTimezone('Asia/Kolkata')->toDateTimeString() : '';
                })
                ->addColumn('actions', function ($row) {
                    $data['id'] = $row->id;
                    return View::make('admin.products.actions', ['data' => $data])->render();
                })
                ->rawColumns(['id', 'actions', 'status', 'created_at', 'name', 'description'])
                ->make(true);
        } else {
            return view('admin.products.index');
        }
    }
    public function create()
    {
        $Brands = Brand::where('status', 1)->get();
        $Sizes = Size::where('status', 1)->get();
        $Flavors = Flavor::where('status', 1)->get();
        return view('admin.products.create', ['Brands' => $Brands, 'Sizes' => $Sizes, 'Flavors' => $Flavors]);
    }
    public function save(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'cover_image' => 'required|file|image|mimes:jpeg,png,jpg,gif|max:5000',
            'brand' => 'required|exists:brands,id',
            'category' => 'required|exists:categories,id',
            'subcategory' => 'required|exists:subcategories,id',
            'sizes' => 'required|array',
            'flavors' => 'required|array',
            'images.*' => 'image',
            // 'prices' => 'required|array',
        ]);
        $Product = new Product();
        $Product->name = $request['name'];
        $Product->description = $request['description'];
        $Product->brand_id = $request['brand'];
        $Product->category_id = $request['category'];
        $Product->subcategory_id = $request['subcategory'];
        $Product->status = 1;
        if ($request->cover_image) {
            if ($request->old_cover_image && file_exists(public_path($request->old_cover_image))) {
                unlink(public_path($request->old_cover_image));
            }
            $folderPath = public_path('custom-assets/upload/admin/images/products/images/');
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);
            }
            $file = $request->file('cover_image');
            $imageoriginalname = str_replace(" ", "-", $file->getClientOriginalName());
            $imageName = rand(1000, 9999) . time() . $imageoriginalname;
            $file->move($folderPath, $imageName);
            $Product->cover_image = 'custom-assets/upload/admin/images/products/images/' . $imageName;
        }
        $Product->save();
        $Product->sizes()->attach($request->sizes);
        $Product->flavors()->attach($request->flavors);

        // foreach ($request->prices as $sizeId => $price) {
        //     $Product->sizes()->updateExistingPivot($sizeId, ['price' => $price]);
        // }

        if ($Product) {
            return redirect()->route('admin.products.index')->with('message', 'Product Added Sucssesfully..');
        } else {
            return redirect()->back()->with('error', 'Somthing Went Wrong..');
        }
    }
    public function view($id)
    {
        $Product = Product::find($id);
        if ($Product) {
            return view('admin.products.view', ['Product' => $Product]);
        } else {
            return redirect()->back()->with('error', 'Product Not Found..!');
        }
    }

    public function edit($id)
    {
        $Product = Product::find($id);
        if ($Product) {
            $Categorys = Category::where('status', 1)->get();
            $categoryIds = $Product->categories->pluck('id')->toArray();
            $subcategories = Subcategory::whereHas('categories', function ($query) use ($categoryIds) {
                $query->whereIn('categories.id', $categoryIds);
            })->get();
            return view('admin.products.edit', ['Product' => $Product, 'Categorys' => $Categorys, 'subcategories' => $subcategories]);
        } else {
            return redirect()->back()->with('error', 'Product Not Found..!');
        }
    }

    public function update(Request $request)
    {
        $request->merge(['has_old_image' => $request->old_image ? true : false]);
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'cover_image' => [
                'required_if:has_old_image,false',
                'file',
                'image',
                'mimes:jpeg,png,jpg,gif',
                'max:5000',
            ],
            'categories' => 'array',
            'subcategories' => 'array',
        ]);


        $Product = Product::find($request->id);
        if ($Product) {
            $Product->name = $request['name'];
            $Product->description = $request['description'];
            if ($request->cover_image) {
                if ($request->old_cover_image && file_exists(public_path($request->old_cover_image))) {
                    unlink(public_path($request->old_cover_image));
                }
                $folderPath = public_path('custom-assets/upload/admin/images/products/images/');
                if (!file_exists($folderPath)) {
                    mkdir($folderPath, 0777, true);
                }
                $file = $request->file('cover_image');
                $imageoriginalname = str_replace(" ", "-", $file->getClientOriginalName());
                $imageName = rand(1000, 9999) . time() . $imageoriginalname;
                $file->move($folderPath, $imageName);
                $Product->cover_image = 'custom-assets/upload/admin/images/products/images/' . $imageName;
            }
            $Product->update();
            $Product->categories()->sync($request->categories);
            $Product->subcategories()->sync($request->subcategories);
            if ($Product) {
                return redirect()->route('admin.products.index')->with('message', 'Product Updated Sucssesfully..');
            } else {
                return redirect()->back()->with('error', 'Somthing Went Wrong..');
            }
        } else {
            return redirect()->back()->with('error', 'Product Not Found..!');
        }
    }

    public function delete($id)
    {
        if ($id) {
            $Product = Product::find($id);
            if ($Product->cover_image && file_exists(public_path($Product->cover_image))) {
                unlink(public_path($Product->cover_image));
            }
            $Product = $Product->delete();
            if ($Product) {
                return redirect()->route('admin.products.index')->with('message', 'Product Deleted Sucssesfully..');
            } else {
                return redirect()->back()->with('error', 'Somthing Went Wrong..!');
            }
        } else {
            return redirect()->back()->with('error', 'Product Not Found..!');
        }
    }

    public function statusToggle(Request $request)
    {
        if ($request->id) {
            $Product = Product::find($request->id);
            $Product->status = $request->status;
            $Product = $Product->update();
            if ($Product) {
                return response()->json(['success' => 'Status Updated Successfully.']);
            } else {
                return response()->json(['error' => 'Somthing Went Wrong..!']);
            }
        } else {
            return response()->json(['error' => 'Product Not Found..!']);
        }
    }

    public function categories(Request $request)
    {
        if ($request->brandId) {
            $brandId = $request->input('brandId');
            $categories = Category::whereHas('brandCategories', function ($query) use ($brandId) {
                $query->where('brand_id', $brandId);
            })->get();
            if ($categories) {
                return response()->json(['categories' => $categories]);
            } else {
                return response()->json(['error' => 'Somthing Went Wrong..!']);
            }
        } else {
            return response()->json(['error' => 'Sub Categories Not Found..!']);
        }
    }

    public function subcategories(Request $request)
    {
        if ($request->categoryId && $request->brandId) {
            $categoryId = $request->input('categoryId');
            $brandId = $request->input('brandId');
            $subcategories = Subcategory::whereHas('brandSubcategories', function ($query) use ($brandId) {
                $query->where('brand_id', $brandId);
            })->whereHas('categories', function ($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
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
