<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Blog;
use App\Models\User;
use App\Models\Comment;
use App\Models\ContactMessage;
use App\Models\ContactUsEnquiry;

class DashboardController extends Controller
{
    //
    public function __construct()
    {
    }
    public function dashboard()
    {
        $data['Total_Users'] = User::count();
        $data['Total_Verified_Users'] = User::where('is_verified', 1)->count();
        $data['Total_Not_Verified_Users'] = User::where('is_verified', 0)->count();
        $data['Total_Active_Users'] = User::where('status', 1)->count();
        $data['Total_Not_Active_Users'] = User::where('status', 0)->count();

        // $data['Total_Blogs'] = Blog::count();
        // $data['Total_Active_Blogs'] = Blog::where('status', 1)->count();
        // $data['Total_In_Active_Blogs'] = Blog::where('status', 0)->count();

        // $data['Total_Comments'] = Comment::count();
        $data['Total_Contact_Messages'] = ContactUsEnquiry::count();

        // $data['Total_All_Blogs'] = Blog::withTrashed()->count();
        return view('admin.dashboard', ['data' => $data]);
    }
}
