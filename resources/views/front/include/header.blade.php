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
                        <a href="{{route('front.home')}}"><img width="80px" src="{{ isset($headerLogo) && isset($headerLogo->value) && $headerLogo != null ? asset($headerLogo->value) : asset('custom-assets/default/admin/images/siteimages/logo/header-logo.png') }}" alt="Logo"></a>
                    </div>
                    <!-- Main-menu -->
                    <div class="main-menu f-right d-none d-lg-block">
                        <nav>
                            <ul id="navigation">
                                <li class="{{ Route::currentRouteName() == 'front.home' ? 'active' : '' }}"><a class="nav-item-a" href="{{route('front.home')}}">Home</a></li>
                                <li class="{{ Route::currentRouteName() == 'front.about' ? 'active' : '' }}"><a class="nav-item-a" href="{{ route('front.about') }}">About</a></li>
                                <li class="{{ Route::currentRouteName() == 'front.services' ? 'active' : '' }}"><a class="nav-item-a" href="{{ route('front.services') }}">Services</a></li>
                                <li class="{{ Route::currentRouteName() == 'front.products' ? 'active' : '' }}"><a class="nav-item-a" href="{{ route('front.products') }}">Nutrition & Supplements</a></li>
                                <li class="{{ Route::currentRouteName() == 'front.blogs' ? 'active' : '' }}"><a class="nav-item-a" href="{{ route('front.blogs') }}">Blog</a></li>
                                @if (Auth::check())
                                <li class="nav-item dropdown">
                                    <a class="nav-item-a nav-link dropdown-toggle" href="javascript:void(0);" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Account
                                    </a>
                                    <div class="dropdown-menu p-0" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item text-center" href="#">Profile</a>
                                        <div>
                                            <form action="{{ route('front.post.logout') }}" method="POST">
                                                @csrf
                                                {{-- <a href="{{ route('front.all_emipage') }}">Log Out</a> --}}
                                                <button class="btn w-100" type="submit">
                                                    Log Out
                                                </button>
                                        </div>
                                    </div>
                                </li>
                                @else
                                <li class="nav-item dropdown">
                                    <a class="nav-item-a nav-link dropdown-toggle" href="javascript:void(0);" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Account
                                    </a>
                                    <div class="dropdown-menu p-0" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item text-center" href="#">Register</a>
                                        <a class="dropdown-item text-center" href="{{route('front.login')}}">Login</a>
                                    </div>
                                </li>
                                @endif

                                <li class="d-block d-lg-none {{ Route::currentRouteName() == 'front.products-cart' ? 'active' : '' }}"><a class="nav-item-a" href="{{ route('front.products-cart') }}">Cart</a></li>
                                <li class="d-block d-lg-none {{ Route::currentRouteName() == 'front.contact' ? 'active' : '' }}"><a class="nav-item-a" href="{{ route('front.contact') }}">Contact</a></li>
                            </ul>
                        </nav>
                    </div>
                    <!-- Header-btn -->
                    <div class="header-btns d-none d-lg-block f-right">
                        <a class="mx-1 text-dark" href="{{ route('front.products-cart') }}"><i class="fas fa-cart-plus"></i></a>
                        <a href="{{ route('front.contact') }}" class="btn">Contact Us</a>
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
