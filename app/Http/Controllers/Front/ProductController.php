<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ProductSlider;
use Illuminate\Http\Request;

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

        return view('front.products.products', compact('categories', 'brands', 'ProductSliders','Blogs'));
    }
}
