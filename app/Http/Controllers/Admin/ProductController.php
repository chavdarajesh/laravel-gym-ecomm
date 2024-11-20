<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Size;
use App\Models\Flavor;
use App\Models\ProductImage;
use App\Models\ProductSlider;
use App\Models\Subcategory;
use App\Models\TopSellingProduct;
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
            'subcategory' => 'exists:subcategories,id',
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

        $sizeData = [];
        foreach ($request->sizes as $sizeId) {
            if (isset($request->prices[$sizeId])) {
                $sizeData[$sizeId] = ['price' => $request->prices[$sizeId]]; // Add price for each size
            }
        }
        $Product->sizes()->sync($sizeData);
        $Product->flavors()->sync($request->flavors);

        $images = $request->file('images');
        if ($images && count($images) > 0) {
            $images_arr = [];
            $folderPath = public_path('custom-assets/upload/admin/images/products/multipleimages/');
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);
            }
            foreach ($images as $key => $file) {
                $imageoriginalname = str_replace(" ", "-", $file->getClientOriginalName());
                $imageName = rand(1000, 9999) . time() . $imageoriginalname;
                $file->move($folderPath, $imageName);
                $images_arr[] = [
                    'product_id' => $Product->id,
                    'image' => 'custom-assets/upload/admin/images/products/multipleimages/' . $imageName,
                ];
            }
            ProductImage::insert($images_arr);
        }
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
            $Brands = Brand::where('status', 1)->get();
            $brandId = $Product->brand_id;
            $Categorys = Category::whereHas('brandCategories', function ($query) use ($brandId) {
                $query->where('brand_id', $brandId);
            })->get();

            $categoryId = $Product->category_id;
            $subcategories = Subcategory::whereHas('brandSubcategories', function ($query) use ($brandId) {
                $query->where('brand_id', $brandId);
            })->whereHas('categories', function ($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            })->get();

            $Sizes = Size::where('status', 1)->get();
            $Flavors = Flavor::where('status', 1)->get();
            return view('admin.products.view', ['Product' => $Product, 'Brands' => $Brands, 'Categorys' => $Categorys, 'subcategories' => $subcategories, 'Sizes' => $Sizes, 'Flavors' => $Flavors]);
        } else {
            return redirect()->back()->with('error', 'Product Not Found..!');
        }
    }

    public function edit($id)
    {
        $Product = Product::find($id);
        if ($Product) {
            $Brands = Brand::where('status', 1)->get();
            $brandId = $Product->brand_id;
            $Categorys = Category::whereHas('brandCategories', function ($query) use ($brandId) {
                $query->where('brand_id', $brandId);
            })->get();

            $categoryId = $Product->category_id;
            $subcategories = Subcategory::whereHas('brandSubcategories', function ($query) use ($brandId) {
                $query->where('brand_id', $brandId);
            })->whereHas('categories', function ($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            })->get();

            $Sizes = Size::where('status', 1)->get();
            $Flavors = Flavor::where('status', 1)->get();
            return view('admin.products.edit', ['Product' => $Product, 'Brands' => $Brands, 'Categorys' => $Categorys, 'subcategories' => $subcategories, 'Sizes' => $Sizes, 'Flavors' => $Flavors]);
        } else {
            return redirect()->back()->with('error', 'Product Not Found..!');
        }
    }

    public function update(Request $request)
    {
        $request->merge(['has_old_image' => $request->old_cover_image ? true : false]);
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
            'brand' => 'required|exists:brands,id',
            'category' => 'required|exists:categories,id',
            'subcategory' => 'exists:subcategories,id',
            'sizes' => 'required|array',
            'flavors' => 'required|array',
            'images.*' => 'image',
        ]);


        $Product = Product::find($request->id);
        if ($Product) {
            $Product->name = $request['name'];
            $Product->description = $request['description'];
            $Product->brand_id = $request['brand'];
            $Product->category_id = $request['category'];
            $Product->subcategory_id = $request['subcategory'];

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

            $sizeData = [];
            foreach ($request->sizes as $sizeId) {
                if (isset($request->prices[$sizeId])) {
                    $sizeData[$sizeId] = ['price' => $request->prices[$sizeId]]; // Add price for each size
                }
            }
            $Product->sizes()->sync($sizeData);
            $Product->flavors()->sync($request->flavors);
            $images = $request->file('images');



            if ($images && count($images) > 0) {
                $images_arr = [];
                $folderPath = public_path('custom-assets/upload/admin/images/products/multipleimages/');
                if (!file_exists($folderPath)) {
                    mkdir($folderPath, 0777, true);
                }
                foreach ($images as $key => $file) {
                    $imageoriginalname = str_replace(" ", "-", $file->getClientOriginalName());
                    $imageName = rand(1000, 9999) . time() . $imageoriginalname;
                    $file->move($folderPath, $imageName);
                    $images_arr[] = [
                        'product_id' => $Product->id,
                        'image' => 'custom-assets/upload/admin/images/products/multipleimages/' . $imageName,
                    ];
                }
                ProductImage::insert($images_arr);
            }


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
            foreach ($Product->images as $image) {
                if ($image->image && file_exists(public_path($image->image))) {
                    unlink(public_path($image->image));
                }
                $image->delete();
            }

            if ($Product->cover_image && file_exists(public_path($Product->cover_image))) {
                unlink(public_path($Product->cover_image));
            }
            $Product = $Product->delete();
            $TopSellingProduct = TopSellingProduct::where('product_id', $id)->first();
            $TopSellingProduct = $TopSellingProduct->delete();

            foreach ($Product->sizes as $item) {
                $item->delete();
            }
            foreach ($Product->flavors as $item) {
                $item->delete();
            }

            $ProductSliders = ProductSlider::where('product_id', $id)->get();
            foreach ($ProductSliders as $item) {
                $item->delete();
            }
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

    public function imagesDelete(Request $request)
    {
        if ($request->id) {
            $ProductImage = ProductImage::find($request->id);
            if ($ProductImage->image && file_exists(public_path($ProductImage->image))) {
                unlink(public_path($ProductImage->image));
            }
            $ProductImage = $ProductImage->delete();
            if ($ProductImage) {
                return response()->json(['success' => 'Image Deleted Successfully.']);
            } else {
                return response()->json(['error' => 'Somthing Went Wrong..!']);
            }
        } else {
            return response()->json(['error' => 'ProductImage Not Found..!']);
        }
    }
}
