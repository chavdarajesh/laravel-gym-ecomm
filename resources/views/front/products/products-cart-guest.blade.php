@extends('front.layouts.main')
@section('title', 'Shopping cart')
@section('css')

<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;700&amp;display=swap">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css"
    integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

<link rel="stylesheet" href="{{ asset('assets/front/css/swiper-bundle.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/front/css/glightbox.css') }}">

<style>
    #product-cart .nav {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        padding-left: 0;
        margin-bottom: 0;
        list-style: none;
    }

    #product-cart .nav-link {
        display: block;
        padding: 0.5rem 1rem;
        text-decoration: none;
        transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out;
    }

    @media (prefers-reduced-motion: reduce) {
        #product-cart .nav-link {
            transition: none;
        }
    }

    #product-cart .nav-link.disabled {
        color: #adb5bd;
        pointer-events: none;
        cursor: default;
    }

    #product-cart .nav-tabs {
        border-bottom: 1px solid transparent;
    }

    #product-cart .nav-tabs .nav-link {
        margin-bottom: -1px;
        background: none;
        border: 1px solid transparent;
        border-top-left-radius: 0.25rem;
        border-top-right-radius: 0.25rem;
    }

    #product-cart .nav-tabs .nav-link:hover,
    .nav-tabs .nav-link:focus {
        border-color: #e9ecef #e9ecef transparent;
        isolation: isolate;
    }

    #product-cart .nav-tabs .nav-link.disabled {
        color: #adb5bd;
        background-color: transparent;
        border-color: transparent;
    }

    #product-cart .nav-tabs .nav-link.active,
    #product-cart .nav-tabs .nav-item.show .nav-link {
        color: #000;
        background-color: #fff;
        border-color: #dee2e6 #dee2e6 #fff;
    }

    #product-cart .nav-tabs .dropdown-menu {
        margin-top: -1px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }

    #product-cart #product-cart .nav-pills .nav-link {
        background: none;
        border: 0;
        border-radius: 0.25rem;
    }

    #product-cart .nav-pills .nav-link.active,
    #product-cart .nav-pills .show>.nav-link {
        color: #fff;
        background-color: #000;
    }

    #product-cart .nav-fill>.nav-link,
    #product-cart .nav-fill .nav-item {
        -ms-flex: 1 1 auto;
        flex: 1 1 auto;
        text-align: center;
    }

    #product-cart .nav-justified>.nav-link,
    #product-cart .nav-justified .nav-item {
        -ms-flex-preferred-size: 0;
        flex-basis: 0;
        -ms-flex-positive: 1;
        flex-grow: 1;
        text-align: center;
    }

    #product-cart .tab-content>.tab-pane {
        display: none;
    }

    #product-cart .tab-content>.active {
        display: block;
    }

    #product-cart .quantity {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-align: center;
        align-items: center;
        max-width: 6rem;
        min-width: 6rem;
        padding: 0.5rem 0;
    }

    #product-cart .quantity-outer {
        max-width: 15rem;
    }

    #product-cart .quantity button {
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

    #product-cart .quantity button:focus,
    #product-cart .quantity button:hover {
        border: none;
        outline: none;
    }

    #product-cart .quantity input {
        text-align: center;
    }

    #product-cart .product-list-btn {
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
        margin: 0;
    }

    /* line 272, C:/Users/HP/Desktop/July-HTML/292 Health coach/assets/scss/_common.scss */
    #product-cart .product-list-btn::before {
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
    #product-cart .product-list-btn:hover::before {
        transform: scaleX(1);
        color: #fff !important;
        z-index: -1;
    }

    /* line 296, C:/Users/HP/Desktop/July-HTML/292 Health coach/assets/scss/_common.scss */
    #product-cart .product-list-btn:hover {
        background-position: right;
    }

    /* line 299, C:/Users/HP/Desktop/July-HTML/292 Health coach/assets/scss/_common.scss */
    #product-cart .product-list-btn.focus,
    #product-cart .product-list-btn:focus {
        outline: 0;
        box-shadow: none;
    }

    input.quantity-result::-webkit-outer-spin-button,
    input.quantity-result::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input.quantity-result {
        pointer-events: none;
    }

    /* Firefox */
    input.quantity-result[type=number] {
        -moz-appearance: textfield;
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
                    <div class="">
                        <h2 class="text-white">Shopping cart</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Hero End -->
<!--? Team -->



<section class="py-5" id="product-cart">
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <ul class="nav nav-tabs nav-fill border-bottom mb-5 flex-column flex-md-row">
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="javascript:void(0);">Shopping cart</a></li>
                    <li class="nav-item"><a id="nav-item-billing-information" class="nav-link  text-dark" href="{{route('front.orders.checkout')}}">Billing Information</a></li>
                    <li class="nav-item"><a class="nav-link disabled" href="javascript:void(0);">Payment</a></li>
                    <li class="nav-item"><a class="nav-link disabled" href="javascript:void(0);">Completed</a></li>
                </ul>
                <!-- Shopping cart-->
                <div class="table-responsive mb-4">
                    <table class="table">
                        <thead class="bg-light">
                            <tr>
                                <th class="p-3 border-0" scope="col"><strong class="text-uppercase">Product</strong></th>
                                <th class="p-3 border-0" scope="col"><strong class="text-uppercase">Price</strong></th>
                                <th class="p-3 border-0" scope="col"><strong class="text-uppercase">Quantity</strong></th>
                                <th class="p-3 border-0" scope="col"><strong class="text-uppercase">Total</strong></th>
                                <th class="p-3 border-0" scope="col"><strong class="text-uppercase"></strong></th>
                            </tr>
                        </thead>
                        <tbody id="cart-items-table-body">



                        </tbody>
                    </table>
                    <!-- Cart footer-->
                    <div class="bg-light p-4">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <ul class="list-inline mb-0">
                                    <li class="list-inline-item py-1 m-0"><a class="btn btn-outline-warning product-list-btn" href="{{route('front.products')}}"> <i class="fas fa-shopping-bag mr-2"></i>Continue shopping</a></li>
                                    <li class="list-inline-item py-1 m-0"><a class="btn btn-warning product-list-btn" href="{{route('front.orders.checkout')}}"> <i class="far fa-credit-card mr-2"></i>Process checkout</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@stop

@section('js')
<script src="{{ asset('assets/front/js/swiper-bundle.min.js') }}"></script>
<script src="{{ asset('assets/front/js/glightbox.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {

        loadGuestCart();

    });



    function loadGuestCart() {

        const cartItems = JSON.parse(localStorage.getItem('guestCart')) || [];
        const cartTableBody = document.getElementById('cart-items-table-body');
        cartTableBody.innerHTML = ''; // Clear existing rows

        if (cartItems.length == 0) {
            cartTableBody.innerHTML = `<tr><td colspan="5" class="text-center">Your cart is empty</td></tr>`;
            return;
        }

        cartItems.forEach(item => {
            $.ajax({
                url: '{{route("front.products-details.ajax")}}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: item.product,
                    size: item.size,
                },
                success: function(response) {
                    if (response.success) {
                        const product= response.product;
                        const row = document.createElement('tr');
                        var imgUrl = '{{ asset("") }}' + product.cover_image;
                        row.setAttribute('id', `cart-item-${item.product}`);
                        row.setAttribute('data-id', item.product);
                        row.innerHTML = `
                <th class="p-3 pl-0 border-0" scope="row">
                    <div class="d-flex align-items-center">
                        <img src="${imgUrl}" alt="..." width="70">
                        <div class="ml-3">
                            <strong class="h6">${product.name}</strong>
                        </div>
                    </div>
                </th>
                <td class="p-3 align-middle border-0">
                    <p class="mb-0 small">$${product.price}</p>
                </td>
                <td class="p-3 align-middle border-0">
                    <div class="border d-inline-block px-2">
                        <div class="quantity">
                            <button class="dec-btn p-0" onclick="decreaseGuestQuantity(${item.product})"><i class="fas fa-caret-left"></i></button>
                            <input class="form-control border-0 shadow-0 p-0 quantity-result" type="number" value="${item.quantity}" onchange="updateGuestQuantity(this, ${item.product})">
                            <button class="inc-btn p-0" onclick="increaseGuestQuantity(${item.product})"><i class="fas fa-caret-right"></i></button>
                        </div>
                    </div>
                </td>
                <td class="p-3 align-middle border-0">
                    <p class="mb-0 small">$<span class="total-price">${(product.price * item.quantity).toFixed(2)}</span></p>
                </td>
                <td class="p-3 align-middle border-0">
                    <a class="reset-anchor" href="javascript:void(0);" onclick="deleteGuestCartItem(${item.product})">
                        <i class="fas fa-trash-alt small text-muted"></i>
                    </a>
                </td>
            `;
                        cartTableBody.appendChild(row);

                    }
                    if (response.error) {
                        toastr.error(response.error);
                    }
                },
                error: function() {
                    toastr.error('Somthing Went Wrong..!');
                }
            });
        });
    }

    function deleteGuestCartItem(product) {
        let cart = JSON.parse(localStorage.getItem('guestCart')) || [];
        cart = cart.filter(item => item.product !== product);
        localStorage.setItem('guestCart', JSON.stringify(cart));
        loadGuestCart();
    }

    function decreaseGuestQuantity(product) {
        updateGuestQuantityBy(product, -1);
    }

    function increaseGuestQuantity(product) {
        updateGuestQuantityBy(product, 1);
    }

    function updateGuestQuantityBy(product, change) {
        let cart = JSON.parse(localStorage.getItem('guestCart')) || [];
        const item = cart.find(item => item.product == product);

        if (item) {
            item.quantity = Math.max(1, item.quantity + change);
            localStorage.setItem('guestCart', JSON.stringify(cart));
            loadGuestCart();
        }
    }

    function updateGuestQuantity(input, product) {
        let cart = JSON.parse(localStorage.getItem('guestCart')) || [];
        const item = cart.find(item => item.product == product);

        if (item) {
            const newQuantity = parseInt(input.value);
            if (isNaN(newQuantity) || newQuantity <= 0) {
                input.value = item.quantity;
                return;
            }

            item.quantity = newQuantity;
            localStorage.setItem('guestCart', JSON.stringify(cart));
            loadGuestCart();
        }
    }
</script>


@stop
