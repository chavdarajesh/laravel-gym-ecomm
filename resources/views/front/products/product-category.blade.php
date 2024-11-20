@extends('front.layouts.main')
@section('title', 'Nutrition & Supplements | Category '.$Category->name)
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

    #sidebar h5{
        cursor: pointer;
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
                        <h2>Nutrition & Supplements | Category : {{$Category->name}}</h2>
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
                                <a class="nav-link dropdown-item dropdown-toggle" href="{{route('front.products-category',$category->id)}}">
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
                            <a class="nav-link dropdown-item" href="{{route('front.products-category',$category->id)}}">{{ $category->name }}</a>
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
                @if($otherCategorys->count())
                <h5 class="mb-2 d-flex align-items-center justify-content-between " data-toggle="collapse" data-target="#categoryCollapse">
                    <span>Shop by Category</span>
                    <span>
                        <i class="fa fa-chevron-down" id="category-arrow"></i>
                    </span>
                </h5>
                <div id="categoryCollapse" class="collapse show">
                    <ul class="list-unstyled text-muted mb-4">
                        @foreach($otherCategorys as $otherCategory)
                        <li class="mb-2 d-flex align-items-center justify-content-between">
                            <a class="reset-anchor" href="{{route('front.products-category', $otherCategory->id)}}">{{$otherCategory->name}}</a>
                            <span class="badge bg-light text-dark">{{ $otherCategory->products->count() }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <h5 class="mb-2 d-flex align-items-center justify-content-between " data-toggle="collapse" data-target="#Pricerange">
                    <span>Price range</span>
                    <span>
                        <i class="fa fa-chevron-down" id="category-arrow"></i>
                    </span>
                </h5>
                <div class="price-range pt-4 mb-4 show collapse" id="Pricerange">
                    <div id="priceRange"></div>
                    <div class="row pt-2">
                        <div class="col-6"><strong class="small font-weight-bold">From</strong></div>
                        <div class="col-6 text-end" style="text-align: end;"><strong class="small font-weight-bold">To</strong></div>
                    </div>
                </div>
                @if($categoryBrands->count())
                <h5 class="mb-2 d-flex align-items-center justify-content-between " data-toggle="collapse" data-target="#categoryBrands">
                    <span>Show by brand</span>
                    <span>
                        <i class="fa fa-chevron-down" id="category-arrow"></i>
                    </span>
                </h5>
                <div class="brand-filter show collapse mb-4" id="categoryBrands">
                    @foreach($categoryBrands as $brand)
                    <div class="mb-2 form-check">
                        <input class="form-check-input" id="brand-filter-{{$brand->id}}" type="checkbox" value="{{$brand->id}}">
                        <label class="form-check-label" for="brand-filter-{{$brand->id}}">{{$brand->name}} | ({{$brand->products->count()}})</label>
                    </div>
                    @endforeach
                </div>
                @endif
                @if($flavorsArray->count())
                <h5 class="mb-2 d-flex align-items-center justify-content-between " data-toggle="collapse" data-target="#flavorsArray">
                    <span>Flavour</span>
                    <span>
                        <i class="fa fa-chevron-down" id="category-arrow"></i>
                    </span>
                </h5>
                <div class="flavor-filter show collapse mb-4" id="flavorsArray">
                    @foreach($flavorsArray as $Flavour)
                    <div class="mb-2 form-check">
                        <input class="form-check-input" id="flavor-filter-{{$Flavour->id}}" type="checkbox" value="{{$Flavour->id}}">
                        <label class="form-check-label" for="flavor-filter-{{$Flavour->id}}">{{$Flavour->name}} | ({{$Flavour->products->count()}})</label>
                    </div>
                    @endforeach
                </div>
                @endif
                @if($sizeArray->count())
                <h5 class="mb-2 d-flex align-items-center justify-content-between " data-toggle="collapse" data-target="#sizeArray">
                    <span>Size</span>
                    <span>
                        <i class="fa fa-chevron-down" id="category-arrow"></i>
                    </span>
                </h5>
                <div class="size-filter show collapse" id="sizeArray">
                    @foreach($sizeArray as $Size)
                    <div class="mb-2 form-check">
                        <input class="form-check-input" id="size-filter-{{$Size->id}}" type="checkbox" value="{{$Size->id}}">
                        <label class="form-check-label" for="size-filter-{{$Size->id}}">{{$Size->name}} | ({{$Size->products->count()}})</label>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
            <!-- Shop listing-->

            <div class="col-xl-10 col-lg-9 order-1 order-lg-2 mb-5 mb-lg-0" id="product-grid">
                <!-- Listing filter-->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <img style="max-height: 200px;" src="{{ asset($category->image) }}" alt="{{$category->name}}" class="img-fluid w-100 rounded shadow-lg mb-3">
                            <h2>{{$category->name}}</h2>
                            <p>{!!$category->description!!}</p>
                        </div>
                    </div>
                </div>
                <div class="row mb-4 align-items-center">
                    <div class="col-md-6 text-md-start d-flex">
                        <p class="small text-muted mx-1">Showing <strong class="text-dark">1 </strong>of <strong class="text-dark">{{$totalRecords}}
                            </strong>items | </p>
                        <p class="small text-muted mx-1">From <strong class="text-dark" id="start-range-items">40 </strong>of <strong id="end-range-items" class="text-dark">60
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
                                    <select id="sortProducts" class="form-control js-sort" name="sort">
                                        <option value="">Sort by</option>
                                        <option value="latest">Latest</option>
                                        <option value="oldest">Oldest</option>
                                        <option value="price_low_high">Price: Low to High</option>
                                        <option value="price_high_low">Price: High to Low</option>
                                    </select>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="row d-flex align-items-stretch" id="productList">

                </div>

                <!-- Pagination-->
                <!-- <nav class="pt-5" aria-label="Page navigation">
                    <ul class="pagination justify-content-center justify-content-lg-end mb-0">
                        <li class="page-item mx-1"><a class="page-link py-1" href="#" aria-label="Previous"><span
                                    aria-hidden="true">«</span></a></li>
                        <li class="page-item mx-1 active"><a class="page-link py-1" href="#">1</a></li>
                        <li class="page-item mx-1"><a class="page-link py-1" href="#">2</a></li>
                        <li class="page-item mx-1"><a class="page-link py-1" href="#">3</a></li>
                        <li class="page-item mx-1"><a class="page-link py-1" href="#" aria-label="Next"><span
                                    aria-hidden="true">»</span></a></li>
                    </ul>
                </nav> -->
                <div id="paginationLinks">

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
    var minPrice = '{{$minPrice}}';
    var maxPrice = '{{$maxPrice}}';
    minPrice = Number(minPrice);
    maxPrice = Number(maxPrice);
    if (minPrice == maxPrice) {
        maxPrice = maxPrice + 1;
    }
    var slider = document.getElementById('priceRange');
    noUiSlider.create(slider, {
        start: [minPrice, maxPrice],
        connect: true,
        tooltips: [true, true],
        step: 1,
        range: {
            'min': minPrice,
            'max': maxPrice
        }
    });

    slider.noUiSlider.on('change', function(values, handle, unencoded) {
        const sort = $('#sortProducts').val();
        const minPrice = unencoded[0] || 0;
        const maxPrice = unencoded[1] || 999999;
        const brands = getSelectedValues('.brand-filter input:checked');
        const sizes = getSelectedValues('.size-filter input:checked');
        const flavors = getSelectedValues('.flavor-filter input:checked');
        fetchProducts(sort, minPrice, maxPrice, brands, sizes, flavors);

    });
</script>

<script>
    var totalItem = '{{$totalRecords}}';
    totalItem = Number(totalItem);

    function fetchProducts(sort = 'latest', minPrice = 0, maxPrice = 999999, brands = [], sizes = [], flavors = [], page = 1, perPage = 1) {
        const categoryId = '{{ $Category->id }}'; // Replace with your dynamic category ID
        const url = `/category/${categoryId}/products?sort=${sort}&minPrice=${minPrice}&maxPrice=${maxPrice}&brands=${brands.join(',')}&sizes=${sizes.join(',')}&flavors=${flavors.join(',')}&page=${page}`;

        $.ajax({
            url: "{{ route('front.products-category-filters',$Category->id) }}",
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                sort: sort,
                minPrice: minPrice,
                maxPrice: maxPrice,
                page: page,
                brands: brands.join(','),
                sizes: sizes.join(','),
                flavors: flavors.join(','),
                perPage: perPage,
            },
            success: function(response) {
                let productsHtml = '';
                if (response.products && response.products.length > 0) {
                    response.products.forEach(product => {
                        var imgUrl = '{{ asset("") }}' + product.cover_image;
                        let price = product.sizes.length ? product.sizes[0].pivot.price : 'N/A';
                        productsHtml += `
                        <div class="col-12 col-lg-4 col-md-6 col-xl-3 d-flex">
                            <div class="product-box w-100 d-flex flex-column mb-4">
                                <div class="product mb-4">
                                    <a href="javascript:void(0);">
                                        <img class="img-fluid" src="${imgUrl}" alt="${product.name}">
                                    </a>
                                </div>
                                <h6 class="text-center">
                                    <a class="reset-anchor" href="javascript:void(0);">${product.name}</a>
                                </h6>
                                <p class="text-center text-muted font-weight-bold">Price: $${price}</p>
                                <div class="mt-auto d-flex justify-content-center align-items-center">
                                    <button class="product-list-btn" data-product-id="${product.id}">Add to Cart</button>
                                    <button class="product-list-btn" data-product-id="${product.id}">Buy Now</button>
                                </div>
                            </div>
                        </div>
                    `;
                    });
                    $('#productList').html(productsHtml);
                    $('#paginationLinks').html(response.pagination);
                    let startIndex = (page - 1) * perPage + 1;
                    let endIndex = Math.min(startIndex + perPage - 1, totalItem); // Adjust for the last page

                    // Update the HTML elements
                    $('#start-range-items').html(startIndex);
                    $('#end-range-items').html(endIndex);
                } else {
                    $('#productList').html('<div class="col-12 text-center">No products found</div>');
                    $('#paginationLinks').html('');
                }

            }
        });
    }
    $(document).ready(function() {

        // Initial load
        fetchProducts();

        // Sort change event
        $('#sortProducts').on('change', function() {
            const sort = $(this).val();
            var sliderValues = slider.noUiSlider.get();
            const minPrice = sliderValues[0];
            const maxPrice = sliderValues[1];
            const brands = getSelectedValues('.brand-filter input:checked');
            const sizes = getSelectedValues('.size-filter input:checked');
            const flavors = getSelectedValues('.flavor-filter input:checked');
            fetchProducts(sort, minPrice, maxPrice, brands, sizes, flavors);
        });

        // Brand, Size, Flavor checkbox change events
        $('.brand-filter input, .size-filter input, .flavor-filter input').on('change', function() {
            const sort = $('#sortProducts').val();
            var sliderValues = slider.noUiSlider.get();
            const minPrice = sliderValues[0];
            const maxPrice = sliderValues[1];
            const brands = getSelectedValues('.brand-filter input:checked');
            const sizes = getSelectedValues('.size-filter input:checked');
            const flavors = getSelectedValues('.flavor-filter input:checked');
            fetchProducts(sort, minPrice, maxPrice, brands, sizes, flavors);
        });

        // Pagination links handling (if needed)
        $(document).on('click', '.pagination .active-page', function(e) {
            e.preventDefault();
            const page = $(this).attr('data-url').split('page=')[1];
            const sort = $('#sortProducts').val();
            var sliderValues = slider.noUiSlider.get();
            const minPrice = sliderValues[0];
            const maxPrice = sliderValues[1];
            const brands = getSelectedValues('.brand-filter input:checked');
            const sizes = getSelectedValues('.size-filter input:checked');
            const flavors = getSelectedValues('.flavor-filter input:checked');
            fetchProducts(sort, minPrice, maxPrice, brands, sizes, flavors, page);
        });

        // // Function to get selected checkbox values as an array
    });

    function getSelectedValues(selector) {
        let selected = [];
        $(selector).each(function() {
            if ($(this).prop('checked')) {
                selected.push($(this).val());
            }
        });
        return selected;
    }
</script>

@stop
