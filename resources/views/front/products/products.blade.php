@extends('front.layouts.main')
@section('title', 'Nutrition & Supplements')
@section('css')
<style>
    /* Custom styles for category cards */
    .category-card {
        border: none;
        overflow: hidden;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        text-decoration: none;
        /* Remove underline for the link */
        display: block;
        /* Ensure the link wraps the entire card */
    }

    .category-card:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
    }

    .category-card img {
        width: 100%;
        height: auto;
        border-radius: 10px 10px 0 0;
    }

    .category-card:hover .category-card-title {
        color: #fff;
        background-color: #ffcc29;
    }

    .category-card-title {
        padding: 10px;
        color: #ffcc29;
        background-color: #fff;
        text-align: center;
        font-size: 1.2rem;
        font-weight: bold;
    }

    /* Custom styles for brand section */
    .brand-section-list .brand-section {
        margin-bottom: 30px;
    }

    .brand-section-list .brand-header {
        font-size: 1.5rem;
        font-weight: bold;
        text-transform: uppercase;
        margin-bottom: 15px;
    }

    .brand-section-list .brand-item {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
        padding: 10px;
        border-bottom: 1px solid #ddd;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .brand-section-list .brand-item img {
        width: 50px;
        height: 50px;
        object-fit: contain;
        margin-right: 15px;
    }

    .brand-section-list .brand-item .brand-name {
        font-size: 1.2rem;
        font-weight: bold;
    }

    .brand-section-list .brand-item a {
        text-decoration: none;
        color: inherit;
    }

    .brand-section-list .brand-item a:hover {
        color: #007bff;
    }

    /* Hover effect */
    .brand-section-list .brand-item:hover {
        transform: scale(1.05);
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        cursor: pointer;
    }

    /* Adjustments for small screens */
    @media (max-width: 576px) {
        .brand-section-list .brand-item {
            flex-direction: column;
            align-items: flex-start;
        }

        .brand-section-list .brand-item img {
            margin-bottom: 10px;
        }

        .brand-section-list .brand-header {
            font-size: 1.2rem;
        }

        .brand-section-list .brand-item .brand-name {
            font-size: 1rem;
        }
    }

    @media (min-width: 1200px) {
        .container {
            max-width: 1480px;
        }
    }
</style>
<link rel="stylesheet" href="{{ asset('assets/front/css/product-nav.css') }}">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;700&amp;display=swap">
<!-- Swiper slider-->
<link rel="stylesheet" href="{{ asset('assets/front/css/swiper-bundle.min.css') }}">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css"
    integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
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
<x-front.product.nav_menu :categories="$categories" :brands="$brands">
</x-front.product.nav_menu>

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
@if (!$topSellingProducts->isEmpty())
<section class="my-5">
    <x-front.product.slider :topSellingProducts="$topSellingProducts" slider-class="custom-slider-class">

    </x-front.product.slider>
</section>
@endif
@if($categories->count())
<section class="my-5">
    <header class="mb-3 text-center">
        <h2 class="mb-0">Categories</h2>
    </header>
    <div class="container py-5">
        <div class="row d-flex justify-content-center align-items-center">
            @foreach ($categories as $category)
            <div class="col-lg-2 col-md-4 col-sm-6 mb-4">
                <a href="{{route('front.products-category',$category->id)}}" class="category-card">
                    <img src="{{ asset($category->image) }}" alt="{{ $category->name }}">
                    <div class="category-card-title">{{ $category->name }}</div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@if($brands->count())
<section class="my-5 brand-section-list">
    <header class="mb-3 text-center">
        <h2 class="mb-0">Brands</h2>
    </header>
    <div class="container py-5">

        @foreach ($brands as $letter => $brandGroup)
        <div class="brand-section">
            <div class="brand-header">{{ $letter }}</div>
            <div class="row">
                @foreach ($brandGroup as $brand)
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="brand-item">
                        <img src="{{ asset($brand->image) }}" alt="{{ $brand->name }}">
                        <a href="{{ route('front.products-brand',$brand->id) }}" class="brand-name">{{ $brand->name }}</a>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
        @endforeach

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
@endif
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


@stop


@section('js')
<script src="{{ asset('assets/front/js/swiper-bundle.min.js') }}"></script>

@stop
