<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    //

    public function profilepage()
    {
        $user = User::find(Auth::user()->id);
        return view('front.profile.index', compact('user'));
    }
    public function postprofilepage(Request $request)
    {
        $request->validate([
            'name' => 'required|max:40',
            'email' => 'required',
            // 'phone' => 'required ',
            // 'username' => 'required ',
            // 'address' => 'required',
            // 'dateofbirth' => 'required',
        ]);
        $User = User::find(Auth::user()->id);
        $User->name = $request['name'];
        // $User->username = $request['username'];
        $User->email = $request['email'];
        // $User->phone = $request['phone'];
        // $User->address = $request['address'];
        // $User->dateofbirth = $request['dateofbirth'];
        // if ($request->profilephoto) {
        //     $folderPath = public_path('assets/users/profilephoto/' . Auth::user()->id . '/');
        //     if (!file_exists($folderPath)) {
        //         mkdir($folderPath, 0777, true);
        //     }
        //     $file = $request->file('profilephoto');
        //     $imageoriginalname = str_replace(" ", "-", $file->getClientOriginalName());
        //     $imageName = time() . $imageoriginalname;
        //     $file->move($folderPath, $imageName);
        //     $User->profileimage = 'assets/users/profilephoto/' . Auth::user()->id . '/' . $imageName;
        // }
        $User->save();

        if ($User) {
            return redirect()->route('front.profilepage')->with('message', 'User Update  Sucssesfully..');
        } else {
            return redirect()->back()->with('error', 'Somthing Went Wrong..');
        }
    }

    public function postprofilechangepassword(Request $request)
    {
        $request->validate([
            'oldpassword' => 'required',
            'newpassword' => 'min:6',
            'confirmnewpasswod' => 'required_with:newpassword|same:newpassword|min:6'
        ]);

        $user = User::find(Auth::user()->id);
        if (!Hash::check($request->oldpassword, $user->password)) {
            return redirect()->back()->with('error', 'Current password does not match!');
        }
        $user->password = Hash::make($request->newpassword);
        $user->save();
        Auth::logout();
        $request->session()->flush();
        return redirect()->route('front.login')->with('message', 'Password changed Successfully Please Login Again..');;
    }
}
