@extends('front.layouts.main')
@section('title', 'Profile')
@section('content')

<div class="slider-area2">
    <div class="slider-height2 d-flex align-items-center">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="hero-cap hero-cap2 pt-70">
                        <h2 class="text-white">Profile</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div>

    <form action="{{ route('addmoney.paypal') }}" method="post">
        @csrf
        <input type="text" name="amount" value="10">

        <button type="submit">Submit</button>
    </form>
</div>
@stop
