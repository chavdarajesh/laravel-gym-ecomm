<style>
    /* ==========================================
    SWIPER SLIDER
   ========================================== */
    #newArrivals a:hover {
        color: #deb226;
    }

    .swiper-button-prev,
    .swiper-button-next {
        width: auto !important;
        height: auto !important;
        top: auto !important;
        bottom: 0 !important;
        color: #6c757d !important;
        background: #f8f9fa !important;
        transition: all 0.3s;
    }

    .swiper-button-prev::after,
    .swiper-button-next::after {
        display: none;
    }

    .swiper-button-prev:hover,
    .swiper-button-next:hover {
        background: #deb226 !important;
        color: #fff !important;
    }

    .swiper-divider {
        font-size: 0.7rem;
        color: #aaa;
    }

    .swiper-button-disabled {
        opacity: 0.5 !important;
    }

    .swiper-thumbnails .swiper-slide img {
        opacity: 0.7 !important;
        transition: all 0.3s !important;
        cursor: pointer !important;
    }

    .swiper-thumbnails .swiper-slide-thumb-active img {
        opacity: 1 !important;
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

    #newArrivals .product-list-btn {
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
    #newArrivals .product-list-btn::before {
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
    #newArrivals .product-list-btn:hover::before {
        transform: scaleX(1);
        color: #fff !important;
        z-index: -1;
    }

    /* line 296, C:/Users/HP/Desktop/July-HTML/292 Health coach/assets/scss/_common.scss */
    #newArrivals .product-list-btn:hover {
        background-position: right;
    }

    /* line 299, C:/Users/HP/Desktop/July-HTML/292 Health coach/assets/scss/_common.scss */
    #newArrivals .product-list-btn.focus,
    #newArrivals .product-list-btn:focus {
        outline: 0;
        box-shadow: none;
    }
</style>
@if (!$topSellingProducts->isEmpty())
<section class="py-5">
    <div class="container py-5">
        <header class="mb-3 text-center">
            <h2 class="mb-0">TOP SELLING</h2>
            <p class="text-muted">Browse the Top Products</p>
        </header>
        <div class="swiper-container pt-5" id="newArrivals">
            <div class="swiper-wrapper d-flex align-items-stretch">
                @foreach($topSellingProducts as $product)
                <div class="swiper-slide pb-3">
                    <div class="product mb-4">
                        <a href="javascript:void(0);">
                            <img class="img-fluid" src="{{ asset($product->product->cover_image) }}" alt="Round grey hanging decor">
                        </a>
                    </div>
                    <!-- Product Name -->
                    <h6 class="text-center">
                        <a class="reset-anchor" href="javascript:void(0);">{{ $product->product->name }}</a>
                    </h6>
                    <!-- Product Price -->
                    @php
                    $minPrice = $product && $product->product && $product->product->sizes && $product->product->sizes->isNotEmpty()
                    ? 'Price : $' . $product->product->sizes->min('pivot.price')
                    : 'N/A';
                    @endphp
                    <p class="text-center text-muted font-weight-bold">{{ $minPrice }}</p>
                    <!-- Action Buttons -->
                    <div class="mt-auto d-flex justify-content-center align-items-center">
                        <button class="product-list-btn">Add to Cart</button>
                        <button class="product-list-btn">Buy Now</button>
                    </div>
                </div>
                @endforeach

            </div>
            <div class=" d-flex justify-content-center align-items-center">
                <div class="prev-newArrivals btn">
                    Prev
                </div>
                <div class="next-newArrivals btn">
                    Next

                </div>
            </div>
        </div>
    </div>
</section>
@endif
<script>
    document.addEventListener("DOMContentLoaded", function() {
        /* ==============================================
    NEW ARRIVALS SLIDER
  ============================================== */
        var newArrivals = new Swiper("#newArrivals", {
            loop: true,
            autoplay: {
                delay: 5000,
                pauseOnMouseEnter: true
            },
            spaceBetween: 25,
            breakpoints: {
                640: {
                    slidesPerView: 2,
                },
                768: {
                    slidesPerView: 3,
                },
                1024: {
                    slidesPerView: 5,
                },
            },
            navigation: {
                nextEl: ".next-newArrivals",
                prevEl: ".prev-newArrivals",
            },
        });
    });
</script>
