<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ProductSlider;
use App\Models\Subcategory;
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
        $brands = Brand::select('name', 'image', 'id')
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
            $brands = Brand::select('name', 'image', 'id')
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
                return $product->sizes->map(function ($size) use ($product) {
                    return [
                        'size_id' => $size->id,
                        'size_name' => $size->name, // Assuming 'name' is a column in sizes table
                        'product_id' => $product->id,
                    ];
                });
            })
                ->groupBy('size_id') // Group by size ID
                ->map(function ($items, $sizeId) {
                    return [
                        'size_id' => $sizeId,
                        'size_name' => $items[0]['size_name'], // All items have the same size name
                        'product_count' => count($items),
                    ];
                })
                ->values();

            $flavorsArray = $categoryProducts->flatMap(function ($product) {
                return $product->flavors->map(function ($flavor) use ($product) {
                    return [
                        'flavor_id' => $flavor->id,
                        'flavor_name' => $flavor->name, // Assuming 'name' is a column in sizes table
                        'product_id' => $product->id,
                    ];
                });
            })
                ->groupBy('flavor_id') // Group by size ID
                ->map(function ($items, $sizeId) {
                    return [
                        'flavor_id' => $sizeId,
                        'flavor_name' => $items[0]['flavor_name'], // All items have the same size name
                        'product_count' => count($items),
                    ];
                })
                ->values();

            $prices = $categoryProducts->map(function ($product) {
                $minSize = $product->sizes->min('pivot.price');
                return $minSize ? $minSize : null;
            })->filter();

            $minPrice = $prices->min();
            $maxPrice = $prices->max();
            $categoryBrands = Brand::whereHas('products', function ($query) use ($Category) {
                $query->where('category_id', $Category->id); // Adjust column name if needed
            })->where('status', 1)->get();
            $totalRecords = $categoryProducts->count();

            return view('front.products.product-category', compact('Category', 'categories', 'brands', 'categoryBrands', 'flavorsArray', 'sizeArray', 'minPrice', 'maxPrice', 'totalRecords', 'otherCategorys'));
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
                $query->selectRaw('product_sizes.product_id, MIN(CAST(product_sizes.price AS DECIMAL(10, 2))) as min_price')
                    ->groupBy('product_sizes.product_id')
                    ->havingRaw('min_price BETWEEN ? AND ?', [$minPrice, $maxPrice]);
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
            $categoryProducts->orderByRaw('(SELECT MIN(CAST(product_sizes.price AS DECIMAL(10, 2))) FROM product_sizes WHERE product_sizes.product_id = products.id) ASC');
        } elseif ($sort === 'price_high_low') {
            $categoryProducts->orderByRaw('(SELECT MIN(CAST(product_sizes.price AS DECIMAL(10, 2))) FROM product_sizes WHERE product_sizes.product_id = products.id) DESC');
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

    public function productsSubCategory($id)
    {
        $Subcategory = Subcategory::where('status', 1)->where('id', $id)->first();

        if ($Subcategory) {
            $categories = Category::where('status', 1)->get();
            $brands = Brand::select('name', 'image', 'id')
                ->orderBy('name')
                ->get()
                ->groupBy(function ($brand) {
                    return strtoupper(substr($brand->name, 0, 1));
                });

            $otherSubcategorys = Subcategory::where('status', 1)->where('id', '!=', $id)->limit(7)->get();

            $subCategoryProducts = $Subcategory->products()
                ->where('status', 1)
                ->with('sizes', 'flavors') // Eager load sizes
                ->get();

            $sizeArray = $subCategoryProducts->flatMap(function ($product) {
                return $product->sizes->map(function ($size) use ($product) {
                    return [
                        'size_id' => $size->id,
                        'size_name' => $size->name, // Assuming 'name' is a column in sizes table
                        'product_id' => $product->id,
                    ];
                });
            })
                ->groupBy('size_id') // Group by size ID
                ->map(function ($items, $sizeId) {
                    return [
                        'size_id' => $sizeId,
                        'size_name' => $items[0]['size_name'], // All items have the same size name
                        'product_count' => count($items),
                    ];
                })
                ->values();

            $flavorsArray = $subCategoryProducts->flatMap(function ($product) {
                return $product->flavors->map(function ($flavor) use ($product) {
                    return [
                        'flavor_id' => $flavor->id,
                        'flavor_name' => $flavor->name, // Assuming 'name' is a column in sizes table
                        'product_id' => $product->id,
                    ];
                });
            })
                ->groupBy('flavor_id') // Group by size ID
                ->map(function ($items, $sizeId) {
                    return [
                        'flavor_id' => $sizeId,
                        'flavor_name' => $items[0]['flavor_name'], // All items have the same size name
                        'product_count' => count($items),
                    ];
                })
                ->values();

            $prices = $subCategoryProducts->map(function ($product) {
                $minSize = $product->sizes->min('pivot.price');
                return $minSize ? $minSize : null;
            })->filter();

            $minPrice = $prices->min();
            $maxPrice = $prices->max();
            $subCategoryBrands = Brand::whereHas('products', function ($query) use ($Subcategory) {
                $query->where('subcategory_id', $Subcategory->id); // Adjust column name if needed
            })->where('status', 1)->get();
            $totalRecords = $subCategoryProducts->count();

            return view('front.products.product-sub-category', compact('Subcategory', 'categories', 'brands', 'subCategoryBrands', 'flavorsArray', 'sizeArray', 'minPrice', 'maxPrice', 'totalRecords', 'otherSubcategorys'));
        } else {
            return redirect()->back()->with('error', 'Somthing Went Wrong..');
        }
    }

    public function getFilterSubCategoryProducts(Request $request, $id)
    {
        $perPage = $request->get('perPage', 1);
        $sort = $request->get('sort', 'latest');
        $minPrice = $request->get('minPrice', 0);
        $maxPrice = $request->get('maxPrice', 999999);
        $brands = $request->get('brands');
        $sizes = $request->get('sizes');
        $flavors = $request->get('flavors');

        $Subcategory = Subcategory::findOrFail($id);

        $subCategoryProducts = $Subcategory->products()
            ->where('status', 1)
            ->with(['sizes', 'flavors'])
            ->whereHas('sizes', function ($query) use ($minPrice, $maxPrice) {
                $query->selectRaw('product_sizes.product_id, MIN(CAST(product_sizes.price AS DECIMAL(10, 2))) as min_price')
                    ->groupBy('product_sizes.product_id')
                    ->havingRaw('min_price BETWEEN ? AND ?', [$minPrice, $maxPrice]);
            });


        if ($brands) {
            $brandsArray = explode(',', $brands);
            $subCategoryProducts->whereIn('brand_id', $brandsArray);
        }

        if ($sizes) {
            $sizesArray = explode(',', $sizes);
            $subCategoryProducts->whereHas('sizes', function ($query) use ($sizesArray) {
                $query->whereIn('size_id', $sizesArray);
            });
        }

        if ($flavors) {
            $flavorsArray = explode(',', $flavors);
            $subCategoryProducts->whereHas('flavors', function ($query) use ($flavorsArray) {
                $query->whereIn('flavor_id', $flavorsArray);
            });
        }

        if ($sort === 'price_low_high') {
            $subCategoryProducts->orderByRaw('(SELECT MIN(CAST(product_sizes.price AS DECIMAL(10, 2))) FROM product_sizes WHERE product_sizes.product_id = products.id) ASC');
        } elseif ($sort === 'price_high_low') {
            $subCategoryProducts->orderByRaw('(SELECT MIN(CAST(product_sizes.price AS DECIMAL(10, 2))) FROM product_sizes WHERE product_sizes.product_id = products.id) DESC');
        } elseif ($sort === 'oldest') {
            $subCategoryProducts->orderBy('created_at', 'asc');
        } else {
            $sort = 'latest';
            $subCategoryProducts->orderBy('created_at', 'desc');
        }

        $subCategoryProducts = $subCategoryProducts->paginate($perPage);

        return response()->json([
            'products' => $subCategoryProducts->items(),
            'pagination' => view('vendor.pagination.default', ['paginator' => $subCategoryProducts])->render(),
        ]);
    }

    public function productsBrand($id)
    {
        $Brand = Brand::where('status', 1)->where('id', $id)->first();

        if ($Brand) {
            $categories = Category::where('status', 1)->get();
            $brands = Brand::select('name', 'image', 'id')
                ->orderBy('name')
                ->get()
                ->groupBy(function ($brand) {
                    return strtoupper(substr($brand->name, 0, 1));
                });

            $categoriesWithProducts = Category::whereHas('products', function ($query) use ($Brand) {
                $query->where('brand_id', $Brand->id) // Filter products belonging to the brand
                    ->where('status', 1);           // Ensure the product is active
            })
                ->with(['products' => function ($query) use ($Brand) {
                    $query->where('brand_id', $Brand->id) // Include products with the specific brand
                        ->where('status', 1)            // Ensure product is active
                        ->with('sizes', 'flavors');     // Eager load related sizes and flavors
                }])
                ->where('status', 1) // Ensure the category is active
                ->take(7)            // Limit the result to 7 categories
                ->get();

            $barndProducts = $Brand->products()
                ->where('status', 1)
                ->with('sizes', 'flavors') // Eager load sizes
                ->get();

            $sizeArray = $barndProducts->flatMap(function ($product) {
                return $product->sizes->map(function ($size) use ($product) {
                    return [
                        'size_id' => $size->id,
                        'size_name' => $size->name, // Assuming 'name' is a column in sizes table
                        'product_id' => $product->id,
                    ];
                });
            })
                ->groupBy('size_id') // Group by size ID
                ->map(function ($items, $sizeId) {
                    return [
                        'size_id' => $sizeId,
                        'size_name' => $items[0]['size_name'], // All items have the same size name
                        'product_count' => count($items),
                    ];
                })
                ->values();

            $flavorsArray = $barndProducts->flatMap(function ($product) {
                return $product->flavors->map(function ($flavor) use ($product) {
                    return [
                        'flavor_id' => $flavor->id,
                        'flavor_name' => $flavor->name, // Assuming 'name' is a column in sizes table
                        'product_id' => $product->id,
                    ];
                });
            })
                ->groupBy('flavor_id') // Group by size ID
                ->map(function ($items, $sizeId) {
                    return [
                        'flavor_id' => $sizeId,
                        'flavor_name' => $items[0]['flavor_name'], // All items have the same size name
                        'product_count' => count($items),
                    ];
                })
                ->values();

            $prices = $barndProducts->map(function ($product) {
                $minSize = $product->sizes->min('pivot.price');
                return $minSize ? $minSize : null;
            })->filter();

            $brandslist =  Brand::where('status', 1)->where('id', $id)->get();

            $minPrice = $prices->min();
            $maxPrice = $prices->max();
            $totalRecords = $barndProducts->count();

            return view('front.products.product-brand', compact('Brand', 'categories', 'brands', 'flavorsArray', 'sizeArray', 'minPrice', 'maxPrice', 'totalRecords', 'categoriesWithProducts', 'brandslist'));
        } else {
            return redirect()->back()->with('error', 'Somthing Went Wrong..');
        }
    }

    public function getFilterBrandProducts(Request $request, $id)
    {
        $perPage = $request->get('perPage', 1);
        $sort = $request->get('sort', 'latest');
        $minPrice = $request->get('minPrice', 0);
        $maxPrice = $request->get('maxPrice', 999999);
        $brands = $request->get('brands');
        $categorys = $request->get('categorys');
        $sizes = $request->get('sizes');
        $flavors = $request->get('flavors');

        $Brand = Brand::findOrFail($id);

        $brandProducts = $Brand->products()
            ->where('status', 1)
            ->with(['sizes', 'flavors'])
            ->whereHas('sizes', function ($query) use ($minPrice, $maxPrice) {
                $query->selectRaw('product_sizes.product_id, MIN(CAST(product_sizes.price AS DECIMAL(10, 2))) as min_price')
                    ->groupBy('product_sizes.product_id')
                    ->havingRaw('min_price BETWEEN ? AND ?', [$minPrice, $maxPrice]);
            });


        if ($categorys) {
            $categorysArray = explode(',', $categorys);
            $brandProducts->whereHas('category', function ($query) use ($categorysArray) {
                $query->whereIn('category_id', $categorysArray);
            });
        }


        if ($brands) {
            $brandsArray = explode(',', $brands);
            $brandProducts->whereIn('brand_id', $brandsArray);
        }

        if ($sizes) {
            $sizesArray = explode(',', $sizes);
            $brandProducts->whereHas('sizes', function ($query) use ($sizesArray) {
                $query->whereIn('size_id', $sizesArray);
            });
        }

        if ($flavors) {
            $flavorsArray = explode(',', $flavors);
            $brandProducts->whereHas('flavors', function ($query) use ($flavorsArray) {
                $query->whereIn('flavor_id', $flavorsArray);
            });
        }

        if ($sort === 'price_low_high') {
            $brandProducts->orderByRaw('(SELECT MIN(CAST(product_sizes.price AS DECIMAL(10, 2))) FROM product_sizes WHERE product_sizes.product_id = products.id) ASC');
        } elseif ($sort === 'price_high_low') {
            $brandProducts->orderByRaw('(SELECT MIN(CAST(product_sizes.price AS DECIMAL(10, 2))) FROM product_sizes WHERE product_sizes.product_id = products.id) DESC');
        } elseif ($sort === 'oldest') {
            $brandProducts->orderBy('created_at', 'asc');
        } else {
            $sort = 'latest';
            $brandProducts->orderBy('created_at', 'desc');
        }

        $brandProducts = $brandProducts->paginate($perPage);

        return response()->json([
            'products' => $brandProducts->items(),
            'pagination' => view('vendor.pagination.default', ['paginator' => $brandProducts])->render(),
        ]);
    }
}
