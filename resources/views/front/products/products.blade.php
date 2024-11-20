@extends('front.layouts.main')
@section('title', 'Nutrition & Supplements')
@section('css')
<style>
    #product-nav-menu,
    #product-nav-menu .dropdown-menu,
    #product-nav-menu .form-control {
        font-size: 18px !important;
    }

    #product-nav-menu .navbar {
        background-color: #ffcc29 !important;
        color: #000;
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
    }

    #product-nav-menu .navbar .dropdown-menu div[class*="col"] {
        margin-bottom: 1rem;
    }

    #product-nav-menu .navbar .dropdown-menu {
        border: none;
        background-color: #ffcc29;
    }

    @media screen and (min-width: 992px) {

        #product-nav-menu .navbar {
            padding-top: 0px;
            padding-bottom: 0px;
        }

        #product-nav-menu .navbar .nav-item {
            padding: .5rem .5rem;
            margin: 0 .25rem;
        }

        #product-nav-menu .navbar .dropdown {
            position: static;
        }

        #product-nav-menu .navbar .dropdown-menu.full-width-menu {
            width: 100%;
            left: 0;
            right: 0;
            top: 45px;
            display: block;
            visibility: hidden;
            opacity: 0;
            transition: visibility 0s, opacity 0.3s linear;
        }

        #product-nav-menu .navbar .dropdown:hover .dropdown-menu,
        #product-nav-menu .navbar .dropdown .dropdown-menu:hover {
            display: block;
            visibility: visible;
            opacity: 1;
            transition: visibility 0s, opacity 0.3s linear;
        }

        #product-nav-menu .navbar .dropdown-menu {
            border: 1px solid rgba(0, 0, 0, .15);
            background-color: #fff;
            box-shadow: rgb(38, 57, 77) 0px 20px 30px -10px;
        }

        #product-nav-menu .dropdown-submenu .dropdown-menu {
            display: none !important;
            top: 15px;
            left: 100%;
            margin-top: -6px;
        }


        #product-nav-menu .dropdown-submenu:hover .dropdown-menu {
            display: block !important;
            /* End position */
        }
    }

    #product-nav-menu .dropdown-submenu {
        position: relative;
    }

    #product-nav-menu .nav-link:hover {
        background-color: #ffcc29;
    }

    #product-nav-menu form .form-control {
        height: 40px;
        border-color: #f0e9ff;
        font-size: 13px;
        color: #999999;
        padding-left: 20px;
        border-radius: 0;
        border-right: 0;
    }

    #product-nav-menu form .form-control::placeholder {
        color: #999999;
    }

    #product-nav-menu form .form-control:focus {
        border-color: #f0e9ff;
        outline: 0;
        box-shadow: none;
    }

    #product-nav-menu form .input-group button {
        background: #ffcc29;
        border-left: 0;
        border: 1px solid #f0e9ff;
        padding: 0px 15px;
        border-left: 0;
        cursor: pointer;
    }

    #product-nav-menu form .input-group button i {
        color: #fff;
    }

    #product-nav-menu form .input-group button span {
        font-size: 14px;
        color: #999999;
    }

    #product-nav-menu .dropdown-toggle::after {
        display: none !important;
    }

    .width-max-content {
        width: max-content !important;
    }

    .brand-item {
        padding: 10px;
        border: 1px solid #e0e0e0;
        border-radius: 5px;
    }

    .brand-logo {
        max-width: 40px;
        /* Adjust as necessary */
        height: auto;
    }

    .sticky-product-menu {
        left: 0;
        margin: auto;
        position: fixed;
        top: 100px;
        width: 100%;
        z-index: 9999;
        -webkit-animation: 300ms ease-in-out 0s normal none 1 running fadeInDown;
        animation: 300ms ease-in-out 0s normal none 1 running fadeInDown;
    }

    .sticky-product-menu .navbar {
        -webkit-box-shadow: 0 10px 15px rgba(25, 25, 25, 0.1);
        box-shadow: 0 10px 15px rgba(25, 25, 25, 0.1);
        -webkit-box-shadow: 0 10px 15px rgba(25, 25, 25, 0.1);
    }

    @media (max-width: 991px) {
        .sticky-product-menu {
            top: 65px;
        }
    }



    /* Category image styles */
    .category-card .category-image {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border: 2px solid #ddd;
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
        transition: box-shadow 0.3s ease;
    }

    .category-card {
        background-color: #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: box-shadow 0.3s ease;
    }

    .category-card:hover .category-image {
        animation: zoomIn 0.3s ease-in-out forwards;
    }

    @keyframes zoomIn {
        0% {
            transform: scale(1);
        }

        100% {
            transform: scale(1.1);
        }
    }

    .category-card:hover {
        box-shadow: rgba(0, 0, 0, 0.50) 0px 5px 15px;
    }

    .category-card:hover {
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    @media (max-width: 992px) {
        .col-md-4 {
            max-width: 33.33%;
        }
    }

    @media (max-width: 768px) {
        .col-sm-6 {
            max-width: 50%;
        }
    }

    @media (max-width: 576px) {
        .col-6 {
            max-width: 100%;
        }
    }
</style>
@stop

@section('content')
<!--? Hero Start -->
<div class="slider-area2">
    <div class="slider-height2 d-flex align-items-center">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="hero-cap hero-cap2 pt-70">
                        <h2>Nutrition & Supplements</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Hero End -->
<!--? Team -->
<section class="">
    <div class="my-5" id="product-nav-menu">
        <nav class="navbar navbar-expand-lg navbar-light container d-flex justify-content-end">
            <!-- <a class="navbar-brand" href="https://bootstrapcreative.com/">Mega Dropdown</a> -->
            <button class="navbar-toggler p-2 " type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            aria-haspopup="true" aria-expanded="false" data-toggle="dropdown">
                            <span> CATEGORIES</span>
                            @if($categories && $categories->count())
                            <img class="mx-2 drop-down-arrow" width="10px" src="{{ asset('assets/front/img/product/arrow-down-filled-triangle-svgrepo-com.svg') }}" alt="">
                            @endif
                        </a>
                        @if($categories->count())
                        <div class="dropdown-menu m-0 p-0 normal-menu width-max-content" aria-labelledby="navbarDropdown">
                            @foreach($categories as $category)
                            @if($category->subcategories && $category->subcategories->count())
                            <!-- Nested dropdown -->
                            <div class="dropdown-submenu w-100">
                                <a class="nav-link dropdown-item dropdown-toggle" href="#">
                                    <span> {{ $category->name }}</span>
                                    @if($category->subcategories->count())
                                    <img class="mx-2 drop-down-arrow" width="10px" src="{{ asset('assets/front/img/product/arrow-down-filled-triangle-svgrepo-com.svg') }}" alt="">
                                    @endif
                                </a>
                                @if($category->subcategories->count())
                                <div class="dropdown-menu p-0 width-max-content">
                                    @foreach($category->subcategories as $subcategory)
                                    <a class="nav-link dropdown-item w-100" href="#"> {{ $subcategory->name }}</a>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                            @else
                            <a class="nav-link dropdown-item" href="#">{{ $category->name }}</a>
                            @endif
                            @endforeach
                        </div>
                        @endif
                    </li>


                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span> BRANDS</span>
                            @if($brands->count())
                            <img class="mx-2 drop-down-arrow" width="10px" src="{{ asset('assets/front/img/product/arrow-down-filled-triangle-svgrepo-com.svg') }}" alt="">
                            @endif
                        </a>
                        @if($brands->count())
                        <div class="dropdown-menu full-width-menu" aria-labelledby="navbarDropdown">
                            <div class="container">
                                @foreach ($brands as $letter => $brandGroup)
                                <div class="letter-section mb-4">
                                    <h2>{{ $letter }}</h2>
                                    <div class="row">
                                        @foreach ($brandGroup as $brand)
                                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3 text-center">
                                            <div class="brand-item d-flex align-items-center">
                                                <img src="{{ asset($brand->image) }}" alt="{{ $brand->name }}" class="brand-logo img-fluid mx-2">
                                                <span>{{ $brand->name }}</span>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <!--  /.container  -->


                        </div>
                        @endif
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="#" id="navbarDropdown" role="button">
                            TOP SELLINGs
                        </a>
                    </li>
                </ul>
                <form action="http://localhost/laravel/laravel-gym/blog/search" method="GET">
                    <div class="form-group m-0">
                        <div class="input-group ">
                            <input type="text" class="form-control" placeholder="Search Keyword" name="search">
                            <div class="input-group-append">
                                <button class="btns" type="submit"><i class="ti-search"></i></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>


        </nav>
    </div>
    @if (!$ProductSliders->isEmpty())
    <div class="container my-5">
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                @foreach ($ProductSliders as $key => $slider)
                <li data-target="#carouselExampleIndicators" data-slide-to="{{ $key }}" class="{{ $key == 0 ? 'active' : '' }}"></li>
                @endforeach
            </ol>
            <div class="carousel-inner">
                @foreach ($ProductSliders as $key => $slider)
                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                    @if($slider->product_id)
                    <a href="">
                        <img style="max-height: 450px;" class="d-block w-100" src="{{ asset($slider->image) }}" alt="{{ $slider->name }}">
                    </a>
                    @else
                    <img style="max-height: 450px;" class="d-block w-100" src="{{ asset($slider->image) }}" alt="{{ $slider->name }}">
                    @endif
                </div>
                @endforeach
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
    @endif
</section>
<section class="my-5">
    <div class="container box_1170">
        <h3 class="text-heading">TOP SELLING</h3>
        <div class="row">

        </div>
    </div>
</section>
@if($categories->count())
<section class="my-5">
    <div class="container box_1170">
        <h3 class="text-heading">CATEGORIES</h3>
        <div class="row">
            @foreach($categories as $category)
            <div class="col-6 col-md-4 col-lg-2 mb-4">
                <div class="category-card text-center p-3 shadow-sm rounded">
                    <!-- Category Image -->
                    <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" class="category-image rounded-circle">
                    <!-- Category Name -->
                    <h3 class="mt-2">{{ $category->name }}</h3>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@if($brands->count())
<section class="my-5">
    <div class="container box_1170">
        <h3 class="text-heading">BRANDS</h3>
        <div class="container">
            @foreach ($brands as $letter => $brandGroup)
            <div class="letter-section mb-4">
                <h2>{{ $letter }}</h2>
                <div class="row">
                    @foreach ($brandGroup as $brand)
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3 text-center">
                        <div class="brand-item d-flex align-items-center">
                            <img src="{{ asset($brand->image) }}" alt="{{ $brand->name }}" class="brand-logo img-fluid mx-2">
                            <span>{{ $brand->name }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
<section class="my-5">
    <div class="container container--flush">
        <div class="row ">
            <div class="col-12 col-md-3 d-flex align-items-center">
                <div class="mx-2" style="width: 24px;">
                    <svg focusable="false" viewBox="0 0 24 24" role="presentation">
                        <g stroke-width="1.5" fill="none" fill-rule="evenodd">
                            <path d="M6.5 3.25l12 6" stroke="#ff6128"></path>
                            <path stroke="#242526" d="M23 7l-10 5L1 6M13 12v11"></path>
                            <path stroke="#242526" stroke-linecap="square" d="M23 7v10l-10 6-12-6V6l10-5z"></path>
                        </g>
                    </svg>
                </div>
                <div class="">
                    <p class="m-0">Free delivery worldwide</p>
                    <div class="">
                        <p class="m-0">Short content about your store</p>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-3 d-flex align-items-center">
                <div class="mx-2" style="width: 24px;">
                    <svg focusable="false" viewBox="0 0 23 24" role="presentation">
                        <g transform="translate(1 1)" stroke-width="1.5" fill="none" fill-rule="evenodd">
                            <path stroke="#ff6128" d="M8 4h8v7"></path>
                            <path stroke="#ff6128" stroke-linecap="square" d="M11 7L8 4l3-3"></path>
                            <circle stroke="#242526" stroke-linecap="square" cx="6" cy="20" r="2"></circle>
                            <circle stroke="#242526" stroke-linecap="square" cx="18" cy="20" r="2"></circle>
                            <path stroke="#242526" stroke-linecap="square" d="M21 5l-2 10H5L3 0H0"></path>
                        </g>
                    </svg>
                </div>
                <div class="">
                    <p class="m-0">Satisfied or refunded</p>
                    <div class="">
                        <p class="m-0">Short content about your store</p>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-3 d-flex align-items-center">
                <div class="mx-2" style="width: 24px;">
                    <svg focusable="false" viewBox="0 0 24 24" role="presentation">
                        <g stroke-width="1.5" fill="none" fill-rule="evenodd" stroke-linecap="square">
                            <path d="M10 17H4c-1.7 0-3 1.3-3 3v3h12v-3c0-1.7-1.3-3-3-3zM7 14c-1.7 0-3-1.3-3-3v-1c0-1.7 1.3-3 3-3s3 1.3 3 3v1c0 1.7-1.3 3-3 3z" stroke="#242526"></path>
                            <path stroke="#ff6128" d="M13 1v10l4-3h6V1z"></path>
                        </g>
                    </svg>
                </div>
                <div class="">
                    <p class="m-0">Top-notch support</p>
                    <div class="">
                        <p class="m-0">Short content about your store</p>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-3 d-flex align-items-center">
                <div class="mx-2" style="width: 24px;">
                    <svg focusable="false" viewBox="0 0 24 24" role="presentation">
                        <g stroke-width="1.5" fill="none" fill-rule="evenodd" stroke-linecap="square">
                            <path d="M1 5h22M1 9h22M9 17H3c-1.105 0-2-.895-2-2V3c0-1.105.895-2 2-2h18c1.105 0 2 .895 2 2v10M5 13h5" stroke="#242526"></path>
                            <path stroke="#ff6128" d="M13 16h8v7h-8zM15 16v-2c0-1.1.9-2 2-2s2 .9 2 2v2M17 19v1"></path>
                        </g>
                    </svg>
                </div>
                <div class="">
                    <p class="m-0">Secure payments</p>
                    <div class="">
                        <p class="m-0">Short content about your store</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


@if (!$Blogs->isEmpty())
<section class="home-blog-area pt-10 pb-50 bg-dark">
    <div class="container">
        <!-- Section Tittle -->
        <div class="row justify-content-center">
            <div class="col-lg-7 col-md-9 col-sm-10">
                <div class="section-tittle text-center mb-100 wow fadeInUp" data-wow-duration="2s"
                    data-wow-delay=".2s">
                    <h2>From Blog</h2>
                </div>
            </div>
        </div>
        <div class="row d-flex justify-content-center">
            @foreach ($Blogs as $Blog)
            <div class="col-xl-6 col-lg-6 col-md-6">
                <div class="home-blog-single mb-30 wow fadeInUp" data-wow-duration="1s" data-wow-delay=".4s">
                    <div class="blog-img-cap">
                        <div class="blog-img">
                            <img src="{{ $Blog && isset($Blog->image) && $Blog->image ? asset($Blog->image) : asset('custom-assets/front/placeholder/dummy-image-square.jpg') }}" alt="Blog Image">
                        </div>
                        <div class="blog-cap">
                            <span>{{ implode(', ', $Blog->tags->pluck('name')->toArray()) }}</span>
                            <h3><a href="{{ route('front.blog.details', ['id' => $Blog->id]) }}">{{ $Blog && $Blog->title ? (strlen($Blog->title) > 70 ? substr($Blog->title, 0, 70) . '..' : $Blog->title) : '' }}</a></h3>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</section>
<section class="my-5">
    <div class=" container box_1170">
        <div class="blog_right_sidebar">
            <aside class="single_sidebar_widget newsletter_widget">
                <h4 class="widget_title" style="color: #2d2d2d;">Newsletter</h4>
                <form id="form" action="{{ route('front.newsletter.save') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <input type="email" name="email" class="form-control @error('email') border border-danger @enderror" placeholder='Enter email'>
                        <div id="email_error" class="text-danger w-100 mx-4"> @error('email')
                            {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <button class="button rounded-0 primary-bg text-white w-100 btn_1 boxed-btn"
                        type="submit">Subscribe</button>
                </form>
            </aside>
        </div>
    </div>
</section>
@endif

@stop


@section('js')
<script>
    $(document).ready(function() {
        $('#product-nav-menu .dropdown-submenu .dropdown-toggle .drop-down-arrow').on('click', function(e) {
            e.stopPropagation();
            $(this).parent().next('.dropdown-menu').toggle();
        });
        $(window).resize(function() {
            if ($(window).width() >= 980) {
                $("#product-nav-menu .navbar .dropdown-toggle").hover(function() {
                    $(this).parent().toggleClass("show");
                    $(this).parent().find(".dropdown-menu").toggleClass("show");
                });
                $("#product-nav-menu  .navbar .dropdown-menu").mouseleave(function() {
                    $(this).removeClass("show");
                });
            }
        });

        $(window).on('scroll', function() {
            var scroll = $(window).scrollTop();
            if (scroll < 400) {
                $("#product-nav-menu").removeClass("sticky-product-menu");
            } else {
                $("#product-nav-menu").addClass("sticky-product-menu");
            }
        });
    });
</script>

@stop
