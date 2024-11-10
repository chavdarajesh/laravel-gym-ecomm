<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductSlider;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\Facades\DataTables;

class ProductSliderController extends Controller
{
    //
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = ProductSlider::all();
            return DataTables::of($data)
                ->addColumn('id', function ($row) {
                    return '<strong>' . $row->id . '</strong>';
                })
                ->addColumn('name', function ($row) {
                    return strlen($row->name) > 25 ? substr($row->name, 0, 25) . '..' : $row->name;
                })
                ->addColumn('order', function ($row) {
                    return '<strong>' . $row->order . '</strong>';
                })
                ->addColumn('status', function ($row) {
                    $data['id'] = $row->id;
                    $data['status'] = $row->status;
                    return View::make('admin.productsliders.status', ['data' => $data])->render();
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at ? Carbon::parse($row->created_at)->setTimezone('Asia/Kolkata')->toDateTimeString() : '';
                })
                ->addColumn('actions', function ($row) {
                    $data['id'] = $row->id;
                    return View::make('admin.productsliders.actions', ['data' => $data])->render();
                })
                ->rawColumns(['id', 'actions', 'status', 'created_at', 'name', 'order'])
                ->make(true);
        } else {
            return view('admin.productsliders.index');
        }
    }
    public function create()
    {
        $Products = Product::where('status', 1)->get();
        return view('admin.productsliders.create', ['Products' => $Products]);
    }
    public function save(Request $request)
    {
        $request->validate([
            'image' => 'required|file|image|mimes:jpeg,png,jpg,gif|max:5000',
            'product' => 'exists:products,id',
            'order' => 'nullable|numeric',

        ]);
        $ProductSlider = new ProductSlider();
        $ProductSlider->name = $request['name'];
        $ProductSlider->product_id = $request['product'];
        $ProductSlider->order = $request['order'] ? $request['order'] : 0;
        $ProductSlider->status = 1;

        if ($request->image) {
            if ($request->old_image && file_exists(public_path($request->old_image))) {
                unlink(public_path($request->old_image));
            }
            $folderPath = public_path('custom-assets/upload/admin/images/productsliders/images/');
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);
            }
            $file = $request->file('image');
            $imageoriginalname = str_replace(" ", "-", $file->getClientOriginalName());
            $imageName = rand(1000, 9999) . time() . $imageoriginalname;
            $file->move($folderPath, $imageName);
            $ProductSlider->image = 'custom-assets/upload/admin/images/productsliders/images/' . $imageName;
        }
        $ProductSlider->save();
        if ($ProductSlider) {
            return redirect()->route('admin.productsliders.index')->with('message', 'ProductSlider Added Sucssesfully..');
        } else {
            return redirect()->back()->with('error', 'Somthing Went Wrong..');
        }
    }
    public function view($id)
    {
        $ProductSlider = ProductSlider::find($id);
        if ($ProductSlider) {
            return view('admin.productsliders.view', ['ProductSlider' => $ProductSlider]);
        } else {
            return redirect()->back()->with('error', 'ProductSlider Not Found..!');
        }
    }

    public function edit($id)
    {
        $ProductSlider = ProductSlider::find($id);
        if ($ProductSlider) {
            $Products = Product::where('status', 1)->get();
            return view('admin.productsliders.edit', ['ProductSlider' => $ProductSlider, 'Products' => $Products]);
        } else {
            return redirect()->back()->with('error', 'ProductSlider Not Found..!');
        }
    }

    public function update(Request $request)
    {
        $request->merge(['has_old_image' => $request->old_image ? true : false]);
        $request->validate([
            'product' => 'exists:products,id',
            'order' => 'nullable|numeric',
            'image' => [
                'required_if:has_old_image,false',
                'file',
                'image',
                'mimes:jpeg,png,jpg,gif',
                'max:5000',
            ],
        ]);


        $ProductSlider = ProductSlider::find($request->id);
        if ($ProductSlider) {
            $ProductSlider->name = $request['name'];
            $ProductSlider->product_id = $request['product'];
            $ProductSlider->order = $request['order'] ? $request['order'] : 0;

            if ($request->image) {
                $folderPath = public_path('custom-assets/upload/admin/images/productsliders/images/');
                if (!file_exists($folderPath)) {
                    mkdir($folderPath, 0777, true);
                }
                $file = $request->file('image');
                $imageoriginalname = str_replace(" ", "-", $file->getClientOriginalName());
                $imageName = rand(1000, 9999) . time() . $imageoriginalname;
                $file->move($folderPath, $imageName);
                $ProductSlider->image = 'custom-assets/upload/admin/images/productsliders/images/' . $imageName;
                if ($request->old_image && file_exists(public_path($request->old_image))) {
                    unlink(public_path($request->old_image));
                }
            }
            $ProductSlider->update();
            if ($ProductSlider) {
                return redirect()->route('admin.productsliders.index')->with('message', 'ProductSlider Updated Sucssesfully..');
            } else {
                return redirect()->back()->with('error', 'Somthing Went Wrong..');
            }
        } else {
            return redirect()->back()->with('error', 'ProductSlider Not Found..!');
        }
    }

    public function delete($id)
    {
        if ($id) {
            $ProductSlider = ProductSlider::find($id);
            if ($ProductSlider->image && file_exists(public_path($ProductSlider->image))) {
                unlink(public_path($ProductSlider->image));
            }
            $ProductSlider = $ProductSlider->delete();
            if ($ProductSlider) {
                return redirect()->route('admin.productsliders.index')->with('message', 'ProductSlider Deleted Sucssesfully..');
            } else {
                return redirect()->back()->with('error', 'Somthing Went Wrong..!');
            }
        } else {
            return redirect()->back()->with('error', 'ProductSlider Not Found..!');
        }
    }

    public function statusToggle(Request $request)
    {
        if ($request->id) {
            $ProductSlider = ProductSlider::find($request->id);
            $ProductSlider->status = $request->status;
            $ProductSlider = $ProductSlider->update();
            if ($ProductSlider) {
                return response()->json(['success' => 'Status Updated Successfully.']);
            } else {
                return response()->json(['error' => 'Somthing Went Wrong..!']);
            }
        } else {
            return response()->json(['error' => 'ProductSlider Not Found..!']);
        }
    }
}
