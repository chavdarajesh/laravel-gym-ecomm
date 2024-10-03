<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;

class PagesController extends Controller
{
    //

    public function home()
    {
        return view('front.pages.home');
    }
    public function about()
    {
        return view('front.pages.about');
    }
    public function services()
    {
        return view('front.pages.services');
    }
}
