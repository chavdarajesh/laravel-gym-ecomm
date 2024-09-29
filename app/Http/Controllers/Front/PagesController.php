<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\HomeSlider;
use App\Models\Newsletter;
use App\Models\Service;
use App\Models\SistersCompanyLogo;
use App\Models\Subcategory;
use App\Models\SubSubCategory;
use Illuminate\Http\Request;

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
}
