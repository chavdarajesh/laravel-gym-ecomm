@extends('front.layouts.main')
@section('title', 'Your Orders')
@section('css')
<style>
    .card {
        border-radius: 10px;
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }

    .card:hover {
        transform: scale(1.02);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    }

    .card-title {
        font-weight: bold;
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
                        <h2 class="text-white">Your Orders</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Hero End -->
<!--? Team -->



<div class="container pt-5 pb-5">
    <h2 class="mb-4 text-center">Orders</h2>
    @if($orders->isEmpty())
    <div class="text-center">
        <h4 class="text-muted">No orders found.</h4>
        <p>It looks like there are no orders at the moment. Please check back later.</p>
        <a class="btn btn-warning product-list-btn" href="{{route('front.products')}}"> <i class="fas fa-shopping-bag mr-2"></i>Continue shopping</a>
    </div>

</div>
@else
<div class="row d-flex justify-content-center">
    @foreach($orders as $order)
    <div class="col-md-6 col-lg-4 mb-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Order #{{ $order->id }}</h5>
                <p class="card-text">
                    <strong>User:</strong> {{ $order->user->name }}<br>
                    <strong>Total Amount:</strong> ${{ number_format($order->total_order, 2) }}<br>
                    <strong>Status:</strong>
                    <span class="">
                        {{  $order->statuses()
    ->orderBy('pivot_created_at', 'desc') // Use pivot table's `created_at` column
    ->first()->name; }}
                    </span><br>
                    <strong>Order Date:</strong> {{ $order->created_at->format('d M Y') }}
                </p>
                <a href="{{ route('front.orders-details', $order->id) }}" class="btn btn-warning btn-block">View Details</a>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif
</div>

@stop

@section('js')

@stop
