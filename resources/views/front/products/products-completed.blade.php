@extends('front.layouts.main')
@section('title', 'Order Created')
@section('css')

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;700&amp;display=swap">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">


    <style>
        #products-completed .nav {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            padding-left: 0;
            margin-bottom: 0;
            list-style: none;
        }

        #products-completed .nav-link {
            display: block;
            padding: 0.5rem 1rem;
            text-decoration: none;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out;
        }

        @media (prefers-reduced-motion: reduce) {
            #products-completed .nav-link {
                transition: none;
            }
        }

        #products-completed .nav-link.disabled {
            color: #adb5bd;
            pointer-events: none;
            cursor: default;
        }

        #products-completed .nav-tabs {
            border-bottom: 1px solid transparent;
        }

        #products-completed .nav-tabs .nav-link {
            margin-bottom: -1px;
            background: none;
            border: 1px solid transparent;
            border-top-left-radius: 0.25rem;
            border-top-right-radius: 0.25rem;
        }

        #products-completed .nav-tabs .nav-link:hover,
        .nav-tabs .nav-link:focus {
            border-color: #e9ecef #e9ecef transparent;
            isolation: isolate;
        }

        #products-completed .nav-tabs .nav-link.disabled {
            color: #adb5bd;
            background-color: transparent;
            border-color: transparent;
        }

        #products-completed .nav-tabs .nav-link.active,
        #products-completed .nav-tabs .nav-item.show .nav-link {
            color: #000;
            background-color: #fff;
            border-color: #dee2e6 #dee2e6 #fff;
        }

        #products-completed .nav-tabs .dropdown-menu {
            margin-top: -1px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }

        #products-completed #products-completed .nav-pills .nav-link {
            background: none;
            border: 0;
            border-radius: 0.25rem;
        }

        #products-completed .nav-pills .nav-link.active,
        #products-completed .nav-pills .show>.nav-link {
            color: #fff;
            background-color: #000;
        }

        #products-completed .nav-fill>.nav-link,
        #products-completed .nav-fill .nav-item {
            -ms-flex: 1 1 auto;
            flex: 1 1 auto;
            text-align: center;
        }

        #products-completed .nav-justified>.nav-link,
        #products-completed .nav-justified .nav-item {
            -ms-flex-preferred-size: 0;
            flex-basis: 0;
            -ms-flex-positive: 1;
            flex-grow: 1;
            text-align: center;
        }

        #products-completed .tab-content>.tab-pane {
            display: none;
        }

        #products-completed .tab-content>.active {
            display: block;
        }


        #products-completed .quantity {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
            max-width: 6rem;
            min-width: 6rem;
        }

        #products-completed .quantity-outer {
            max-width: 15rem;
        }

        #products-completed .quantity button {
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

        #products-completed .quantity button:focus,
        .quantity button:hover {
            border: none;
            outline: none;
        }

        #products-completed .quantity input {
            text-align: center;
        }

        #products-completed .product-list-btn {
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
        #products-completed .product-list-btn::before {
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
        #products-completed .product-list-btn:hover::before {
            transform: scaleX(1);
            color: #fff !important;
            z-index: -1;
        }

        /* line 296, C:/Users/HP/Desktop/July-HTML/292 Health coach/assets/scss/_common.scss */
        #products-completed .product-list-btn:hover {
            background-position: right;
        }

        /* line 299, C:/Users/HP/Desktop/July-HTML/292 Health coach/assets/scss/_common.scss */
        #products-completed .product-list-btn.focus,
        #products-completed .product-list-btn:focus {
            outline: 0;
            box-shadow: none;
        }

          /* Custom timeline styles */
    .timeline {
        list-style: none;
        padding-left: 0;
        position: relative;
    }

    .timeline-item {
        display: flex;
        margin-bottom: 20px;
        position: relative;
    }

    .timeline-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: 10px;
        width: 2px;
        height: 100%;
        background-color: #f0f0f0;
    }

    .timeline-icon {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        margin-right: 15px;
        position: relative;
        z-index: 1;
    }

    .timeline-content {
        flex-grow: 1;
        background-color: #f8f9fa;
        padding: 10px 15px;
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .timeline-item:last-child .timeline-icon {
        background-color: #dc3545;
    }

    .timeline-item .timeline-icon.bg-primary {
        background-color: #007bff;
    }

    .timeline-item .timeline-icon.bg-danger {
        background-color: #dc3545;
    }

    .timeline-content strong {
        font-weight: bold;
        font-size: 1.1rem;
    }

    .timeline-content p {
        font-size: 1rem;
        margin-top: 10px;
    }

    .timeline-content small {
        font-size: 0.85rem;
        color: #6c757d;
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
                            <h2 class="text-white">Order Created</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero End -->
    <!--? Team -->



    <section class="py-5" id="products-completed">
        <div class="container py-5">
            <div class="row">
                <div class="col-lg-10 mx-auto">

                    <!-- Checkout Steps Progress -->
                    <ul class="nav nav-tabs nav-fill border-bottom mb-5 flex-column flex-md-row">
                        <li class="nav-item"><a class="nav-link disabled" href="javascript:void(0);">Shopping cart</a></li>
                        <li class="nav-item"><a class="nav-link disabled" href="javascript:void(0);">Billing Information</a>
                        </li>
                        <li class="nav-item"><a class="nav-link disabled" href="javascript:void(0);">Payment</a></li>
                        <li class="nav-item"><a class="nav-link active" aria-current="page"
                                href="javascript:void(0);">Completed</a></li>
                    </ul>

                    <div class="text-center">
                        <div class="mb-4">
                            <i class="fas fa-check-circle fa-3x text-success"></i>
                        </div>
                        <h1>Thank you for your order!</h1>
                        <p class="text-muted">Your order has been completed successfully.</p>
                        <p>Order Id: <strong>{{ $id }}</strong></p>
                    </div>

                    <div class="card shadow-lg mb-4">
                        <div class="card-header bg-warning text-white">
                            <h5 class="mb-0">Order Status History</h5>
                        </div>
                        <div class="card-body">
                            <ul class="timeline">
                                @foreach ($order->statuses as $status)
                                    <li class="timeline-item">
                                        <div class="timeline-icon {{ $loop->last ? 'bg-primary' : 'bg-success' }}"></div>
                                        <div class="timeline-content">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <strong class="text-uppercase">{{ ucfirst($status->name) }}</strong> |
                                                    ({{ $status->description }})
                                                </div>
                                                <small class="text-muted">
                                                    {{ $status->pivot->created_at->format('d M Y, h:i A') }}
                                                </small>
                                            </div>
                                            <p>{{ $status->pivot->description ?? 'No description available' }}</p>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="text-center mb-4">
                        <!-- Order Details Button -->
                        <a class="btn btn-warning product-list-btn mr-2"
                            href="{{ route('front.orders.details', ['id' => $id]) }}">
                            <i class="fas fa-receipt mr-1"></i> View Order Details
                        </a>
                        <!-- Continue Shopping -->
                        <a target="_blank" class="btn btn-warning product-list-btn" href="{{ route('front.products') }}">
                            <i class="fas fa-shopping-bag mr-2"></i>Continue shopping
                        </a>
                    </div>

                    <!-- Support & Recommendations -->
                    <div class="row mt-5">
                        <div class="col-md-12 mb-3">
                            <div class="alert alert-info">
                                <strong>Need help?</strong><br>
                                Contact our <a class="link" href="{{ route('front.contact') }}">support team</a> if you
                                have any
                                questions about your order.
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </section>



@stop

@section('js')

@stop
