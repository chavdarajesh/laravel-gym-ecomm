@extends('front.layouts.main')
@section('title', 'Billing Information')
@section('css')

<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;700&amp;display=swap">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css"
    integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

<link rel="stylesheet" href="{{ asset('assets/front/css/swiper-bundle.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/front/css/glightbox.css') }}">

<style>

#products-checkout .nav {
  display: -ms-flexbox;
  display: flex;
  -ms-flex-wrap: wrap;
  flex-wrap: wrap;
  padding-left: 0;
  margin-bottom: 0;
  list-style: none;
}

#products-checkout .nav-link {
  display: block;
  padding: 0.5rem 1rem;
  text-decoration: none;
  transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out;
}
@media (prefers-reduced-motion: reduce) {
    #products-checkout .nav-link {
    transition: none;
  }
}
#products-checkout .nav-link.disabled {
  color: #adb5bd;
  pointer-events: none;
  cursor: default;
}

#products-checkout .nav-tabs {
  border-bottom: 1px solid transparent;
}
#products-checkout .nav-tabs .nav-link {
  margin-bottom: -1px;
  background: none;
  border: 1px solid transparent;
  border-top-left-radius: 0.25rem;
  border-top-right-radius: 0.25rem;
}
#products-checkout .nav-tabs .nav-link:hover, .nav-tabs .nav-link:focus {
  border-color: #e9ecef #e9ecef transparent;
  isolation: isolate;
}
#products-checkout .nav-tabs .nav-link.disabled {
  color: #adb5bd;
  background-color: transparent;
  border-color: transparent;
}
#products-checkout .nav-tabs .nav-link.active,
#products-checkout .nav-tabs .nav-item.show .nav-link {
  color: #000;
  background-color: #fff;
  border-color: #dee2e6 #dee2e6 #fff;
}
#products-checkout .nav-tabs .dropdown-menu {
  margin-top: -1px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}

#products-checkout #products-checkout .nav-pills .nav-link {
  background: none;
  border: 0;
  border-radius: 0.25rem;
}
#products-checkout .nav-pills .nav-link.active,
#products-checkout .nav-pills .show > .nav-link {
  color: #fff;
  background-color: #000;
}

#products-checkout .nav-fill > .nav-link,
#products-checkout .nav-fill .nav-item {
  -ms-flex: 1 1 auto;
  flex: 1 1 auto;
  text-align: center;
}

#products-checkout .nav-justified > .nav-link,
#products-checkout .nav-justified .nav-item {
  -ms-flex-preferred-size: 0;
  flex-basis: 0;
  -ms-flex-positive: 1;
  flex-grow: 1;
  text-align: center;
}

#products-checkout .tab-content > .tab-pane {
  display: none;
}
#products-checkout .tab-content > .active {
  display: block;
}


#products-checkout .quantity {
  display: -ms-flexbox;
  display: flex;
  -ms-flex-align: center;
  align-items: center;
  max-width: 6rem;
  min-width: 6rem;
}
#products-checkout .quantity-outer {
  max-width: 15rem;
}
#products-checkout .quantity button {
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
#products-checkout .quantity button:focus, .quantity button:hover {
  border: none;
  outline: none;
}
#products-checkout .quantity input {
  text-align: center;
}

#products-checkout .product-list-btn {
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
    #products-checkout .product-list-btn::before {
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
    #products-checkout .product-list-btn:hover::before {
        transform: scaleX(1);
        color: #fff !important;
        z-index: -1;
    }

    /* line 296, C:/Users/HP/Desktop/July-HTML/292 Health coach/assets/scss/_common.scss */
    #products-checkout .product-list-btn:hover {
        background-position: right;
    }

    /* line 299, C:/Users/HP/Desktop/July-HTML/292 Health coach/assets/scss/_common.scss */
    #products-checkout .product-list-btn.focus,
    #products-checkout .product-list-btn:focus {
        outline: 0;
        box-shadow: none;
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
                        <h2 class="text-white">Billing Information</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Hero End -->
<!--? Team -->



<section class="py-5" id="products-checkout">
      <div class="container py-5">
        <div class="row">
          <div class="col-lg-10 mx-auto">
            <ul class="nav nav-tabs nav-fill border-bottom mb-5 flex-column flex-md-row">
              <li class="nav-item"><a class="nav-link text-dark" href="{{route('front.products-cart')}}">1. Shopping cart</a></li>
              <li class="nav-item"><a class="nav-link active" aria-current="page" href="javascript:void(0);">2. Billing Information</a></li>
              <li class="nav-item"><a class="nav-link disabled" href="javascript:void(0);">3. Completed</a></li>
            </ul>
            <div class="row">
              <div class="col-lg-6">
                <form action="from-action" method="post">
                  <div class="row">
                    <div class="form-group col-12 mb-3">
                      <label class="form-label small text-uppercase">Full name</label>
                      <input class="form-control" type="text" name="name" placeholder="Enter your full name">
                    </div>
                    <div class="form-group col-12 mb-3">
                      <label class="form-label small text-uppercase">Email address</label>
                      <input class="form-control" type="email" name="email" placeholder="Enter your email address">
                    </div>
                    <div class="form-group col-12 mb-3">
                      <label class="form-label small text-uppercase">Adress 1</label>
                      <input class="form-control" type="text" name="address1" placeholder="Enter your main address">
                    </div>
                    <div class="form-group col-12 mb-3">
                      <label class="form-label small text-uppercase">Address 2</label>
                      <input class="form-control" type="text" name="address2" placeholder="Enter your alternative address">
                    </div>
                    <div class="form-group col-12 mb-3">
                      <label class="form-label small text-uppercase">City</label>
                      <input class="form-control" type="text" name="city" placeholder="Enter your city">
                    </div>
                    <div class="form-group col-lg-6 mb-3">
                      <label class="form-label small text-uppercase">State</label>
                      <select class="form-control js-choice" name="state">
                        <option value="">Choose your state</option>
                        <option value="Option 1">Demo state</option>
                        <option value="Option 1">Demo state</option>
                        <option value="Option 1">Demo state</option>
                        <option value="Option 1">Demo state</option>
                        <option value="Option 1">Demo state</option>
                      </select>
                    </div>
                    <div class="form-group col-lg-6 mb-3">
                      <label class="form-label small text-uppercase">Full name</label>
                      <input class="form-control" type="text" name="zipcode" placeholder="Enter city postal colde">
                    </div>
                  </div>
                </form>
              </div>
              <div class="col-lg-6">
                <div class="bg-light px-3 py-2 mb-3">
                  <h6 class="mb-0 py-1">Payment method</h6>
                </div>
                <!-- Footer-->
                <div class="bg-light p-2">
                  <div class="row align-items-center">
                    <div class="col-md-9">
                      <ul class="list-inline mb-0 ">
                        <li class="list-inline-item py-1"><a class="btn btn-outline-primary product-list-btn" href="{{route('front.products-cart')}}"> <i class="fas fa-shopping-cart mr-2"></i>Back to cart</a></li>
                        <li class="list-inline-item py-1"><a class="btn btn-primary product-list-btn" href="{{route('front.products-completed')}}"> <i class="far fa-credit-card mr-2"></i>Place order</a></li>
                      </ul>
                    </div>
                    <div class="col-md-3 text-start text-md-end">
                      <p class="text-muted mb-1">Cart total</p>
                      <h6 class="h4 mb-0">${{$totalOrder}}</h6>
                    </div>
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
