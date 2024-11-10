<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactUsSetting;
use App\Models\ContactUsEnquiry;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\Facades\DataTables;

class ContactController extends Controller
{
    //
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = ContactUsEnquiry::all();
            return DataTables::of($data)
                ->addColumn('id', function ($row) {
                    return '<strong>' . $row->id . '</strong>';
                })
                ->addColumn('goal', function ($row) {
                    return strlen($row->goal) > 25 ? substr($row->goal, 0, 25) . '..' : $row->goal;
                })
                ->addColumn('actions', function ($row) {
                    $data['id'] = $row->id;
                    return View::make('admin.contact.messages.actions', ['data' => $data])->render();
                })
                ->rawColumns(['id', 'actions', 'subject', 'message'])
                ->make(true);
        } else {
            return view('admin.contact.messages.index');
        }
    }

    public function delete($id)
    {
        if ($id) {
            $ContactUsEnquiry = ContactUsEnquiry::find($id);
            $ContactUsEnquiry = $ContactUsEnquiry->delete();
            if ($ContactUsEnquiry) {
                return redirect()->route('admin.contact.messages.index')->with('message', 'Contact Message Deleted Sucssesfully..');
            } else {
                return redirect()->back()->with('error', 'Somthing Went Wrong..!');
            }
        } else {
            return redirect()->back()->with('error', 'Contact Message Not Found..!');
        }
    }

    public function view($id)
    {
        $ContactUsEnquiry = ContactUsEnquiry::find($id);
        if ($ContactUsEnquiry) {
            return view('admin.contact.messages.view', ['ContactUsEnquiry' => $ContactUsEnquiry]);
        } else {
            return redirect()->back()->with('error', 'Contact Message Not Found..!');
        }
    }

    public function indexContactSettings()
    {
        $ContactUsSetting = ContactUsSetting::where('static_id', 1)->where('status', 1)->first();
        return view('admin.contact.settings.index', ['ContactUsSetting' => $ContactUsSetting]);
    }
    public function saveContactSettings(Request $request)
    {
        $request->validate([
            'email' => 'email',
            // 'phone' => 'min:10'
        ]);

        $ContactUsSetting = ContactUsSetting::find($request->id);
        $ContactUsSetting->email = $request['email'];
        $ContactUsSetting->phone = $request['phone'];
        $ContactUsSetting->address_1 = $request['address_1'];
        $ContactUsSetting->address_2 = $request['address_2'];
        $ContactUsSetting->map_iframe = $request['map_iframe'];
        $ContactUsSetting->timing = $request['timing'];
        $ContactUsSetting->update();
        if ($ContactUsSetting) {
            return redirect()->route('admin.contact.settings.index')->with('message', 'ContactUsSetting Saved Sucssesfully..');
        } else {
            return redirect()->back()->with('error', 'Somthing Went Wrong..');
        }
    }
}
