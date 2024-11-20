@extends('front.layouts.main')
@section('title', 'Nutrition & Supplements')
@section('css')
<style>
    .product {
        position: relative;
    }

    .product .badge {
        position: absolute;
        top: 1rem;
        left: 1rem;
        z-index: 999;
    }

    .product img {
        transition: all 0.3s;
    }

    .product:hover img {
        opacity: 0.6;
    }

    .product-btn {
        width: 50px;
        height: 50px;
        display: -ms-flexbox;
        display: flex;
        -ms-flex-align: center;
        align-items: center;
        -ms-flex-pack: center;
        justify-content: center;
        text-transform: uppercase;
        font-size: 0.85rem;
        font-weight: 400;
        background: #fff;
        text-decoration: none;
        color: inherit;
        transition: all 0.3s;
        z-index: 99;
        opacity: 0;
    }

    .product-btn:hover {
        background: #4650dd;
        color: #fff;
    }

    .product:hover .product-btn {
        opacity: 1;
        -webkit-transform: none;
        transform: none;
    }

    .product:hover .cta {
        -webkit-transform: none;
        transform: none;
        opacity: 1;
    }

    .product .cta {
        position: absolute;
        bottom: 1rem;
        right: 1rem;
        -webkit-transform: translateX(0.5rem);
        transform: translateX(0.5rem);
        opacity: 0;
        transition: all 0.3s;
    }

    .product-tabs .nav-link {
        text-transform: uppercase;
        font-size: 0.85rem;
        font-weight: 700;
        color: #212529;
    }

    .product-tabs .nav-link.active {
        background: none;
        color: #4650dd;
    }

    .quantity {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-align: center;
        align-items: center;
        max-width: 6rem;
        min-width: 6rem;
        padding: 0.5rem 0;
    }

    .quantity-outer {
        max-width: 15rem;
    }

    .quantity button {
        border: none;
        width: 2rem;
        min-width: 2rem;
        height: 2rem;
        display: block;
        display: -ms-flexbox;
        display: flex;
        -ms-flex-align: center;
        align-items: center;
        -ms-flex-pack: center;
        justify-content: center;
        font-size: 0.6rem;
    }

    .quantity button:focus,
    .quantity button:hover {
        border: none;
        outline: none;
    }

    .quantity input {
        text-align: center;
    }

    .payment-method {
        padding: 1rem 0.5rem;
        border: 1px solid #ced4da;
        cursor: pointer;
        transition: all 0.3s;
    }

    .btn-check:checked+.payment-method {
        background: #111111;
        border-color: #111111;
        color: #fff;
    }

    .method-panel {
        display: none;
    }

    .method-panel.active {
        display: block;
    }


    .noUi-horizontal {
        height: 3px !important;
    }

    .noUi-target {
        background-color: #e9ecef !important;
        box-shadow: none !important;
        border: none !important;
    }

    .noUi-connect {
        background: #111111 !important;
    }

    .noUi-handle {
        width: 10px !important;
        height: 10px !important;
        border-radius: 50% !important;
        background: #111111 !important;
        border: none !important;
        box-shadow: none !important;
        color: pointer !important;
        top: -4px !important;
        right: -8px !important;
    }

    .noUi-handle::before,
    .noUi-handle::after {
        display: none !important;
    }

    .noUi-handle:hover,
    .noUi-handle:focus {
        outline: none !important;
        border: none !important;
    }

    .noUi-tooltip {
        display: block !important;
        font-weight: bold !important;
        border: none !important;
        padding: 3px 5px !important;
        font-size: 0.7rem !important;
    }



    /* ==========================================
    CHOICES.JS
   ========================================== */
    .choices {
        min-width: 14rem !important;
    }

    .choices__list--dropdown .choices__item--selectable {
        padding-right: 3rem !important;
    }

    .choices__inner {
        padding: 0.375rem 1.125rem !important;
        min-height: calc(1.5em + 0.75rem + 2px) !important;
        border-radius: 0 !important;
        background-color: #fff !important;
        border-color: #ced4da !important;
    }

    .choices__list--single {
        padding: 2px !important;
    }

    #sidebar a,
    #product-grid a {
        color: #000;
    }

    #sidebar a:hover,
    #product-grid a:hover {
        color: #deb226;
    }

    #sidebar .form-check:hover {
        color: #deb226;
    }

    #sidebar .form-check * {
        cursor: pointer;
    }


    .product {
        position: relative;
    }

    .product img {
        transition: all 0.3s;
    }

    .product:hover img {
        opacity: 0.6;
        box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.3);
    }

    #product-grid .product-list-btn {
        background: #ffcc29;
        padding: 10px 10px;
        color: #fff;
        cursor: pointer;
        display: inline-block;
        border-radius: 5px;
        line-height: 1;
        border: 2px solid #fff;
        -moz-user-select: none;
        letter-spacing: 1px;
        margin-bottom: 0;
        transition: color 0.4s linear;
        position: relative;
        z-index: 1;
        overflow: hidden;
    }

    /* line 272, C:/Users/HP/Desktop/July-HTML/292 Health coach/assets/scss/_common.scss */
    #product-grid .product-list-btn::before {
        content: "";
        position: absolute;
        left: 0;
        top: 0;
        width: 101%;
        height: 101%;
        background: #deb226;
        z-index: 1;
        border-radius: 5px;
        transition: transform 0.5s;
        transition-timing-function: ease;
        transform-origin: 0 0;
        transition-timing-function: cubic-bezier(0.5, 1.6, 0.4, 0.7);
        transform: scaleX(0);
        border-radius: 0px;
    }

    /* line 291, C:/Users/HP/Desktop/July-HTML/292 Health coach/assets/scss/_common.scss */
    #product-grid .product-list-btn:hover::before {
        transform: scaleX(1);
        color: #fff !important;
        z-index: -1;
    }

    /* line 296, C:/Users/HP/Desktop/July-HTML/292 Health coach/assets/scss/_common.scss */
    #product-grid .product-list-btn:hover {
        background-position: right;
    }
</style>

<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;700&amp;display=swap">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css"
    integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

<link rel="stylesheet" href="{{ asset('assets/front/css/product-nav.css') }}">
<link rel="stylesheet" href="{{ asset('assets/front/css/nouislider.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/front/css/choices.css') }}">
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


                    <li class="nav-item dropdown brand-section-nav">
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
</section>

<section class="py-5">
    <div class="container py-5">
        <div class="row">
            <!-- Shop sidebar-->
            <div class="col-xl-2 col-lg-3 order-2 order-lg-1" id="sidebar">
                <h2 class="mb-4">Filters</h2>
                <hr>
                <h5 class="mb-4">Shop by Category</h5>
                <ul class="list-unstyled text-muted mb-5">
                    <li class="mb-2 d-flex align-items-center justify-content-between"><a class="reset-anchor"
                            href="#">Clothes</a><span class="badge bg-light text-dark">240</span></li>
                    <li class="mb-2 d-flex align-items-center justify-content-between"><a class="reset-anchor"
                            href="#">Electronics</a><span class="badge bg-light text-dark">120</span></li>
                    <li class="mb-2 d-flex align-items-center justify-content-between"><a class="reset-anchor" href="#">Health
                            &amp; Beauty</a><span class="badge bg-light text-dark">70</span></li>
                    <li class="mb-2 d-flex align-items-center justify-content-between"><a class="reset-anchor"
                            href="#">Shoes</a><span class="badge bg-light text-dark">324</span></li>
                    <li class="mb-2 d-flex align-items-center justify-content-between"><a class="reset-anchor"
                            href="#">Watches</a><span class="badge bg-light text-dark">180</span></li>
                    <li class="mb-2 d-flex align-items-center justify-content-between"><a class="reset-anchor"
                            href="#">Accessories</a><span class="badge bg-light text-dark">77</span></li>
                </ul>
                <h5 class="mb-4">Price range</h5>
                <div class="price-range pt-4 mb-5">
                    <div id="priceRange"></div>
                    <div class="row pt-2">
                        <div class="col-6"><strong class="small font-weight-bold">From</strong></div>
                        <div class="col-6 text-end"><strong class="small font-weight-bold">To</strong></div>
                    </div>
                </div>
                <h5 class="mb-3">Show by brand</h5>
                <div class="mb-2 form-check">
                    <input class="form-check-input" id="exampleCheck1" type="checkbox" checked="">
                    <label class="form-check-label" for="exampleCheck1">Zara</label>
                </div>
                <div class="mb-2 form-check">
                    <input class="form-check-input" id="exampleCheck2" type="checkbox" checked="">
                    <label class="form-check-label" for="exampleCheck2">Cucci</label>
                </div>
                <div class="mb-2 form-check">
                    <input class="form-check-input" id="exampleCheck3" type="checkbox" checked="">
                    <label class="form-check-label" for="exampleCheck3">Rayban</label>
                </div>
                <div class="mb-2 form-check">
                    <input class="form-check-input" id="exampleCheck4" type="checkbox" checked="">
                    <label class="form-check-label" for="exampleCheck4">Defactu</label>
                </div>
                <div class="mb-2 form-check">
                    <input class="form-check-input" id="exampleCheck5" type="checkbox">
                    <label class="form-check-label" for="exampleCheck5">River Nine</label>
                </div>
                <div class="mb-2 form-check">
                    <input class="form-check-input" id="exampleCheck6" type="checkbox">
                    <label class="form-check-label" for="exampleCheck6">Puma</label>
                </div>
                <div class="mb-2 form-check">
                    <input class="form-check-input" id="exampleCheck7" type="checkbox">
                    <label class="form-check-label" for="exampleCheck7">Nike</label>
                </div>
                <div class="mb-5 form-check">
                    <input class="form-check-input" id="exampleCheck8" type="checkbox">
                    <label class="form-check-label" for="exampleCheck8">Ravin</label>
                </div>
                <h5 class="mb-3">Shop by color</h5>
                <form action="#">
                    <div class="form-check">
                        <input class="form-check-input" id="seaColor" type="checkbox">
                        <label class="form-check-label d-flex align-items-center" for="seaColor"><i
                                class="fas fa-circle text-primary me-2 text-xs"></i><span>Sea</span></label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" id="yellowColor" type="checkbox">
                        <label class="form-check-label d-flex align-items-center" for="yellowColor"><i
                                class="fas fa-circle text-warning me-2 text-xs"></i><span>Yellow</span></label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" id="greenColor" type="checkbox">
                        <label class="form-check-label d-flex align-items-center" for="greenColor"><i
                                class="fas fa-circle text-success me-2 text-xs"></i><span>Green</span></label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" id="cyanColor" type="checkbox">
                        <label class="form-check-label d-flex align-items-center" for="cyanColor"><i
                                class="fas fa-circle text-info me-2 text-xs"></i><span>Cyan</span></label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" id="redColor" type="checkbox">
                        <label class="form-check-label d-flex align-items-center" for="redColor"><i
                                class="fas fa-circle text-danger me-2 text-xs"></i><span>Red</span></label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" id="blackColor" type="checkbox">
                        <label class="form-check-label d-flex align-items-center" for="blackColor"><i
                                class="fas fa-circle text-dark me-2 text-xs"></i><span>Black</span></label>
                    </div>
                </form>
            </div>
            <!-- Shop listing-->
            <div class="col-xl-10 col-lg-9 order-1 order-lg-2 mb-5 mb-lg-0" id="product-grid">
                <!-- Listing filter-->
                <div class="row mb-4 pb-3 align-items-center">
                    <div class="col-md-6 text-md-start">
                        <p class="small text-muted">Showing <strong class="text-dark">12 </strong>of <strong class="text-dark">265
                            </strong>items</p>
                    </div>
                    <div class="col-md-6 text-lg-end">
                        <div class="d-flex align-items-center justify-content-center justify-content-md-end">
                            <!-- <ul class="list-inline mb-0">
                                <li class="list-inline-item"><a class="btn btn-outline-dark px-2 btn-sm border-light" href="#"><i
                                            class="fas fa-th-list"></i></a></li>
                                <li class="list-inline-item"><a class="btn btn-outline-dark px-2 btn-sm border-light" href="#"><i
                                            class="fas fa-th"></i></a></li>
                                <li class="list-inline-item"><a class="btn btn-outline-dark px-2 btn-sm border-light" href="#"><i
                                            class="fas fa-th-large"></i></a></li>
                            </ul> -->
                            <ul class="list-inline mb-0 ms-2">
                                <li class="list-inline-item text-start">
                                    <select class="form-control js-sort" name="sort">
                                        <option value="">Sort by</option>
                                        <option value="Option 1">Price: low to high</option>
                                        <option value="Option 1">Price: high to low</option>
                                        <option value="Option 1">Best match</option>
                                        <option value="Option 1">Top rated</option>
                                        <option value="Option 1">Popularity</option>
                                    </select>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- Product-->
                    <div class="col-xl-3 col-lg-4 col-6">
                        <div class="product my-4"><a
                                href="javascript:void(0);"><img class="img-fluid" src="https://d19m59y37dris4.cloudfront.net/shopio/1-1/img/product-2.207aaf3b.jpg"
                                    alt="Round grey hanging decor"></a>
                        </div>
                        <h6 class="text-center"><a class="reset-anchor" href="javascript:void(0);">silver black round Ipod</a>
                        </h6>
                        <p class="text-center text-muted font-weight-bold">121212</p>
                        <div class="d-flex justify-content-center align-items-center">
                            <button class="product-list-btn">Add to Cart</button>
                            <button class="product-list-btn">Buy Now</button>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-6">
                        <div class="product my-4"><a
                                href="javascript:void(0);"><img class="img-fluid" src="https://d19m59y37dris4.cloudfront.net/shopio/1-1/img/product-2.207aaf3b.jpg"
                                    alt="Round grey hanging decor"></a>
                        </div>
                        <h6 class="text-center"><a class="reset-anchor" href="javascript:void(0);">silver black round Ipod</a>
                        </h6>
                        <p class="text-center text-muted font-weight-bold">121212</p>
                        <div class="d-flex justify-content-center align-items-center">
                            <button class="product-list-btn">Add to Cart</button>
                            <button class="product-list-btn">Buy Now</button>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-6">
                        <div class="product my-4"><a
                                href="javascript:void(0);"><img class="img-fluid" src="https://d19m59y37dris4.cloudfront.net/shopio/1-1/img/product-2.207aaf3b.jpg"
                                    alt="Round grey hanging decor"></a>
                        </div>
                        <h6 class="text-center"><a class="reset-anchor" href="javascript:void(0);">silver black round Ipod</a>
                        </h6>
                        <p class="text-center text-muted font-weight-bold">121212</p>
                        <div class="d-flex justify-content-center align-items-center">
                            <button class="product-list-btn">Add to Cart</button>
                            <button class="product-list-btn">Buy Now</button>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-6">
                        <div class="product my-4"><a
                                href="javascript:void(0);"><img class="img-fluid" src="https://d19m59y37dris4.cloudfront.net/shopio/1-1/img/product-2.207aaf3b.jpg"
                                    alt="Round grey hanging decor"></a>
                        </div>
                        <h6 class="text-center"><a class="reset-anchor" href="javascript:void(0);">silver black round Ipod</a>
                        </h6>
                        <p class="text-center text-muted font-weight-bold">121212</p>
                        <div class="d-flex justify-content-center align-items-center">
                            <button class="product-list-btn">Add to Cart</button>
                            <button class="product-list-btn">Buy Now</button>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-6">
                        <div class="product my-4"><a
                                href="javascript:void(0);"><img class="img-fluid" src="https://d19m59y37dris4.cloudfront.net/shopio/1-1/img/product-2.207aaf3b.jpg"
                                    alt="Round grey hanging decor"></a>
                        </div>
                        <h6 class="text-center"><a class="reset-anchor" href="javascript:void(0);">silver black round Ipod</a>
                        </h6>
                        <p class="text-center text-muted font-weight-bold">121212</p>
                        <div class="d-flex justify-content-center align-items-center">
                            <button class="product-list-btn">Add to Cart</button>
                            <button class="product-list-btn">Buy Now</button>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-6">
                        <div class="product my-4"><a
                                href="javascript:void(0);"><img class="img-fluid" src="https://d19m59y37dris4.cloudfront.net/shopio/1-1/img/product-2.207aaf3b.jpg"
                                    alt="Round grey hanging decor"></a>
                        </div>
                        <h6 class="text-center"><a class="reset-anchor" href="javascript:void(0);">silver black round Ipod</a>
                        </h6>
                        <p class="text-center text-muted font-weight-bold">121212</p>
                        <div class="d-flex justify-content-center align-items-center">
                            <button class="product-list-btn">Add to Cart</button>
                            <button class="product-list-btn">Buy Now</button>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-6">
                        <div class="product my-4"><a
                                href="javascript:void(0);"><img class="img-fluid" src="https://d19m59y37dris4.cloudfront.net/shopio/1-1/img/product-2.207aaf3b.jpg"
                                    alt="Round grey hanging decor"></a>
                        </div>
                        <h6 class="text-center"><a class="reset-anchor" href="javascript:void(0);">silver black round Ipod</a>
                        </h6>
                        <p class="text-center text-muted font-weight-bold">121212</p>
                        <div class="d-flex justify-content-center align-items-center">
                            <button class="product-list-btn">Add to Cart</button>
                            <button class="product-list-btn">Buy Now</button>
                        </div>
                    </div>


                    <!-- Pagination-->
                    <nav class="pt-5" aria-label="Page navigation">
                        <ul class="pagination justify-content-center justify-content-lg-end mb-0">
                            <li class="page-item mx-1"><a class="page-link py-1" href="#" aria-label="Previous"><span
                                        aria-hidden="true">«</span></a></li>
                            <li class="page-item mx-1 active"><a class="page-link py-1" href="#">1</a></li>
                            <li class="page-item mx-1"><a class="page-link py-1" href="#">2</a></li>
                            <li class="page-item mx-1"><a class="page-link py-1" href="#">3</a></li>
                            <li class="page-item mx-1"><a class="page-link py-1" href="#" aria-label="Next"><span
                                        aria-hidden="true">»</span></a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>

@stop


@section('js')
<script src="{{ asset('assets/front/js/choices.js') }}"></script>
<script src="{{ asset('assets/front/js/nouislider.min.js') }}"></script>

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

<script>
    /* ==============================================
        CUSTOM SELECT
      ============================================== */
    // const sorting = document.querySelector('.js-sort');
    // const sortingchoices = new Choices(sorting, {
    //     placeholder: false,
    //     itemSelectText: ''
    // });

    var slider = document.getElementById('priceRange');
    noUiSlider.create(slider, {
        start: [0, 30],
        connect: true,
        tooltips: [true, true],
        range: {
            'min': 0,
            'max': 100
        }
    });
</script>

@stop
