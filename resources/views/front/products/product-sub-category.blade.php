@extends('front.layouts.main')
@section('title', 'Nutrition & Supplements | Sub Category '.$Subcategory->name)
@section('css')
<style>
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

    #sidebar h5 {
        cursor: pointer;
    }

    @media (min-width: 1200px) {
        .container {
            max-width: 1480px;
        }
    }
</style>

<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;700&amp;display=swap">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css"
    integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

<link rel="stylesheet" href="{{ asset('assets/front/css/nouislider.min.css') }}">
@stop

@section('content')
<!--? Hero Start -->
<div class="slider-area2">
    <div class="slider-height2 d-flex align-items-center">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div>
                        <h2 class="text-white">Nutrition & Supplements | Sub Category : {{$Subcategory->name}}</h2>
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

<section class="py-5">
    <div class="container py-5">
        <div class="row p-3">
            <!-- Shop sidebar-->
            <div class="col-xl-2 col-lg-3 order-2 order-lg-1 px-2" id="sidebar">
                <h2 class="mb-4">Filters</h2>
                <hr>
                @if($otherSubcategorys->count())
                <h5 class="mb-2 d-flex align-items-center justify-content-between " data-toggle="collapse" data-target="#otherSubcategorys">
                    <span>Shop by Sub Category</span>
                    <span>
                        <i class="fa fa-chevron-down" id="category-arrow"></i>
                    </span>
                </h5>
                <div id="otherSubcategorys" class="collapse show">
                    <ul class="list-unstyled text-muted mb-4">
                        @foreach($otherSubcategorys as $otherSubcategory)
                        <li class="mb-2 d-flex align-items-center justify-content-between">
                            <a class="reset-anchor" href="{{route('front.products-sub-category', $otherSubcategory->id)}}">{{$otherSubcategory->name}}</a>
                            <span class="badge bg-light text-dark">{{ $otherSubcategory->products->count() }}</span>
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
                <div class="price-range pt-4 mb-4 show collapse mx-3" id="Pricerange">
                    <div id="priceRange"></div>
                    <div class="row pt-2">
                        <div class="col-6"><strong class="small font-weight-bold">From</strong></div>
                        <div class="col-6 text-end" style="text-align: end;"><strong class="small font-weight-bold">To</strong></div>
                    </div>
                </div>
                @if($subCategoryBrands->count())
                <h5 class="mb-2 d-flex align-items-center justify-content-between " data-toggle="collapse" data-target="#subCategoryBrands">
                    <span>Show by brand</span>
                    <span>
                        <i class="fa fa-chevron-down" id="category-arrow"></i>
                    </span>
                </h5>
                <div class="brand-filter show collapse mb-4" id="subCategoryBrands">
                    @foreach($subCategoryBrands as $brand)
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
                        <input class="form-check-input" id="flavor-filter-{{$Flavour['flavor_id']}}" type="checkbox" value="{{$Flavour['flavor_id']}}">
                        <label class="form-check-label" for="flavor-filter-{{$Flavour['flavor_id']}}">{{$Flavour['flavor_name']}} | ({{$Flavour['product_count']}})</label>
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
                        <input class="form-check-input" id="size-filter-{{$Size['size_id']}}" type="checkbox" value="{{$Size['size_id']}}">
                        <label class="form-check-label" for="size-filter-{{$Size['size_id']}}">{{$Size['size_name']}} | ({{$Size['product_count']}})</label>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
            <!-- Shop listing-->

            <div class="col-xl-10 col-lg-9 order-1 order-lg-2 mb-5 mb-lg-0 px-2" id="product-grid">
                <!-- Listing filter-->
                <div>
                    <img style="max-height: 200px;" src="{{ asset($Subcategory->image) }}" alt="{{$Subcategory->name}}" class="img-fluid w-100 rounded shadow-lg mb-3">
                    <h2>{{$Subcategory->name}}</h2>
                    <p>{!!$Subcategory->description!!}</p>
                </div>
                <div class="row mb-4 align-items-center">
                    <div class="col-md-6 text-md-start d-flex">
                        <p class="small text-muted mx-1">Showing <strong class="text-dark" id="per-page-items">- </strong>of <strong class="text-dark">{{$totalRecords}}
                            </strong>items | </p>
                        <p class="small text-muted mx-1">From <strong class="text-dark" id="start-range-items">- </strong>of <strong id="end-range-items" class="text-dark">-
                            </strong>items</p>
                    </div>
                    <div class="col-md-6 text-lg-end">
                        <div class="d-flex align-items-center justify-content-center justify-content-md-end">
                            <ul class="list-inline mb-0 ml-2">
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
                <div id="paginationLinks">

                </div>
            </div>
        </div>
    </div>
</section>

@stop


@section('js')
<script src="{{ asset('assets/front/js/nouislider.min.js') }}"></script>


<script>
    var minPrice = '{{$minPrice}}';
    var maxPrice = '{{$maxPrice}}';
    minPrice = Number(minPrice);
    maxPrice = Number(maxPrice);
    var slider = document.getElementById('priceRange');
    const oldMaxPrice = maxPrice;
    if (minPrice == maxPrice) {
        maxPrice = maxPrice + 1;
    }
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

    if (minPrice == oldMaxPrice) {
        slider.noUiSlider.disable();
    }
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
    const perPageItems = 1

    function fetchProducts(sort = 'latest', minPrice = 0, maxPrice = 999999, brands = [], sizes = [], flavors = [], page = 1, perPage = perPageItems) {

        $.ajax({
            url: "{{ route('front.products-sub-category-filters',$Subcategory->id) }}",
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
                        let price = 'N/A';
                        let detailsUrl = '{{ route("front.products-details",":id") }}';
                        if (product.sizes.length) {
                            const prices = product.sizes.map(size => size.pivot.price); // Extract all prices
                            price = Math.min(...prices); // Get the minimum price
                        }
                        productsHtml += `
                        <div class="col-12 col-lg-4 col-md-6 col-xl-3 d-flex">
                            <div class="product-box w-100 d-flex flex-column mb-4">
                                <div class="product mb-4">
                                    <a href="${detailsUrl.replace(':id', product.id)}">
                                        <img class="img-fluid" src="${imgUrl}" alt="${product.name}">
                                    </a>
                                </div>
                                <h6 class="text-center">
                                    <a class="reset-anchor" href="${detailsUrl.replace(':id', product.id)}">${product.name}</a>
                                </h6>
                                <p class="text-center text-muted font-weight-bold">Price: $${price}</p>
                                <div class="mt-auto d-flex justify-content-center align-items-center">
                                    <button onclick="addToCart(${product.id})" class="product-list-btn" data-product-id="${product.id}">Add to Cart</button>
                                    <button onclick="addToCart(${product.id},true)" class="product-list-btn" data-product-id="${product.id}">Buy Now</button>
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
        $('#per-page-items').html(perPageItems);
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

<script>
    function addToCart(product,redirectTocart = false) {
        const isUserLoggedIn = @json(auth()->check());
        if (isUserLoggedIn) {
            $.ajax({
                url: '{{route("front.products-cart.ajax.other")}}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    product: product,
                    quantity: 1
                },
                success: function(response) {
                    if (response.success) {
                        toastr.options = {
                            "closeButton": true,
                            "progressBar": true,
                            "preventDuplicates": true
                        }
                        toastr.success(response.success);
                    }
                    if (response.error) {
                        toastr.error(response.error);
                    }
                    if(redirectTocart){
                            window.location.href = '{{route("front.products-cart")}}';
                        }
                },
                error: function() {
                    toastr.error('Somthing Went Wrong..!');
                }
            });
        } else {
            $.ajax({
                url: '{{route("front.products.size.flover.ajax")}}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: product,
                },
                success: function(response) {
                    if (response.success) {
                        let cart = JSON.parse(localStorage.getItem('guestCart')) || [];
                        let existingItem = cart.find(item =>
                            item.product == product && item.size == response.size.id && item.flavor == response.flavor.id
                        );

                        if (existingItem) {
                            existingItem.quantity += 1;
                        } else {
                            cart.push({
                                product: product,
                                size: response.size.id,
                                flavor: response.flavor.id,
                                quantity: 1
                            });

                        }

                            localStorage.setItem('guestCart', JSON.stringify(cart));
                            toastr.options = {
                                "closeButton": true,
                                "progressBar": true,
                                "preventDuplicates": true
                            }
                            toastr.success('Item added to cart successfully!');
                            if(redirectTocart){
                            window.location.href = '{{route("front.products-cart")}}';
                        }
                    }
                    if (response.error) {
                        toastr.error(response.error);
                    }
                },
                error: function() {
                    toastr.error('Somthing Went Wrong..!');
                }
            });
        }
    }
</script>

@stop
