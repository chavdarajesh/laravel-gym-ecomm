<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\User\ForgotPassword;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function loginGet()
    {
        if (Auth::check()) {
            if (Auth::user() && Auth::user()->is_admin == 1 && Auth::user()->role == 'admin') {
                return redirect()->route('admin.dashboard')->with('message', 'Admin Login Successfully');
            }
            else if (Auth::user() && Auth::user()->is_user == 1 && Auth::user()->role == 'user') {
                return redirect()->route('user.dashboard')->with('message', 'User Login Successfully');
            } else {
                return redirect()->route('front.home')->with('error', 'User Not Access To Admin Site..!');
            }
        } else {
            return view('user.auth.login');
        }
    }
    public function loginSave(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email,status,1,is_verified,1',
            'password' => 'required|min:6',
        ]);
        if (!Auth::check()) {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'is_verified' => 1, 'status' => 1])) {
                if (Auth::user() && Auth::user()->is_admin == 1 && Auth::user()->role == 'admin') {
                    return redirect()->route('admin.dashboard')->with('message', 'Admin Login Successfully');
                }
                else if (Auth::user() && Auth::user()->is_user == 1 && Auth::user()->role == 'user') {
                    return redirect()->route('user.dashboard')->with('message', 'User Login Successfully');
                } else {
                    return redirect()->route('front.home')->with('error', 'User Not Access To Admin Site..!');
                }
            } else {
                return redirect()->back()->with('error', 'Invalid Credantials');
            }
        } else {
            if (Auth::user() && Auth::user()->is_admin == 1 && Auth::user()->role == 'admin') {
                return redirect()->route('admin.dashboard')->with('message', 'Admin Login Successfully');
            }
            else if (Auth::user() && Auth::user()->is_user == 1 && Auth::user()->role == 'user') {
                return redirect()->route('user.dashboard')->with('message', 'User Login Successfully');
            } else {
                return redirect()->route('front.home')->with('error', 'User Not Access To Admin Site..!');
            }
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->flush();
        return redirect()->route('user.login.get')->with('message', 'User Logout Successfully');
    }

    public function passwordForgotGet()
    {
        return view('user.auth.forgot-password');
    }
    public function passwordForgotSave(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email,status,1,is_verified,1',
        ]);
        if(env('MAIL_FROM_ADDRESS') == '') {
           return redirect()->back()->with('error', 'Somthing Went Wrong..!');
       }
        $token = Str::random(64);
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now('Asia/Kolkata'),
        ]);
        $data = [
            'token' => $token,
        ];
        $mail = Mail::to($request->email)->send(new ForgotPassword($data));
        return redirect()->route('user.login.get')->with('message', 'Password Reset Link send Successfully To Your Email..');
    }

    public function passwordResetGet($token)
    {
        if (isset($token) && $token != '') {
            return view('user.auth.showresetpasswordform', ['token' => $token]);
        } else {
            return redirect()->back()->with('error', 'Somthing Went Wrong..');
        }
    }
    public function passwordResetSave(Request $request)
    {
        $request->validate([
            'newpassword' => 'required|min:6',
            'confirmnewpassword' => 'required|same:newpassword|min:6',
        ]);
        if (!isset($request->token) || $request->token == '') {
            return redirect()->back()->with('error', 'Somthing Went Wrong..');
        }

        $updatePassword = DB::table('password_resets')->where('token', $request->token)->first();
        if (!$updatePassword) {
            return back()->withInput()->with('error', 'Invalid token!');
        }
        $user = User::where('email', $updatePassword->email)
            ->update(['password' => Hash::make($request->newpassword)]);
        DB::table('password_resets')->where(['email' => $updatePassword->email])->delete();
        if ($user) {
            return redirect()->route('user.login.get')->with('message', 'Your Password Has Been Updated!');
        } else {
            return redirect()->back()->with('error', 'Somthing Went Wrong..');
        }
    }
}
