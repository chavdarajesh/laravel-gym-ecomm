@extends('front.layouts.main')
@section('title', 'Order Details')
@section('css')
<style>
    .card {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        border-bottom: 2px solid #f0f0f0;
    }

    .card-body {
        font-size: 1rem;
    }

    .img-fluid {
        height: 200px;
        object-fit: cover;
        border-bottom: 2px solid #f0f0f0;
    }

    /* Floating Action Button */
    .position-fixed {
        z-index: 1050;
    }

    .list-group-item {
        background-color: #f8f9fa;
        font-size: 1.1rem;
    }

    .badge-warning {
        background-color: #ffcc00;
    }

    .badge-success {
        background-color: #28a745;
    }

    .badge-info {
        background-color: #17a2b8;
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
                    <div class="hero-cap hero-cap2 pt-70">
                        <h2 class="text-white">Order Details</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Hero End -->
<!--? Team -->

<div class="container pt-5 pb-5">
    <h2 class="mb-5 text-center text-warning font-weight-bold">Order Details</h2>

    <!-- Order Info Section -->
    <div class="card shadow-lg mb-4">
        <div class="card-header bg-warning text-white">
            <h5 class="mb-0">Order Information</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Order ID:</strong> #{{ $order->id }}</p>
                    <p><strong>User:</strong> {{ $order->user->name }}</p>
                    <p><strong>Order Date:</strong> {{ $order->created_at->format('d M Y, h:i A') }}</p>
                </div>
                <div class="col-md-6 text-md-right">
                    <p>
                        <strong>Status:</strong>
                        <span class="">
                            {{ $order->statuses()
    ->orderBy('pivot_created_at', 'desc') // Use pivot table's `created_at` column
    ->first()->name; }}
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Address Section -->
    <div class="card shadow-lg mb-4">
        <div class="card-header bg-warning text-white">
            <h5 class="mb-0">Shipping Address</h5>
        </div>
        <div class="card-body">
            <p><strong>Name:</strong> {{ $order->address->name }}</p>
            <p><strong>Phone:</strong> {{ $order->address->phone }}</p>
            <p><strong>Email:</strong> {{ $order->address->email ?? 'N/A' }}</p>
            <p><strong>Address:</strong></p>
            <p>
                {{ $order->address->address_line_1 }} <br>
                {!! $order->address->address_line_2 ? $order->address->address_line_2 . '<br>' : '' !!}
                {{ $order->address->city }}, {{ $order->address->state }} - {{ $order->address->postal_code }}<br>
                {{ $order->address->country }}
            </p>
        </div>
    </div>


    <!-- Status History Timeline Section -->
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
                                <strong class="text-uppercase">{{ ucfirst($status->name) }}</strong> | ({{ $status->description }})
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


    <!-- Product List Section -->
    <div class="card shadow-lg mb-4">
        <div class="card-header bg-warning">
            <h5 class="mb-0">Products in Order</h5>
        </div>
        <div class="card-body">
            <div class="row">
                @foreach ($order->products as $product)
                <div class="col-12 col-md-4 mb-4">
                    <a href="{{ route('front.products-details',$product->id) }}">
                        <div class="card shadow-sm">
                            <img src="{{ asset($product->cover_image) }}" alt="{{ $product->name }}" class="card-img-top">
                            <div class="card-body">
                                <h6 class="card-title font-weight-bold">{{ $product->name }}</h6>
                                <p class="text-muted mb-2">Quantity: <strong>{{ $product->pivot->quantity }}</strong></p>
                                <p class="text-muted mb-2">Price: ${{ number_format($product->pivot->price, 2) }}</p>
                                <p class="font-weight-bold">
                                    <span>Total:</span> ${{ number_format($product->pivot->quantity * $product->pivot->price, 2) }}
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Order Summary Section -->
    <div class="card shadow-lg mb-4">
        <div class="card-header bg-warning text-white">
            <h5 class="mb-0">Order Summary</h5>
        </div>
        <div class="card-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item d-flex justify-content-between">
                    <strong>Subtotal:</strong> ${{ number_format($order->sub_total, 2) }}
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <strong>Shipping Charges:</strong> ${{ number_format($order->shipping_charge, 2) }}
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <strong>Total:</strong>
                    <span class="text-success font-weight-bold">${{ number_format($order->total_order, 2) }}</span>
                </li>
            </ul>
        </div>
    </div>

    @if ($order->order_status != 'completed' && $order->order_status != 'canceled')
    <div class="d-flex justify-content-center">
        <form action="{{ route('front.orders-cancel', $order->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger btn-lg">Cancel Order</button>
        </form>
    </div>
    @endif
</div>



@stop

@section('js')

@stop
