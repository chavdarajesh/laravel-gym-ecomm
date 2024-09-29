@php $current_route_name=Route::currentRouteName();
use App\Models\SiteSetting;
$headerLogo = SiteSetting::getSiteSettings('header_logo');
$loader = SiteSetting::getSiteSettings('loader');
@endphp

<!-- Spinner Start -->
@if(isset($loader))
<div id="preloader-active">
    <div class="preloader d-flex align-items-center justify-content-center">
        <div class="preloader-inner position-relative">
            <div class="preloader-circle"></div>
            <div class="preloader-img pere-text">
                <img src="{{ isset($loader) && isset($loader->value) && $loader != null ? asset($loader->value) : asset('custom-assets/default/admin/images/siteimages/logo/loder.png') }}" alt="">
            </div>
        </div>
    </div>
</div>
@endif
<!-- Spinner End -->

<!--header section start -->
<header>
    <!-- Header Start -->
    <div class="header-area header-transparent">
        <div class="main-header header-sticky">
            <div class="container-fluid">
                <div class="menu-wrapper d-flex align-items-center justify-content-between">
                    <!-- Logo -->
                    <div class="logo">
                        <a href="{{route('front.home')}}"><img src="{{ isset($headerLogo) && isset($headerLogo->value) && $headerLogo != null ? asset($headerLogo->value) : asset('custom-assets/default/admin/images/siteimages/logo/header-logo.png') }}" alt="Logo"></a>
                    </div>
                    <!-- Main-menu -->
                    <div class="main-menu f-right d-none d-lg-block">
                        <nav>
                            <ul id="navigation">
                                <li class="{{ Route::currentRouteName() == 'front.home' ? 'active' : '' }}"><a href="{{route('front.home')}}">Home</a></li>
                                <li class="{{ Route::currentRouteName() == 'front.about' ? 'active' : '' }}"><a href="{{ route('front.about') }}">About</a></li>
                                <li><a href="courses.html">Courses</a></li>
                                <li><a href="pricing.html">Pricing</a></li>
                                <li><a href="gallery.html">Gallery</a></li>
                                <li><a href="blog.html">Blog</a>
                                    <ul class="submenu">
                                        <li><a href="blog.html">Blog</a></li>
                                        <li><a href="blog_details.html">Blog Details</a></li>
                                        <li><a href="elements.html">Elements</a></li>
                                    </ul>
                                </li>
                                <li class="{{ Route::currentRouteName() == 'front.contact' ? 'active' : '' }}"><a href="{{ route('front.contact') }}">Contact</a></li>
                            </ul>
                        </nav>
                    </div>
                    <!-- Header-btn -->
                    <div class="header-btns d-none d-lg-block f-right">
                        <a href="{{ route('front.contact') }}" class="btn">Contact me</a>
                    </div>
                    <!-- Mobile Menu -->
                    <div class="col-12">
                        <div class="mobile_menu d-block d-lg-none"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->
</header>
<!--header section end -->
