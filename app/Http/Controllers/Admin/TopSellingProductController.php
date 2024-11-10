<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\TopSellingProduct;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TopSellingProductController extends Controller
{
    //
    public function index()
    {
        $Products = Product::where('status', 1)->get();
        $TopSellingProducts = TopSellingProduct::pluck('product_id')->toArray();
        return view('admin.topsellingproducts.index', ['Products' => $Products, 'TopSellingProducts' => $TopSellingProducts]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'topsellingproducts' => 'required|array',
            'topsellingproducts.*' => 'exists:products,id',
        ]);
        TopSellingProduct::truncate();
        $newProductIds = $request->topsellingproducts;
        foreach ($newProductIds as $productId) {
            TopSellingProduct::create(['product_id' => $productId]);
        }
        return redirect()->route('admin.topsellingproducts.index')->with('message', 'TopSellingProduct Updated Sucssesfully..');
    }
}
