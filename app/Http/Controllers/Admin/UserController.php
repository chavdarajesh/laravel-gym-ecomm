<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    //
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = User::where('is_admin',0)->get();
            return DataTables::of($data)
                ->addColumn('id', function ($row) {
                    return '<strong>' . $row->id . '</strong>';
                })
                // ->addColumn('referCount', function ($row) {
                //     return '<a href="' . route("admin.users.referrals", $row->id) . '"><span class="badge badge-center bg-success">' . User::get_total_use_referral_user_by_id($row->id) . '</span></a>';
                // })
                ->addColumn('name', function ($row) {
                    return '<a href="' . route("admin.users.view", $row->id) . '">' . $row->name . '</a>';
                })
                ->addColumn('status', function ($row) {
                    $data['id'] = $row->id;
                    $data['status'] = $row->status;
                    return View::make('admin.users.status', ['data' => $data])->render();
                })
                ->addColumn('verify', function ($row) {
                    $data['id'] = $row->id;
                    $data['is_verified'] = $row->is_verified;
                    return View::make('admin.users.verify', ['data' => $data])->render();
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at ? Carbon::parse($row->created_at)->setTimezone('Asia/Kolkata')->toDateTimeString() : '';
                })
                ->addColumn('actions', function ($row) {
                    $data['id'] = $row->id;
                    return View::make('admin.users.actions', ['data' => $data])->render();
                })
                ->rawColumns(['id', 'actions', 'status', 'created_at', 'name', 'verify'])
                ->make(true);
        } else {
            return view('admin.users.index');
        }
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function save(Request $request)
    {
        $request->validate([
            'name' => 'required|max:40',
            'email' => 'required|unique:users,email,NULL,id,deleted_at,NULL',
            'phone' => 'required |unique:users,phone,NULL,id,deleted_at,NULL',
            'address' => 'required',
            // 'dateofbirth' => 'required',
            'password' => 'required|min:6',
            'confirmpassword' => 'required_with:password|same:password|min:6',
            // 'image' => 'file|image|mimes:jpeg,png,jpg,gif|max:5000',
            // 'referral_code' => 'nullable|exists:users,referral_code',
        ]);

        $User = new User();
        $User->name = $request['name'];
        $User->email = $request['email'];
        $User->phone = $request['phone'];
        $User->address = $request['address'];
        // $User->dateofbirth = $request['dateofbirth'];
        $User->status = 1;
        $User->is_verified = 1;
        $User->is_user = 1;
        $User->is_admin = 0;
        $User->role = 'user';
        $User->created_at = Carbon::now('Asia/Kolkata');
        $User->email_verified_at = Carbon::now('Asia/Kolkata');
        $User->otp = null;
        $User->password = Hash::make($request->password);
        // $User->referral_code = Str::slug($request['email'], "-");

        // if($request['referral_code']){
        //     $reffredUser = User::where('referral_code', $request['referral_code'])->first();
        //     $User->other_referral_user_id = $reffredUser ? $reffredUser->id : null;
        // }

        // if ($request->image) {
        //     $folderPath = public_path('custom-assets/upload/admin/images/users/image/');
        //     if (!file_exists($folderPath)) {
        //         mkdir($folderPath, 0777, true);
        //     }
        //     $file = $request->file('image');
        //     $imageoriginalname = str_replace(" ", "-", $file->getClientOriginalName());
        //     $imageName = rand(1000, 9999) . time() . $imageoriginalname;
        //     $file->move($folderPath, $imageName);
        //     $User->image = 'custom-assets/upload/admin/images/users/image/' . $imageName;
        //     if ($request->old_image && file_exists(public_path($request->old_image))) {
        //         unlink(public_path($request->old_image));
        //     }
        // }
        $User->save();
        if ($User) {
            return redirect()->route('admin.users.index')->with('message', 'User Added Sucssesfully..');
        } else {
            return redirect()->back()->with('error', 'Somthing Went Wrong..');
        }
    }

    public function edit($id)
    {
        $User = User::find($id);
        if ($User) {
            return view('admin.users.edit', ['User' => $User]);
        } else {
            return redirect()->back()->with('error', 'User Not Found..!');
        }
    }
    public function view($id)
    {
        $User = User::find($id);
        if ($User) {
            return view('admin.users.view', ['User' => $User]);
        } else {
            return redirect()->back()->with('error', 'User Not Found..!');
        }
    }

    public function update(Request $request)
    {
        if ($request->id) {
            $request->validate([
                'name' => 'required|max:40',
                'email' => 'required|email|unique:users,email,' . $request->id,
                'phone' => 'required|unique:users,phone,' . $request->id,
                'address' => 'required',
                // 'dateofbirth' => 'required',
                'password' => 'nullable|min:6',
                'confirmpassword' => 'nullable|same:password|min:6',
                // 'image' => 'file|image|mimes:jpeg,png,jpg,gif|max:5000',
                // 'referral_code' => 'nullable|exists:users',
            ]);

            $User = User::find($request->id);
            $User->name = $request['name'];
            $User->email = $request['email'];
            $User->phone = $request['phone'];
            $User->address = $request['address'];
            // $User->dateofbirth = $request['dateofbirth'];
            // if ($request->image) {
            //     $folderPath = public_path('custom-assets/upload/admin/images/users/image/');
            //     if (!file_exists($folderPath)) {
            //         mkdir($folderPath, 0777, true);
            //     }
            //     $file = $request->file('image');
            //     $imageoriginalname = str_replace(" ", "-", $file->getClientOriginalName());
            //     $imageName = rand(1000, 9999) . time() . $imageoriginalname;
            //     $file->move($folderPath, $imageName);
            //     $User->image = 'custom-assets/upload/admin/images/users/image/' . $imageName;
            //     if ($request->old_image && file_exists(public_path($request->old_image))) {
            //         unlink(public_path($request->old_image));
            //     }
            // }
            if ($request->password) {
                $User->password = Hash::make($request->password);
            }
            // if($request['referral_code']){
            //     $reffredUser = User::where('referral_code', $request['referral_code'])->first()->id;
            //     $User->other_referral_user_id = $reffredUser ? $reffredUser->id : null;
            // }
            $User->save();
            if ($User) {
                return redirect()->route('admin.users.index')->with('message', 'User Update Sucssesfully..');
            } else {
                return redirect()->back()->with('error', 'Somthing Went Wrong..');
            }
        } else {
            return redirect()->back()->with('error', 'Somthing Went Wrong..');
        }
    }

    public function delete($id)
    {
        if ($id) {
            $User = User::find($id);
            if ($User->image && file_exists(public_path($User->image))) {
                unlink(public_path($User->image));
            }
            $User = $User->delete();
            if ($User) {
                return redirect()->route('admin.users.index')->with('message', 'User Deleted Sucssesfully..');
            } else {
                return redirect()->back()->with('error', 'Somthing Went Wrong..!');
            }
        } else {
            return redirect()->back()->with('error', 'User Not Found..!');
        }
    }

    public function statusToggle(Request $request)
    {
        if ($request->id) {
            $User = User::find($request->id);
            $User->status = $request->status;
            $User = $User->update();
            if ($User) {
                return response()->json(['success' => 'Status Update Successfully.']);
            } else {
                return response()->json(['error' => 'Somthing Went Wrong..!']);
            }
        } else {
            return response()->json(['error' => 'User Not Found..!']);
        }
    }

    public function verifyToggle(Request $request)
    {
        if ($request->id) {
            $User = User::find($request->id);
            $User->is_verified = $request->is_verified;
            $User = $User->update();
            if ($User) {
                return response()->json(['success' => 'Verified Status Update Successfully.']);
            } else {
                return response()->json(['error' => 'Somthing Went Wrong..!']);
            }
        } else {
            return response()->json(['error' => 'User Not Found..!']);
        }
    }

    public function userReferrals(Request $request, $id)
    {
        if ($id) {
            $User = User::find($id);
            if ($request->ajax()) {
                $data = User::where('other_referral_user_id', $id)->get();
                return DataTables::of($data)
                    ->addColumn('id', function ($row) {
                        return '<strong>' . $row->id . '</strong>';
                    })
                    ->addColumn('name', function ($row) {
                        return '<a href="' . route("admin.users.view", $row->id) . '">' . $row->name . '</a>';
                    })
                    ->addColumn('status', function ($row) {
                        $data['id'] = $row->id;
                        $data['status'] = $row->status;
                        return View::make('admin.users.status', ['data' => $data])->render();
                    })
                    ->addColumn('verify', function ($row) {
                        $data['id'] = $row->id;
                        $data['is_verified'] = $row->is_verified;
                        return View::make('admin.users.verify', ['data' => $data])->render();
                    })
                    ->addColumn('created_at', function ($row) {
                        return $row->created_at ? Carbon::parse($row->created_at)->setTimezone('Asia/Kolkata')->toDateTimeString() : '';
                    })
                    ->addColumn('actions', function ($row) {
                        $data['id'] = $row->id;
                        return View::make('admin.users.actions', ['data' => $data])->render();
                    })
                    ->rawColumns(['id', 'actions', 'status', 'created_at', 'name', 'verify'])
                    ->make(true);
            } else {
                return view('admin.users.referrals', ['User' => $User]);
            }
        } else {
            return redirect()->back()->with('error', 'User Not Found..');
        }
    }
}
