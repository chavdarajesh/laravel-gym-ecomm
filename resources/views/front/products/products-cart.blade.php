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
#product-cart .nav-tabs .nav-link:hover, .nav-tabs .nav-link:focus {
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
#product-cart .nav-pills .show > .nav-link {
  color: #fff;
  background-color: #000;
}

#product-cart .nav-fill > .nav-link,
#product-cart .nav-fill .nav-item {
  -ms-flex: 1 1 auto;
  flex: 1 1 auto;
  text-align: center;
}

#product-cart .nav-justified > .nav-link,
#product-cart .nav-justified .nav-item {
  -ms-flex-preferred-size: 0;
  flex-basis: 0;
  -ms-flex-positive: 1;
  flex-grow: 1;
  text-align: center;
}

#product-cart .tab-content > .tab-pane {
  display: none;
}
#product-cart .tab-content > .active {
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

    #product-cart  .quantity-outer {
        max-width: 15rem;
    }

    #product-cart  .quantity button {
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

    #product-cart  .quantity button:focus,
    #product-cart   .quantity button:hover {
        border: none;
        outline: none;
    }

    #product-cart  .quantity input {
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
              <li class="nav-item"><a class="nav-link active" aria-current="page" href="javascript:void(0);">1. Shopping cart</a></li>
              <li class="nav-item"><a id="nav-item-billing-information" class="nav-link  {{ $cartItems->count() ? 'text-dark': 'disabled'}}" href="{{route('front.products-checkout')}}">2. Billing Information</a></li>
              <li class="nav-item"><a class="nav-link disabled" href="javascript:void(0);">3. Completed</a></li>
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
                @if($cartItems->count())
                @foreach ($cartItems as $key=>$item)
                  <tr id="cart-item-{{$item->id}}" data-id="{{$item->id}}">
                    <th class="p-3 pl-0 border-0" scope="row">
                      <div class="d-flex align-items-center"><a class="reset-anchor d-block animsition-link" href="{{ route('front.products-details',$item->product->id) }}"><img src="{{asset($item->product->cover_image)}}" alt="..." width="70"></a>
                        <div class="ml-3"><strong class="h6"><a class="reset-anchor animsition-link text-dark" href="{{ route('front.products-details',$item->product->id) }}">{{$item->product->name}}</a></strong></div>
                      </div>
                    </th>
                    <td class="p-3 align-middle border-0">
                      <p class="mb-0 small">${{$item->price}}</p>
                    </td>
                    <td class="p-3 align-middle border-0">
                      <div class="border d-inline-block px-2">
                        <div class="quantity">
                          <button type="button" class="dec-btn p-0" onclick="decrease('{{$item->id}}',this)"><i class="fas fa-caret-left"></i></button>
                          <input class="form-control border-0 shadow-0 p-0 quantity-result" type="number" value="{{$item->quantity}}" onchange="updateQuantity(this)">
                          <button type="button" class="inc-btn p-0" onclick="increase('{{$item->id}}',this)"><i class="fas fa-caret-right"></i></button>
                        </div>
                      </div>
                    </td>
                    <td class="p-3 align-middle border-0">
                      <p class="mb-0 small">$ <span class="total-price">{{$item->total_price}}</span></p>
                    </td>
                    <td class="p-3 align-middle border-0"><a class="reset-anchor" href="javascript:void(0);" data-id="{{ $item->id }}" onclick="deleteCartItem(this)"><i class="fas fa-trash-alt small text-muted"></i></a></td>
                  </tr>
                  @endforeach
                  @else
                  <tr >
                    <td colspan="5" class="text-center">No items found!</td>
                  </tr>
                  @endif
                </tbody>
              </table>
              <!-- Cart footer-->
              <div class="bg-light p-4">
                <div class="row align-items-center">
                  <div class="col-md-6">
                    <ul class="list-inline mb-0">
                      <li class="list-inline-item py-1 m-0"><a class="btn btn-outline-primary product-list-btn" href="{{route('front.products')}}"> <i class="fas fa-shopping-bag mr-2"></i>Continue shopping</a></li>
                      @if($cartItems->count())
                      <li class="list-inline-item py-1 m-0"><a class="btn btn-primary product-list-btn" href="{{route('front.products-checkout')}}"> <i class="far fa-credit-card mr-2"></i>Process checkout</a></li>
                        @endif
                    </ul>
                  </div>
                  @if($cartItems->count())
                  <div class="align-items-md-end align-items-start col-md-6 d-flex flex-column text-md-end text-start">
                    <p class="text-muted mb-1">Cart total</p>
                    <h6 class="h4 mb-0">$ <span id="total-order"> {{$cartItems->sum('total_price')}}</span></h6>
                  </div>
                  @endif
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

function increase(cartItemId,x) {
    var inputVal = x.previousElementSibling;
    inputVal.value++;
    updateQuantityAjax(cartItemId,inputVal.value);
}

function decrease(cartItemId,x) {
    var inputVal = x.nextElementSibling;
    if (inputVal.value > 1) {
        inputVal.value--;
        updateQuantityAjax(cartItemId,inputVal.value);
    }
}


function updateQuantity(inputElement) {
    const row = inputElement.closest('tr');
    const cartItemId = row.getAttribute('data-id');
    const newQuantity = parseInt(inputElement.value);
    updateQuantityAjax(cartItemId,newQuantity);
}

function updateQuantityAjax(cartItemId,newQuantity) {
    $.ajax({
        url: '{{route("front.products-cart.update-quantity")}}',
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            id: cartItemId,
            quantity: newQuantity,
        },
        success: function (response) {
            if (response.success) {
                toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "preventDuplicates": true
    }
                            toastr.success(response.success);
                            $('#cart-item-' + cartItemId+' .total-price').html(response.totalPrice);
                            $('#total-order').html(response.totalOrder);
                        }
                        if (response.error) {
                            toastr.error(response.error);
                        }
        },
        error: function () {
            toastr.error('Failed to update quantity. Please try again.');
        }
    });
}

function deleteCartItem(deleteButton) {
    const cartItemId = deleteButton.getAttribute('data-id');
    const row = deleteButton.closest('tr');

    if (confirm('Are you sure you want to delete this item?')) {
        $.ajax({
            url: '{{route("front.products-cart.delete-item")}}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id: cartItemId
            },
            success: function (response) {
                if (response.success) {
                toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "preventDuplicates": true
    }
                            toastr.success(response.success);
                            location.reload();
                // row.remove();
                            // if(response.totalOrder == 0){
                            //     $('#total-order').parent().parent().hide();
                            //     $('#nav-item-billing-information').addClass('disabled');
                            //     $('#cart-items-table-body').html('<tr><td colspan="5" class="text-center">No items found!</td></tr>');

                            // }else{
                            //     $('#nav-item-billing-information').addClass('text-dark');
                            //     $('#total-order').html(response.totalOrder);
                            //     $('#total-order').parent().parent().show();
                            // }
                        }
                        if (response.error) {
                            toastr.error(response.error);
                        }
            },
            error: function () {
                toastr.error('Failed to delete the item. Please try again.');
            }
        });
    }
}


</script>
@stop
