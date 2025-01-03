<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Brand;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductSlider;
use App\Models\Subcategory;
use App\Models\TopSellingProduct;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $Category = Category::where('status', 1)->findOrFail($id);

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

        $Subcategory = Subcategory::where('status', 1)->findOrFail($id);

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
                    ->where('status', 1); // Ensure the product is active
            })
                ->with(['products' => function ($query) use ($Brand) {
                    $query->where('brand_id', $Brand->id) // Include products with the specific brand
                        ->where('status', 1) // Ensure product is active
                        ->with('sizes', 'flavors'); // Eager load related sizes and flavors
                }])
                ->where('status', 1) // Ensure the category is active
                ->take(7) // Limit the result to 7 categories
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

            $brandslist = Brand::where('status', 1)->where('id', $id)->get();

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

        $Brand = Brand::where('status', 1)->findOrFail($id);

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

    public function productsTopSelling()
    {
        $categories = Category::where('status', 1)->get();
        $brands = Brand::select('name', 'image', 'id')
            ->orderBy('name')
            ->get()
            ->groupBy(function ($brand) {
                return strtoupper(substr($brand->name, 0, 1));
            });

        $topSellingCategories = Category::whereHas('products', function ($query) {
            $query->whereIn('id', function ($subQuery) {
                $subQuery->select('product_id')
                    ->from('top_selling_products')
                    ->where('status', 1); // Adjust this if you need to filter based on status in top_selling_products
            });
        })->get();

        $topSellingProducts = TopSellingProduct::whereHas('product', function ($query) {
            $query->where('status', 1); // Ensure the product is active
        })
            ->with(['product.sizes', 'product.flavors']) // Eager load related sizes and flavors
            ->get();

        $sizeArray = $topSellingProducts->flatMap(function ($product) {
            return $product->product->sizes->map(function ($size) use ($product) {
                return [
                    'size_id' => $size->id,
                    'size_name' => $size->name, // Assuming 'name' is a column in sizes table
                    'product_id' => $product->product->id,
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

        // Group by flavors
        $flavorsArray = $topSellingProducts->flatMap(function ($product) {
            return $product->product->flavors->map(function ($flavor) use ($product) {
                return [
                    'flavor_id' => $flavor->id,
                    'flavor_name' => $flavor->name, // Assuming 'name' is a column in flavors table
                    'product_id' => $product->product->id,
                ];
            });
        })
            ->groupBy('flavor_id') // Group by flavor ID
            ->map(function ($items, $flavorId) {
                return [
                    'flavor_id' => $flavorId,
                    'flavor_name' => $items[0]['flavor_name'], // All items have the same flavor name
                    'product_count' => count($items),
                ];
            })
            ->values();

        $prices = $topSellingProducts->map(function ($product) {
            // Ensure you are referencing the pivot for prices
            $minSize = $product->product->sizes->min(function ($size) {
                return $size->pivot->price; // Access price through pivot
            });
            return $minSize ? $minSize : null;
        })->filter();

        $minPrice = $prices->min();
        $maxPrice = $prices->max();

        $topSellingBrands = Brand::whereHas('products', function ($query) {
            $query->whereIn('id', function ($subQuery) {
                $subQuery->select('product_id')
                    ->from('top_selling_products')
                    ->where('status', 1);
            });
        })->where('status', 1)
            ->get();

        $totalRecords = $topSellingProducts->count();

        return view('front.products.product-top-selling', compact('categories', 'brands', 'topSellingCategories', 'flavorsArray', 'sizeArray', 'minPrice', 'maxPrice', 'totalRecords', 'topSellingBrands'));
    }

    public function getFilterTopSellingProducts(Request $request)
    {
        $perPage = $request->get('perPage', 1);
        $sort = $request->get('sort', 'latest');
        $minPrice = $request->get('minPrice', 0);
        $maxPrice = $request->get('maxPrice', 999999);
        $brands = $request->get('brands');
        $sizes = $request->get('sizes');
        $flavors = $request->get('flavors');

        $topSellingProducts = TopSellingProduct::whereHas('product', function ($query) use ($minPrice, $maxPrice) {
            $query->where('status', 1) // Ensure the product is active
                ->whereHas('sizes', function ($query) use ($minPrice, $maxPrice) {
                    $query->selectRaw('product_sizes.product_id, MIN(CAST(product_sizes.price AS DECIMAL(10, 2))) as min_price')
                        ->groupBy('product_sizes.product_id')
                        ->havingRaw('min_price BETWEEN ? AND ?', [$minPrice, $maxPrice]); // Filter sizes by price range
                });
        })->with(['product.sizes', 'product.flavors']); // Eager load sizes and flavors

        // Apply Brand Filter
        if ($brands) {
            $brandsArray = explode(',', $brands);
            $topSellingProducts = $topSellingProducts->whereHas('product', function ($query) use ($brandsArray) {
                $query->whereIn('brand_id', $brandsArray);
            });
        }

        // Apply Size Filter
        if ($sizes) {
            $sizesArray = explode(',', $sizes);
            $topSellingProducts = $topSellingProducts->whereHas('product.sizes', function ($query) use ($sizesArray) {
                $query->whereIn('size_id', $sizesArray);
            });
        }

        // Apply Flavor Filter
        if ($flavors) {
            $flavorsArray = explode(',', $flavors);
            $topSellingProducts = $topSellingProducts->whereHas('product.flavors', function ($query) use ($flavorsArray) {
                $query->whereIn('flavor_id', $flavorsArray);
            });
        }

        // Apply sorting
        if ($sort === 'price_low_high') {
            $topSellingProducts = $topSellingProducts->join('products', 'top_selling_products.product_id', '=', 'products.id')
                ->leftJoin('product_sizes', 'products.id', '=', 'product_sizes.product_id')
                ->select('top_selling_products.*')
                ->groupBy('products.id')
                ->orderByRaw('MIN(CAST(product_sizes.price AS DECIMAL(10, 2))) ASC');
        } elseif ($sort === 'price_high_low') {
            $topSellingProducts = $topSellingProducts->join('products', 'top_selling_products.product_id', '=', 'products.id')
                ->leftJoin('product_sizes', 'products.id', '=', 'product_sizes.product_id')
                ->select('top_selling_products.*')
                ->groupBy('products.id')
                ->orderByRaw('MIN(CAST(product_sizes.price AS DECIMAL(10, 2))) DESC');
        } elseif ($sort === 'oldest') {
            $topSellingProducts = $topSellingProducts->join('products', 'top_selling_products.product_id', '=', 'products.id')
                ->select('top_selling_products.*')
                ->orderBy('products.created_at', 'asc');
        } else {
            // Default to 'latest'
            $topSellingProducts = $topSellingProducts->join('products', 'top_selling_products.product_id', '=', 'products.id')
                ->select('top_selling_products.*')
                ->orderBy('products.created_at', 'desc');
        }

        // Paginate Results
        $topSellingProducts = $topSellingProducts->paginate($perPage);

        return response()->json([
            'products' => $topSellingProducts->items(),
            'pagination' => view('vendor.pagination.default', ['paginator' => $topSellingProducts])->render(),
        ]);
    }

    public function productsSearch(Request $request)
    {
        $search = $request->input('search');
        if ($search) {
            $Products = Product::where('name', 'like', "%$search%")->where('status', 1)->orderBy('id', 'DESC')
                ->get();
            $categories = Category::where('status', 1)->get();
            $brands = Brand::select('name', 'image', 'id')
                ->orderBy('name')
                ->get()
                ->groupBy(function ($brand) {
                    return strtoupper(substr($brand->name, 0, 1));
                });

            $Othercategories = Category::whereIn('id', $Products->pluck('category_id')->unique())
                ->take(7)
                ->get()
                ->map(function ($category) use ($Products) {
                    return [
                        'category_id' => $category->id,
                        'category_name' => $category->name, // Assuming 'name' is a column in the categories table
                        'product_count' => $Products->where('category_id', $category->id)->count(),
                    ];
                });

            $sizeArray = $Products->flatMap(function ($product) {
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

            $flavorsArray = $Products->flatMap(function ($product) {
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

            $prices = $Products->map(function ($product) {
                $minSize = $product->sizes->min('pivot.price');
                return $minSize ? $minSize : null;
            })->filter();

            $minPrice = $prices->min();
            $maxPrice = $prices->max();

            $totalRecords = $Products->count();
            $productsBrands = $Products->groupBy('brand_id')->map(function ($groupedProducts, $brandId) {
                $brand = $groupedProducts->first()->brand; // All products in the group share the same brand
                return [
                    'brand_id' => $brand->id,
                    'brand_name' => $brand->name, // Assuming 'name' is a column in the brands table
                    'product_count' => $groupedProducts->count(), // Count of products for this brand
                ];
            })->values();

            if ($Products) {
                return view('front.products.products-search', compact('search', 'categories', 'brands', 'Othercategories', 'flavorsArray', 'sizeArray', 'minPrice', 'maxPrice', 'totalRecords', 'productsBrands'));
            } else {
                return redirect()->route('front.products');
            }
        } else {
            return redirect()->route('front.products');
        }
    }

    public function getFilterSearchProducts(Request $request)
    {
        $perPage = $request->get('perPage', 1);
        $sort = $request->get('sort', 'latest');
        $minPrice = $request->get('minPrice', 0);
        $maxPrice = $request->get('maxPrice', 999999);
        $brands = $request->get('brands');
        $categorys = $request->get('categorys');
        $sizes = $request->get('sizes');
        $flavors = $request->get('flavors');
        $search = $request->get('search');

        $Products = Product::where('name', 'like', "%$search%")->where('status', 1)
            ->with(['sizes', 'flavors'])
            ->whereHas('sizes', function ($query) use ($minPrice, $maxPrice) {
                $query->selectRaw('product_sizes.product_id, MIN(CAST(product_sizes.price AS DECIMAL(10, 2))) as min_price')
                    ->groupBy('product_sizes.product_id')
                    ->havingRaw('min_price BETWEEN ? AND ?', [$minPrice, $maxPrice]);
            });

        if ($categorys) {
            $categorysArray = explode(',', $categorys);
            $Products->whereHas('category', function ($query) use ($categorysArray) {
                $query->whereIn('category_id', $categorysArray);
            });
        }

        if ($brands) {
            $brandsArray = explode(',', $brands);
            $Products->whereIn('brand_id', $brandsArray);
        }

        if ($sizes) {
            $sizesArray = explode(',', $sizes);
            $Products->whereHas('sizes', function ($query) use ($sizesArray) {
                $query->whereIn('size_id', $sizesArray);
            });
        }

        if ($flavors) {
            $flavorsArray = explode(',', $flavors);
            $Products->whereHas('flavors', function ($query) use ($flavorsArray) {
                $query->whereIn('flavor_id', $flavorsArray);
            });
        }

        // Apply sorting
        if ($sort === 'price_low_high') {
            $Products->orderByRaw(
                '(SELECT MIN(CAST(product_sizes.price AS DECIMAL(10, 2))) FROM product_sizes WHERE product_sizes.product_id = products.id) ASC'
            );
        } elseif ($sort === 'price_high_low') {
            $Products->orderByRaw(
                '(SELECT MIN(CAST(product_sizes.price AS DECIMAL(10, 2))) FROM product_sizes WHERE product_sizes.product_id = products.id) DESC'
            );
        } elseif ($sort === 'oldest') {
            $Products->orderBy('created_at', 'asc');
        } else {
            $sort = 'latest';
            $Products->orderBy('created_at', 'desc');
        }

        $Products = $Products->paginate($perPage);

        return response()->json([
            'products' => $Products->items(),
            'pagination' => view('vendor.pagination.default', ['paginator' => $Products])->render(),
        ]);
    }

    public function productsDetails($id)
    {
        if ($id) {
            $Product = Product::where('status', 1)->where('id', $id)->first();
            if ($Product) {
                $relatedProducts = Product::where('id', '!=', $id)->where('category_id', $Product->category_id)->where('status', 1)->orderBy('id', 'DESC')->limit(7)->get();
                return view('front.products.products-details', ['Product' => $Product, 'relatedProducts' => $relatedProducts]);
            } else {
                return redirect()->back()->with('error', 'Somthing Went Wrong..!');
            }
        } else {
            return redirect()->back()->with('error', 'Product Not Found..!');
        }
    }

    public function productsDetailsAjax(Request $request)
    {
        $productId = $request->input('id');
        $product = Product::where('id', $productId)->first();
        if(!$product) {
            return response()->json(['error' => 'Product not found']);
        }
        $size = $product->sizes()->where('size_id', $request->size)->first();
        if ($size) {
            $price = $size->pivot->price;
        } else {
            $price = 0;
        }
        $product->price = $price;
        return response()->json(['success'=>true,'product'=>$product]);
    }

    public function productsSizeFloverAjax(Request $request)
    {
        $productId = $request->input('id');
        $product = Product::where('id', $productId)->first();
        if(!$product) {
            return response()->json(['error' => 'Product not found']);
        }
        $minPriceSize = $product->sizes->sortBy('pivot.price')->first();
        $size = $product->sizes()->where('size_id', $minPriceSize->id)->first();
        $flavor = $product->flavors->first();
        return response()->json(['success'=>true,'flavor'=>$flavor,'size'=>$size]);
    }


    public function productsCartPost(Request $request)
    {
        $request->validate([
            'product' => 'required|exists:products,id',
            'size' => 'required',
            'flavor' => 'required',
        ]);

        $product = Product::where('status', 1)->findOrFail($request->product);
        $cartItem = Cart::where('user_id', auth()->id())
            ->where('product_id', $request->product)
            ->where('size_id', $request->size)
            ->where('flavor_id', $request->flavor)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $request->quantity ? $request->quantity : 1;
            $cartItem->total_price = $cartItem->quantity * $cartItem->price;
            $cartItem->save();
        } else {
            $size = $product->sizes()->where('size_id', $request->size)->first();
            if ($size) {
                $price = $size->pivot->price;
            } else {
                $price = 0;
            }
            Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $request->product,
                'size_id' => $request->size,
                'flavor_id' => $request->flavor,
                'quantity' => $request->quantity,
                'total_price' => $request->quantity * $price,
                'price' => $price, // Adjust as needed for size/flavor-specific pricing
            ]);
        }
        return redirect()->route('front.products-cart')->with('message', 'Product added to cart successfully.');
    }

    public function productsCartAjax(Request $request)
    {
        $request->validate([
            'product' => 'required|exists:products,id',
            'size' => 'required',
            'flavor' => 'required',
        ]);

        $product = Product::where('status', 1)->where('id', $request->product)->first();
        if (!$product) {
            return response()->json(['error' => 'Somthing Went Wrong..!']);
        }
        $cartItem = Cart::where('user_id', auth()->id())
            ->where('product_id', $request->product)
            ->where('size_id', $request->size)
            ->where('flavor_id', $request->flavor)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $request->quantity ? $request->quantity : 1;
            $cartItem->total_price = $cartItem->quantity * $cartItem->price;
            $cartItem->save();
        } else {
            $size = $product->sizes()->where('size_id', $request->size)->first();
            if ($size) {
                $price = $size->pivot->price;
            } else {
                $price = 0;
            }
            Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $request->product,
                'size_id' => $request->size,
                'flavor_id' => $request->flavor,
                'quantity' => $request->quantity,
                'total_price' => $request->quantity * $price,
                'price' => $price, // Adjust as needed for size/flavor-specific pricing
            ]);
        }
        return response()->json(['success' => 'Item added to cart successfully.']);
        // return redirect()->back()->with('message', 'Product added to cart successfully.');
    }

    public function productsCartAjaxOther(Request $request)
    {
        $request->validate([
            'product' => 'required|exists:products,id',
        ]);

        $product = Product::where('status', 1)->where('id', $request->product)->first();
        if (!$product) {
            return response()->json(['error' => 'Somthing Went Wrong..!']);
        }
        $minPriceSize = $product->sizes->sortBy('pivot.price')->first();
        $flavor = $product->flavors->first();
        $cartItem = Cart::where('user_id', auth()->id())
            ->where('product_id', $request->product)
            ->where('size_id', $minPriceSize->id)
            ->where('flavor_id', $flavor->id)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $request->quantity ? $request->quantity : 1;
            $cartItem->total_price = $cartItem->quantity * $cartItem->price;
            $cartItem->save();
        } else {
            $size = $product->sizes()->where('size_id', $minPriceSize->id)->first();
            if ($size) {
                $price = $size->pivot->price;
            } else {
                $price = 0;
            }
            Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $request->product,
                'size_id' => $minPriceSize->id,
                'flavor_id' => $flavor->id,
                'quantity' => $request->quantity,
                'total_price' => $request->quantity * $price,
                'price' => $price, // Adjust as needed for size/flavor-specific pricing
            ]);
        }
        return response()->json(['success' => 'Item added to cart successfully.']);
        // return redirect()->back()->with('message', 'Product added to cart successfully.');
    }

    public function productsCartSync(Request $request)
    {
        $request->validate([
            'cartItems' => 'required|array',
            'cartItems.*.product' => 'required|exists:products,id',
            'cartItems.*.size' => 'required|string',
            'cartItems.*.flavor' => 'required|string',
            'cartItems.*.quantity' => 'required|integer|min:1',
        ]);

        $userId = auth()->id();

        foreach ($request->cartItems as $item) {
            $product = Product::where('status', 1)->findOrFail($item['product']);

            if ($product) {
                $existingCartItem = Cart::where('user_id', auth()->id())
                    ->where('product_id', $item['product'])
                    ->where('size_id', $item['size'])
                    ->where('flavor_id', $item['flavor'])
                    ->first();

                if ($existingCartItem) {
                    $existingCartItem->quantity += $item['quantity'] ? $item['quantity'] : 1;
                    $existingCartItem->total_price = $existingCartItem['quantity'] * $existingCartItem->price;
                    $existingCartItem->save();
                } else {
                    $size = $product->sizes()->where('size_id', $item['size'])->first();
                    if ($size) {
                        $price = $size->pivot->price;
                    } else {
                        $price = 0;
                    }
                    Cart::create([
                        'user_id' => $userId,
                        'product_id' => $item['product'],
                        'size_id' => $item['size'],
                        'flavor_id' => $item['flavor'],
                        'quantity' => $item['quantity'],
                        'total_price' => $item['quantity'] * $price,
                        'price' => $price,
                    ]);
                }
            }
        }
        return response()->json(['success' => 'Guest cart synced successfully']);
    }

    public function productsCartSyncOther(Request $request)
    {
        $request->validate([
            'cartItems' => 'required|array',
            'cartItems.*.product' => 'required|exists:products,id',
            'cartItems.*.quantity' => 'required|integer|min:1',
        ]);

        $userId = auth()->id();

        foreach ($request->cartItems as $item) {
            $product = Product::where('status', 1)->findOrFail($item['product']);
            if ($product) {
                $minPriceSize = $product->sizes->sortBy('pivot.price')->first();
                $flavor = $product->flavors->first();
                $existingCartItem = Cart::where('user_id', auth()->id())
                    ->where('product_id', $item['product'])
                    ->where('size_id', $minPriceSize->id)
                    ->where('flavor_id', $flavor->id)
                    ->first();

                if ($existingCartItem) {
                    $existingCartItem->quantity += $item['quantity'] ? $item['quantity'] : 1;
                    $existingCartItem->total_price = $existingCartItem['quantity'] * $existingCartItem->price;
                    $existingCartItem->save();
                } else {
                    $size = $product->sizes()->where('size_id', $minPriceSize->id)->first();
                    if ($size) {
                        $price = $size->pivot->price;
                    } else {
                        $price = 0;
                    }
                    Cart::create([
                        'user_id' => $userId,
                        'product_id' => $item['product'],
                        'size_id' => $minPriceSize->id,
                        'flavor_id' => $flavor->id,
                        'quantity' => $item['quantity'],
                        'total_price' => $item['quantity'] * $price,
                        'price' => $price,
                    ]);
                }
            }
        }
        return response()->json(['success' => 'Guest cart synced successfully']);
    }

    public function productsCartUpdateQuantity(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:carts,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = Cart::where('id', $request->id)->where('user_id', auth()->id())->first();
        if ($cartItem) {
            $cartItem->quantity = $request->quantity;
            $cartItem->total_price = $cartItem->quantity * $cartItem->price;
            $cartItem->save();
            $totalOrder = Cart::where('user_id', auth()->id())->sum('total_price');
            return response()->json(['success' => 'Quantity Updated Successfully.', 'totalOrder' => $totalOrder, 'totalPrice' => $cartItem->total_price]);
        } else {
            return response()->json(['error' => 'Somthing Went Wrong..!']);
        }
    }

    public function productsCartDeleteItem(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:carts,id',
        ]);

        $cartItem = Cart::where('id', $request->id)->where('user_id', auth()->id())->first();
        if ($cartItem) {
            $cartItem->delete();
            $totalOrder = Cart::where('user_id', auth()->id())->sum('total_price');
            return response()->json(['success' => 'Item Deleted Successfully.', 'totalOrder' => $totalOrder]);
        } else {
            return response()->json(['error' => 'Somthing Went Wrong..!']);
        }
    }

    public function productsCart()
    {
        if (Auth::check()) {
            $cartItems = Cart::where('user_id', auth()->id())->with('product')->get();
            return view('front.products.products-cart', compact('cartItems'));
        } else {
            return view('front.products.products-cart-guest');
        }
    }

    public function productsCheckout()
    {
        $subTotal = Cart::where('user_id', auth()->id())->sum('total_price');
        if ($subTotal == 0) {
            return redirect()->route('front.products')->with('error', 'Your Cart is Empty..!');
        }
        $user = User::find(Auth::user()->id);
        $shippingCharge = env('SHIPPING_CHARGE', 100);
        $totalOrder = $subTotal + $shippingCharge;
        return view('front.products.products-checkout', ['subTotal' => $subTotal,'user'=>$user, 'shippingCharge' => $shippingCharge, 'totalOrder' => $totalOrder]);
    }

    public function productsCompleted($id)
    {
        return view('front.products.products-completed',['id'=>$id]);
    }
}
