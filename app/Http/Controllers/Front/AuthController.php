<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Mail\User\ForgotPassword;
use App\Mail\User\OTPVerification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //

    public function login()
    {
        if (!Auth::check()) {
            return view('front.auth.login');
        } else {
            return redirect()->route('front.home')->with('message', 'User Login Successfully');
        }
    }
    public function register()
    {
        if (!Auth::check()) {
            return view('front.auth.register');
        } else {
            return redirect()->route('front.home')->with('message', 'User Login Successfully');
        }
    }

    public function postregister(Request $request)
    {
        $request->validate([
            'name' => 'required|max:40',
            'email' => 'required|email',
            'phone' => 'required |unique:users,phone,NULL,id,deleted_at,NULL',
            'address' => 'required',
            // 'dateofbirth' => 'required',
            'password' => 'required|min:6',
            // 'accept_t_c' => 'required',
        ]);
        // if ($request['referral_code']) {
        //     $request->validate([
        //         'referral_code' => 'exists:users',
        //     ]);
        // }

        $user_email_check_is_verified  = User::where([['email',$request->email],['is_verified','0']])->first();
        if ($user_email_check_is_verified) {
            $random_pass = rand(100000, 999999);
            $user_email_check_is_verified->otp = $random_pass;
            $user_email_check_is_verified->save();

            if ($user_email_check_is_verified) {
                $data = [
                    'otp' => $random_pass
                ];
                $user_id = encrypt($user_email_check_is_verified->id);
                Mail::to($request->email)->send(new OTPVerification($data));
            }
            return redirect()->route('front.otp_verification.get', ['id' => $user_id])->with('error', 'User Already Exist..! Please Verify Your Email..');
        }
        $user_email_check_verified  = User::where([['email',$request->email],['is_verified','1']])->first();
        if ($user_email_check_verified) {
            return redirect()->back()->with('error', 'User Already Exist..! Please Login..');
        }



        $user = new User();
        $user->name = $request['name'];
        $user->email = $request['email'];
        $user->phone = $request['phone'];
        $user->address = $request['address'];
        // $user->dateofbirth = $request['dateofbirth'];
        // $user->referral_code = Str::slug($request['name'], "-").Str::slug($request['email'], "-");
        // $user->other_referral_code = $request['referral_code'] ? $request['referral_code'] : '';
        $random_pass = rand(100000, 999999);
        $user->password =Hash::make($request['password']);
        $user->otp = $random_pass;
        $user->save();

        if ($user) {
            $data = [
                'otp' => $random_pass
            ];
            $user_id = encrypt($user->id);
            Mail::to($request->email)->send(new OTPVerification($data));
            // return view('front.auth.otp_verification', ['email' => $request->email, 'user_id' => $user->id])->with('message', 'Please Enter OTP To Verify Your Account..');
            return redirect()->route('front.otp_verification.get', ['id' => $user_id])->with('message', 'Otp Send To Your Email. Please Enter OTP To Verify Your Account..');
        } else {
            return redirect()->back()->with('error', 'Somthing Went Wrong..');
        }
    }
    public function showotp_verificationFormget($id)
    {
        $id = decrypt($id);
        if ($id) {
            return view('front.auth.otp_verification', ['user_id' => $id])->with('message', 'Please Enter OTP To Verify Your Account..');
        } else {
            return redirect()->back()->with('error', 'Somthing Went Wrong..');
        }
    }
    public function postotp_verification(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'email' => 'required|email|exists:users',
            'otp' => 'required|min:6|max:6',
        ]);

        $user_email_check  = User::where([['email', '=', $request->email]])->first();
        if ($user_email_check) {

            $user  = User::where([['id', '=', $request->user_id], ['otp', '=', $request->otp], ['email', '=', $request->email]])->first();
            if ($user) {
                User::where('id', '=', $request->user_id)->where('email', '=', $request->email)->update(['otp' => null, 'is_verified' => 1]);
                User::where('id', '=', $request->user_id)->where('email', '=', $request->email)->update(['email_verified_at' =>  Carbon::now('Asia/Kolkata')]);
                Auth::login($user);
                return redirect()->route('front.home')->with('message', 'Account Created Successfully..');
            } else {
                return redirect()->back()->with('error', 'OTP Is Invalid..!');
            }
        } else {
            return redirect()->back()->with('error', 'OTP Is Invalid..!!');
        }
    }

    public function postlogin(Request $request)
    {
        $ValidatedData = Validator::make($request->all(), [
            'login_email' => 'required',
            'login_password' => 'required|min:6',
            // 'accept_t_c' => 'required',
        ]);
        if ($ValidatedData->fails()) {
            return redirect()->back()->with('error', 'All Filed Require..!');
        } else {
            if (Auth::attempt(['email' => $request->login_email, 'password' => $request->login_password, 'is_verified' => 1, 'status' => 1])) {
                if (Auth::user()->email_verified_at != null && Auth::user()->otp == null) {
                    return redirect()->route('front.home')->with('message', 'User Login Successfully');
                } else {
                    Auth::logout();
                    $request->session()->flush();
                    return redirect()->back()->with('error', 'User Not Verified...');
                }
            } else {
                return redirect()->back()->with('error', 'Invalid Credantials');
            }
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->flush();
        return redirect()->route('front.home')->with('message', 'User Logout Successfully');;
    }

    public function forgotpasswordget()
    {
        return view('front.auth.forget_password');
    }

    public function postforgotpassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users'
        ]);
        $user = User::where('email', $request->email)->where('status', 1)->where('is_verified', 1)->first();
        if ($user) {
            $token = Str::random(64);
            DB::table('password_resets')->insert([
                'email' => $request->email,
                'token' => $token,
                'created_at' => Carbon::now('Asia/Kolkata'),
            ]);
            $data = [
                'token' => $token
            ];
            Mail::to($request->email)->send(new ForgotPassword($data));
            return redirect()->route('front.login')->with('message', 'Password Reset Link send Successfully Please Check your Email..');
        } else {
            return redirect()->back()->with('error', 'User Not Found..!');
        }
    }

    public function showResetPasswordFormget($token)
    {
        return view('front.auth.showresetpasswordform', ['token' => $token]);
    }

    public function submitResetPasswordFormpost(Request $request)
    {
        $request->validate([
            'newpassword' => 'required|min:6',
            'confirmnewpasswod' => 'required|same:newpassword|min:6'
        ]);

        $updatePassword = DB::table('password_resets')->where('token', $request->token)->first();
        if (!$updatePassword) {
            return back()->withInput()->with('error', 'Invalid token!');
        }
        $user = User::where('email', $updatePassword->email)
            ->update(['password' => Hash::make($request->newpassword)]);
        DB::table('password_resets')->where(['email' => $updatePassword->email])->delete();
        if ($user) {
            return redirect()->route('front.login')->with('message', 'Your password has been changed!');
        } else {
            return redirect()->route('front.login')->with('error', 'Somthing Went Wrong..!');
        }
    }
}
