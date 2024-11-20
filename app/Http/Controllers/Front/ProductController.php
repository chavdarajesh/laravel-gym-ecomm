<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ProductSlider;
use App\Models\TopSellingProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    //
    public function products()
    {
        $categories = Category::where('status', 1)->get();
        $Blogs = Blog::where('status', 1)->get();
        $brands = Brand::select('name', 'image')
            ->orderBy('name')
            ->get()
            ->groupBy(function ($brand) {
                return strtoupper(substr($brand->name, 0, 1));
            });
        $ProductSliders = ProductSlider::where('status', 1)
            ->orderByRaw('`order` = 0, `order` ASC')
            ->get();
        $topSellingProducts = TopSellingProduct::all();
        return view('front.products.products', compact('categories', 'brands', 'ProductSliders', 'Blogs', 'topSellingProducts'));
    }

    public function productsSidebar()
    {
        $categories = Category::where('status', 1)->get();
        $brands = Brand::select('name', 'image')
            ->orderBy('name')
            ->get()
            ->groupBy(function ($brand) {
                return strtoupper(substr($brand->name, 0, 1));
            });
        return view('front.products.product-sidebar', compact('categories', 'brands'));
    }

    public function productsCategory($id)
    {
        $Category = Category::where('status', 1)->where('id', $id)->first();

        if ($Category) {
            $categories = Category::where('status', 1)->get();
            $brands = Brand::select('name', 'image')
                ->orderBy('name')
                ->get()
                ->groupBy(function ($brand) {
                    return strtoupper(substr($brand->name, 0, 1));
                });

            $otherCategorys = Category::where('status', 1)->where('id', '!=', $id)->limit(7)->get();
            $categoryProducts = $Category->products()
                ->where('status', 1)
                ->with('sizes', 'flavors') // Eager load sizes
                ->get();

            $sizeArray = $categoryProducts->flatMap(function ($product) {
                return $product->sizes;
            })->unique('id');

            $flavorsArray = $categoryProducts->flatMap(function ($product) {
                return $product->flavors;
            })->unique('id');

            $prices = $categoryProducts->map(function ($product) {
                $firstSize = $product->sizes->first();
                return $firstSize ? $firstSize->pivot->price : null;
            })->filter();

            $minPrice = $prices->min();
            $maxPrice = $prices->max();
            $categoryBrands = $Category->brands()->where('status', 1)->get();
            $totalRecords = $categoryProducts->count();

            return view('front.products.product-category', compact('Category', 'categories', 'brands', 'categoryBrands', 'flavorsArray', 'sizeArray', 'minPrice', 'maxPrice', 'totalRecords','otherCategorys'));
        } else {
            return redirect()->back()->with('error', 'Somthing Went Wrong..');
        }
    }

    public function getFilterCategoryProducts(Request $request, $id)
    {
        $perPage = $request->get('perPage', 1);
        $sort = $request->get('sort', 'latest');
        $minPrice = $request->get('minPrice', 0);
        $maxPrice = $request->get('maxPrice', 999999);
        $brands = $request->get('brands');
        $sizes = $request->get('sizes');
        $flavors = $request->get('flavors');

        $Category = Category::findOrFail($id);

        $categoryProducts = $Category->products()
            ->where('status', 1)
            ->with(['sizes', 'flavors'])
            ->whereHas('sizes', function ($query) use ($minPrice, $maxPrice) {
                $query->select('product_sizes.product_id', 'product_sizes.price')
                    ->orderBy('product_sizes.created_at', 'asc')
                    ->whereRaw('CAST(product_sizes.price AS DECIMAL(10, 2)) BETWEEN ? AND ?', [$minPrice, $maxPrice])
                    ->limit(1);
            });

        if ($brands) {
            $brandsArray = explode(',', $brands);
            $categoryProducts->whereIn('brand_id', $brandsArray);
        }

        if ($sizes) {
            $sizesArray = explode(',', $sizes);
            $categoryProducts->whereHas('sizes', function ($query) use ($sizesArray) {
                $query->whereIn('size_id', $sizesArray);
            });
        }

        if ($flavors) {
            $flavorsArray = explode(',', $flavors);
            $categoryProducts->whereHas('flavors', function ($query) use ($flavorsArray) {
                $query->whereIn('flavor_id', $flavorsArray);
            });
        }

        if ($sort === 'price_low_high') {
            $categoryProducts->with(['sizes' => function ($query) {
                $query->orderBy('price', 'asc');
            }])->orderByRaw('(SELECT MIN(price) FROM product_sizes WHERE product_sizes.product_id = products.id) ASC');
        } elseif ($sort === 'price_high_low') {
            $categoryProducts->with(['sizes' => function ($query) {
                $query->orderBy('price', 'desc');
            }])->orderByRaw('(SELECT MAX(price) FROM product_sizes WHERE product_sizes.product_id = products.id) DESC');
        } elseif ($sort === 'oldest') {
            $categoryProducts->orderBy('created_at', 'asc');
        } else {
            $sort = 'latest';
            $categoryProducts->orderBy('created_at', 'desc');
        }

        $categoryProducts = $categoryProducts->paginate($perPage);

        return response()->json([
            'products' => $categoryProducts->items(),
            'pagination' => view('vendor.pagination.default', ['paginator' => $categoryProducts])->render(),
        ]);
    }
}
