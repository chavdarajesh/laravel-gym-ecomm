@extends('front.layouts.main')
@section('title', 'Nutrition & Supplements | Details '.$Product->name)
@section('css')

<style>
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
        background: #ffcc29;
        cursor: pointer;
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

    .nav-tabs .nav-item.show .nav-link,
    .nav-tabs .nav-item .nav-link:hover,
    .nav-tabs .nav-link.active {
        color: #000 !important;
        background-color: #ffcc29;
        border-color: #dee2e6 #dee2e6 #fff;
        border: 1px #000 solid !important;
    }

    .nav-tabs .nav-item .nav-link:not(.active) {
        border: 1px #ffcc29 solid !important;
        color: #ffcc29;
    }
</style>

<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;700&amp;display=swap">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css"
    integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

<!-- <link rel="stylesheet" href="{{ asset('assets/front/css/product-nav.css') }}"> -->
<link rel="stylesheet" href="{{ asset('assets/front/css/swiper-bundle.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/front/css/glightbox.css') }}">
@stop

@section('content')
<!--? Hero Start -->
<div class="slider-area2">
    <div class="slider-height2 d-flex align-items-center">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="">
                        <h2 class="text-white">Nutrition & Supplements | Details : {{$Product->name}}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Hero End -->
<!--? Team -->



<section class="py-5">
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-6 mb-5 mb-lg-0">
                <div class="row">
                    <div class="col-md-2 order-2 order-md-1">
                        <!-- Slider thumbnails-->
                        <div class="swiper-container swiper-thumbnails" id="detailSliderThumb">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide"><img class="img-fluid" src="{{ asset($Product->cover_image) }}" alt="{{$Product->name}}" width="86" height="88"></div>
                                @foreach($Product->images as $image)
                                <div class="swiper-slide"><img class="img-fluid" src="{{ asset($image->image)}}" alt="{{$Product->name}}" width="86" height="88"></div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-md-10 order-1 order-md-2 mb-4 mb-lg-0">
                        <!-- Item slider-->
                        <div class="swiper-container" id="detailSlider">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide"><a class="glightbox" href="{{ asset($Product->cover_image) }}"><img class="img-fluid" src="{{ asset($Product->cover_image) }}" alt="{{$Product->name}}"></a></div>
                                @foreach($Product->images as $image)
                                <div class="swiper-slide"><a class="glightbox" href="{{ asset($image->image)}}"><img class="img-fluid" src="{{ asset($image->image)}}" alt="{{$Product->name}}"></a></div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Item info-->
            <div class="col-lg-6">
                <div class="badge bg-warning small rounded-0 mb-2">{{$Product->brand->name}}</div>
                <h1>{{$Product->name}}</h1>
                <div class="d-flex align-items-center">
                    <ul class="list-inline mb-2 me-3 small">
                        <li class="list-inline-item m-0"><i class="fas fa-star small text-warning"></i></li>
                        <li class="list-inline-item m-0"><i class="fas fa-star small text-warning"></i></li>
                        <li class="list-inline-item m-0"><i class="fas fa-star small text-warning"></i></li>
                        <li class="list-inline-item m-0"><i class="fas fa-star small text-warning"></i></li>
                        <li class="list-inline-item m-0"><i class="fas fa-star small text-muted"></i></li>
                    </ul>
                    <p class="small text-muted mb-2">12 customer reviews</p>
                </div>
                @php
                if ($Product && $Product->sizes && $Product->sizes->isNotEmpty()) {
    $minPriceSize = $Product->sizes->sortBy('pivot.price')->first(); // Sort and get the first size
    $minPrice = 'Price: $' . $minPriceSize->pivot->price;
    $selectedSize = $minPriceSize->id; // Assuming 'name' is a column for the size name
} else {
    $minPrice = 'N/A';
    $selectedSize = 'N/A';
}

                @endphp
                <p class="h4" id="product-price">{{$minPrice}}</p>
                <!-- <p class="text-small mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ut ullamcorper leo, eget euismod orci. Cum sociis natoque penatibus et magnis dis parturient montes nascetur ridiculus mus. Vestibulum ultricies aliquam convallis.</p> -->
                <div class="d-flex flex-wrap align-items-center mb-4">
                    <p class="mb-0 me-3">Select Flavor:</p>
                    <ul class="list-inline mb-0">
                        @foreach($Product->flavors as $flavor)
                        <li class="list-inline-item">
                            <input class="btn-check" id="flavor-{{$flavor->id}}" type="radio" name="flavors" checked="">
                            <label class="p-0 m-0" for="flavor-{{$flavor->id}}">{{$flavor->name}}</label>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="d-flex flex-wrap align-items-center mb-4">
                    <p class="mb-0 me-3">Select size:</p>
                    <select id="size-select" class="form-control" name="size">
                        @foreach($Product->sizes as $size)
                        <option {{$selectedSize == $size->id ? 'selected' : ''}} data-price="{{$size->pivot->price}}" value="{{$size->id}}">{{$size->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="d-align-items-center d-flex flex-column flex-md-row mb-4">
                    <div class="border d-flex align-items-center justify-content-center p-1 me-2">
                        <div class="quantity py-0">
                            <button class="dec-btn p-0" onclick="decrease(this)"><i class="fas fa-caret-left"></i></button>
                            <input class="form-control border-0 shadow-0 p-0 quantity-result" type="text" value="1">
                            <button class="inc-btn p-0" onclick="increase(this)"><i class="fas fa-caret-right"></i></button>
                        </div>
                    </div><a class="btn  btn-sm py-2 border-bottom-0 px-5 me-3" href="cart.html"> <i class="fas fa-shopping-bag py-1 me-2"></i>Add to cart</a><a class="p-0 reset-anchor d-inline-block mx-2" href="#"><i class="fas fa-heart"></i></a><a class="p-0 reset-anchor d-inline-block mx-2" href="#"><i class="fas fa-share-alt"></i></a>
                </div><br>
                <ul class="list-unstyled small d-inline-block">
                    <!-- <li class="px-3 py-2 mb-1 bg-light"><strong class="text-uppercase">SKU:</strong><span class="ms-2 text-muted">039</span></li> -->
                    <li class="px-3 py-2 mb-1 bg-light text-muted"><strong class="text-uppercase text-dark">Category:</strong><a class="text-dark ms-2" href="#">{{$Product->category->name}}</a></li>
                    <li class="px-3 py-2 mb-1 bg-light text-muted"><strong class="text-uppercase text-dark">Sub Category:</strong><a class="reset-anchor ms-2" href="#">{{isset($Product->subcategory) ? $Product->subcategory->name : ''}}</a></li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="pb-5">
    <div class="container">
        <div class="row">
            <!-- Item information-->
            <div class="col-xl-10 mx-auto">
                <ul class="nav nav-tabs tabs-fill justify-content-center border-0 flex-column flex-md-row" id="myTab" role="tablist">
                    <li class="nav-item flex-fill text-center bg-light mx-2" role="presentation">
                        <a class="nav-link text-dark text-small font-weight-bold py-3 border-0 active" id="description-tab" data-toggle="tab" href="#description" role="tab" aria-controls="description" aria-selected="true">Description</a>
                    </li>
                    <li class="nav-item flex-fill text-center bg-light mx-2" role="presentation">
                        <a class="nav-link text-dark text-small font-weight-bold py-3 border-0" id="reviews-tab" data-toggle="tab" href="#reviews" role="tab" aria-controls="reviews" aria-selected="false">Reviews</a>
                    </li>
                    <li class="nav-item flex-fill text-center bg-light mx-2" role="presentation">
                        <a class="nav-link text-dark text-small font-weight-bold py-3 border-0" id="shipping-tab" data-toggle="tab" href="#shipping" role="tab" aria-controls="shipping" aria-selected="false">Shipping &amp; Returns</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                        <div class="p-3 p-md-5" style="word-break: break-all;">
                            {!! $Product->description !!}
                        </div>
                    </div>
                    <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                        <div class="p-3 p-md-5" style="word-break: break-all;">
                            <p class="small text-muted mb-1">Based on 12 customers</p>
                            <h5 class="mb-4">How customers reviewed this item</h5>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="d-flex mb-4"><img class="rounded-circle p-1 shadow-sm flex-grow-1 align-self-baseline" src="https://d19m59y37dris4.cloudfront.net/shopio/1-1/img/client-1.2821b67d.jpg" alt="..." width="60">
                                        <div class="ms-3">
                                            <h3 class="h6 mb-0">Patrick Wood</h3>
                                            <p class="text-gray small mb-0">15 Mar 2019</p>
                                            <ul class="list-inline mb-3">
                                                <li class="list-inline-item small m-0"><i class="fas fa-star text-primary small"></i></li>
                                                <li class="list-inline-item small m-0"><i class="fas fa-star text-primary small"></i></li>
                                                <li class="list-inline-item small m-0"><i class="fas fa-star text-primary small"></i></li>
                                                <li class="list-inline-item small m-0"><i class="fas fa-star text-primary small"></i></li>
                                                <li class="list-inline-item small m-0"><i class="fas fa-star text-primary small"></i></li>
                                            </ul>
                                            <p class="text-small text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="d-flex mb-4"><img class="rounded-circle p-1 shadow-sm flex-grow-1 align-self-baseline" src="https://d19m59y37dris4.cloudfront.net/shopio/1-1/img/client-2.f8d832d9.jpg" alt="..." width="60">
                                        <div class="ms-3">
                                            <h3 class="h6 mb-0">Melissa Johanson</h3>
                                            <p class="text-gray small mb-0">15 Mar 2019</p>
                                            <ul class="list-inline mb-3">
                                                <li class="list-inline-item small m-0"><i class="fas fa-star text-primary small"></i></li>
                                                <li class="list-inline-item small m-0"><i class="fas fa-star text-primary small"></i></li>
                                                <li class="list-inline-item small m-0"><i class="fas fa-star text-primary small"></i></li>
                                                <li class="list-inline-item small m-0"><i class="fas fa-star text-primary small"></i></li>
                                                <li class="list-inline-item small m-0"><i class="fas fa-star text-primary small"></i></li>
                                            </ul>
                                            <p class="text-small text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="shipping" role="tabpanel" aria-labelledby="shipping-tab">
                        <div class="p-3 p-md-5" style="word-break: break-all;">
                            <p class="small text-muted mb-1">Enjoy fast and reliable delivery, with 30-day easy returns</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@if (!$relatedProducts->isEmpty())
<x-related-product-slider :relatedProducts="$relatedProducts">

</x-related-product-slider>
@endif

@stop

@section('js')
<script src="{{ asset('assets/front/js/swiper-bundle.min.js') }}"></script>
<script src="{{ asset('assets/front/js/glightbox.js') }}"></script>
<script>
    $(document).ready(function() {
        var galleryThumbs = new Swiper("#detailSliderThumb", {
            direction: "horizontal",
            breakpoints: {
                768: {
                    direction: "vertical",
                },
            },
            spaceBetween: 15,
            slidesPerView: {{ $Product->images->count() > 1 ? $Product->images->count() +1  : 1 }},
            watchSlidesVisibility: true,
            watchSlidesProgress: false,
        });

        var detailSlider = new Swiper("#detailSlider", {
            spaceBetween: 10,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            thumbs: {
                swiper: galleryThumbs,
            },
        });

        const lightbox = GLightbox({
            touchNavigation: true,
            loop: true,
            autoplayVideos: true,
        });


        $('#size-select').on('change', function() {
            var selectedOption = $(this).find(':selected');
            var price = selectedOption.data('price');
            $('#product-price').text('Price : $' + price);
        });
    });

    function increase(x) {
        var inputVal = x.previousElementSibling;
        inputVal.value++;
    }

    function decrease(x) {
        var inputVal = x.nextElementSibling;
        if (inputVal.value > 1) {
            inputVal.value--;
        }
    }

</script>
@stop
