<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Newsletter;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\Facades\DataTables;

class NewsletterController extends Controller
{
    //

    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = Newsletter::all();
            return DataTables::of($data)
                ->addColumn('id', function ($row) {
                    return '<strong>' . $row->id . '</strong>';
                })
                ->addColumn('status', function ($row) {
                    $data['id'] = $row->id;
                    $data['status'] = $row->status;
                    return View::make('admin.newsletters.status', ['data'=>$data])->render();
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at ? Carbon::parse($row->created_at)->setTimezone('Asia/Kolkata')->toDateTimeString() : '';
                })
                ->addColumn('actions', function ($row) {
                    $data['id'] = $row->id;
                    return View::make('admin.newsletters.actions', ['data' => $data])->render();
                })
                ->rawColumns(['id', 'actions', 'status', 'created_at'])
                ->make(true);
        } else {
            return view('admin.newsletters.index');
        }
    }

    public function delete($id)
    {
        if ($id) {
            $Newsletter = Newsletter::find($id);
            $Newsletter = $Newsletter->delete();
            if ($Newsletter) {
                return redirect()->route('admin.newsletters.index')->with('message', 'Newsletter Deleted Sucssesfully..');
            } else {
                return redirect()->back()->with('error', 'Somthing Went Wrong..!');
            }
        } else {
            return redirect()->back()->with('error', 'Newsletter Not Found..!');
        }
    }

    public function statusToggle(Request $request)
    {
        if ($request->id) {
            $GoogleReview = Newsletter::find($request->id);
            $GoogleReview->status = $request->status;
            $GoogleReview = $GoogleReview->update();
            if ($GoogleReview) {
                return response()->json(['success' => 'Status Updated Successfully.']);
            } else {
                return response()->json(['error' => 'Somthing Went Wrong..!']);
            }
        } else {
            return response()->json(['error' => 'GoogleReview Not Found..!']);
        }
    }
}
