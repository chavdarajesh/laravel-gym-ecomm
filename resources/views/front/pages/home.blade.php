@extends('front.layouts.main')

@section('title', 'Home')

@section('css')

@stop
@php
use App\Models\SiteSetting;
$services_membership_plans_price = SiteSetting::getSiteSettings('services_membership_plans_price');
$services_personal_training_price = SiteSetting::getSiteSettings('services_personal_training_price');
$services_zumba_classes_price = SiteSetting::getSiteSettings('services_zumba_classes_price');
$video_section_youtube_video_id = SiteSetting::getSiteSettings('video_section_youtube_video_id');
@endphp
@section('content')

<!--? slider Area Start-->
<div class="slider-area position-relative">
    <div class="slider-active">
        <!-- Single Slider -->
        <div class="single-slider slider-height d-flex align-items-center">
            <div class="container">
                <div class="row">
                    <div class="col-xl-9 col-lg-9 col-md-10">
                        <div class="hero__caption">
                            <span data-animation="fadeInLeft" data-delay="0.1s">Push Your Limits Anytime</span>
                            <h2 class="text-white fa-5x" data-animation="fadeInLeft" data-delay="0.4s"> CORE GYM, Where Fitness Is Limitless.</h2>
                            <a href="{{route('front.contact')}}" class="border-btn hero-btn" data-animation="fadeInLeft"
                                data-delay="0.8s">Join Us</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- slider Area End-->
<!-- Traning categories Start -->
<section class="traning-categories black-bg">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-6 col-lg-6">
                <div class="single-topic text-center mb-30">
                    <div class="topic-img">
                        <img src="{{ asset('assets/front/img/gallery/cat1.png') }}" alt="">
                        <div class="topic-content-box">
                            <div class="topic-content">
                                <h3>Personal traning</h3>
                                <p>Achieve ultimate results with one-on-one sessions <br> designed specifically for your fitness goals.
                                </p>
                                <!-- <a href="courses.html" class="border-btn">View Courses</a> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6">
                <div class="single-topic text-center mb-30">
                    <div class="topic-img">
                        <img src="{{ asset('assets/front/img/gallery/cat2.png') }}" alt="">
                        <div class="topic-content-box">
                            <div class="topic-content">
                                <h3>Group traning</h3>
                                <p>Join high-energy training sessions that inspires you
                                    <br> and help to push your limits with others.
                                </p>
                                <!-- <a href="courses.html" class="btn">View Courses</a> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Traning categories End-->
<!--? Team -->
<section class="team-area fix">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="section-tittle text-center mb-55 wow fadeInUp" data-wow-duration="1s"
                    data-wow-delay=".1s">
                    <h2>WHAT WE OFFER
                    </h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="single-cat text-center mb-30 wow fadeInUp" data-wow-duration="1s"
                    data-wow-delay=".2s">
                    <div class="cat-icon">
                        <img src="{{ asset('assets/front/img/gallery/team1.png') }}" alt="">
                    </div>
                    <div class="cat-cap">
                        <h5><a href="javascript:void(0);">Body Building</a></h5>
                        <p>Sculpt and strengthen your physique with expert training programs for body gains. </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="single-cat text-center mb-30 wow fadeInUp" data-wow-duration="1s"
                    data-wow-delay=".4s">
                    <div class="cat-icon">
                        <img src="{{ asset('assets/front/img/gallery/team2.png') }}" alt="">
                    </div>
                    <div class="cat-cap">
                        <h5><a href="javascript:void(0);">Muscle Gain</a></h5>
                        <p>Build perfect muscle mass with routines and supplements to enhance your strength.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="single-cat text-center mb-30 wow fadeInUp" data-wow-duration="1s"
                    data-wow-delay=".6s">
                    <div class="cat-icon">
                        <img src="{{ asset('assets/front/img/gallery/team3.png') }}" alt="">
                    </div>
                    <div class="cat-cap">
                        <h5><a href="javascript:void(0);">Weight Loss</a></h5>
                        <p>Achieve your ideal weight with workouts and nutrition plans for effective weight loss. </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Services End -->
<!--? Gallery Area Start -->
<div class="gallery-area section-padding30 ">
    <div class="container-fluid ">
        <div class="row">
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                <div class="box snake mb-30">
                    <div class="gallery-img big-img"
                        style="background-image: url({{ asset('assets/front/img/gallery/gallery1.png') }});"></div>
                    <div class="overlay">
                        <div class="overlay-content">
                            <h3>Muscle gaining </h3>
                            <a href="javascript:void(0);"><i class="ti-plus"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                <div class="box snake mb-30">
                    <div class="gallery-img big-img"
                        style="background-image: url({{ asset('assets/front/img/gallery/gallery2.png') }});"></div>
                    <div class="overlay">
                        <div class="overlay-content">
                            <h3>Muscle gaining </h3>
                            <a href="javascript:void(0);"><i class="ti-plus"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                <div class="box snake mb-30">
                    <div class="gallery-img big-img"
                        style="background-image: url({{ asset('assets/front/img/gallery/gallery3.png') }});"></div>
                    <div class="overlay">
                        <div class="overlay-content">
                            <h3>Muscle gaining </h3>
                            <a href="javascript:void(0);"><i class="ti-plus"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                <div class="box snake mb-30">
                    <div class="gallery-img big-img"
                        style="background-image: url({{ asset('assets/front/img/gallery/gallery4.png') }});"></div>
                    <div class="overlay">
                        <div class="overlay-content">
                            <h3>Muscle gaining </h3>
                            <a href="javascript:void(0);"><i class="ti-plus"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                <div class="box snake mb-30">
                    <div class="gallery-img big-img"
                        style="background-image: url({{ asset('assets/front/img/gallery/gallery5.png') }});"></div>
                    <div class="overlay">
                        <div class="overlay-content">
                            <h3>Muscle gaining </h3>
                            <a href="javascript:void(0);"><i class="ti-plus"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                <div class="box snake mb-30">
                    <div class="gallery-img big-img"
                        style="background-image: url({{ asset('assets/front/img/gallery/gallery6.png') }});"></div>
                    <div class="overlay">
                        <div class="overlay-content">
                            <h3>Muscle gaining </h3>
                            <a href="javascript:void(0);"><i class="ti-plus"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Gallery Area End -->
@if (
(isset($services_membership_plans_price) && isset($services_membership_plans_price->value)) ||
(isset($services_personal_training_price) && isset($services_personal_training_price->value)) ||
(isset($services_zumba_classes_price) && isset($services_zumba_classes_price->value)))
<!-- Courses area start -->
<section class="pricing-area section-padding30 fix">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="section-tittle text-center mb-55">
                    <h2>Our Services</h2>
                </div>
            </div>
        </div>
        <div class="row">
            @if (isset($services_membership_plans_price) &&
            isset($services_membership_plans_price->value) &&
            $services_membership_plans_price != null &&
            $services_membership_plans_price->value != '')
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="properties mb-30">
                    <div class="properties__card">
                        <div class="about-icon">
                            <img src="{{ asset('assets/front/img/icon/price.svg') }}" alt="">
                        </div>
                        <div class="properties__caption">
                            <span class="month">Membership Plans</span>
                            <p class="mb-25">{{ $services_membership_plans_price->value }} <span>(Yearly and Weekly)</span></p>
                            <a href="{{ route('front.contact') }}" class="border-btn border-btn2">Join Now</a>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @if (isset($services_personal_training_price) &&
            isset($services_personal_training_price->value) &&
            $services_personal_training_price != null &&
            $services_personal_training_price->value != '')
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="properties mb-30">
                    <div class="properties__card">
                        <div class="about-icon">
                            <img src="{{ asset('assets/front/img/icon/price.svg') }}" alt="">
                        </div>
                        <div class="properties__caption">
                            <span class="month">Personal Training</span>
                            <p class="mb-25">{{ $services_personal_training_price->value }} <span>(Per Day Plan)</span></p>
                            <a href="{{ route('front.contact') }}" class="border-btn border-btn2">Join Now</a>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @if (isset($services_zumba_classes_price) &&
            isset($services_zumba_classes_price->value) &&
            $services_zumba_classes_price != null &&
            $services_zumba_classes_price->value != '')
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="properties mb-30">
                    <div class="properties__card">
                        <div class="about-icon">
                            <img src="{{ asset('assets/front/img/icon/price.svg') }}" alt="">
                        </div>
                        <div class="properties__caption">
                            <span class="month">Zumba Classes</span>
                            <p class="mb-25">{{ $services_zumba_classes_price->value }} <span>(Per Class)</span></p>
                            <a href="{{ route('front.contact') }}" class="border-btn border-btn2">Join Now</a>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
@endif
<!--? About Area-2 Start -->
<section class="about-area2 fix pb-padding pt-50 pb-80">
    <div class="support-wrapper align-items-center">
        <div class="right-content2">
            <!-- img -->
            <div class="right-img wow fadeInUp" data-wow-duration="1s" data-wow-delay=".1s">
                <img src="{{ asset('assets/front/img/gallery/about.png') }}" alt="">
            </div>
        </div>
        <div class="left-content2">
            <!-- section tittle -->
            <div class="section-tittle2 mb-20 wow fadeInUp" data-wow-duration="1s" data-wow-delay=".3s">
                <div class="front-text">
                    <h2 class="">About Me</h2>
                    <p>At CORE GYM, we are dedicated to offering a 24/7 fitness experience that fits into your busy lifestyle. Our goal is to help you achieve your personal fitness goals with the best equipment, expert trainers, and an environment that keeps you motivated, no matter your level.</p>
                        <p class="mb-40">In addition to our gym services, we offer a premium range of supplements designed to fuel your workouts and enhance recovery. From muscle gain to weight loss, our scientifically-backed products support your fitness journey, helping you unlock your full potential.</p>
                        <a href="{{route('front.contact')}}" class="border-btn">Join Us</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- About Area End -->
<!--? Blog Area Start -->
@if (!$Blogs->isEmpty())
<section class="home-blog-area pt-10 pb-50">
    <div class="container">
        <!-- Section Tittle -->
        <div class="row justify-content-center">
            <div class="col-lg-7 col-md-9 col-sm-10">
                <div class="section-tittle text-center mb-100 wow fadeInUp" data-wow-duration="2s"
                    data-wow-delay=".2s">
                    <h2>From Blog</h2>
                </div>
            </div>
        </div>
        <div class="row">
        @foreach ($Blogs as $Blog)
            <div class="col-xl-6 col-lg-6 col-md-6">
                <div class="home-blog-single mb-30 wow fadeInUp" data-wow-duration="1s" data-wow-delay=".4s">
                    <div class="blog-img-cap">
                        <div class="blog-img">
                            <img src="{{ $Blog && isset($Blog->image) && $Blog->image ? asset($Blog->image) : asset('custom-assets/front/placeholder/dummy-image-square.jpg') }}" alt="Blog Image">
                        </div>
                        <div class="blog-cap">
                            <span>{{ implode(', ', $Blog->tags->pluck('name')->toArray()) }}</span>
                            <h3><a href="{{ route('front.blog.details', ['id' => $Blog->id]) }}">{{ $Blog && $Blog->title ? (strlen($Blog->title) > 70 ? substr($Blog->title, 0, 70) . '..' : $Blog->title) : '' }}</a></h3>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
<!-- Blog Area End -->
<!--? video_start -->
@if (isset($video_section_youtube_video_id) && isset($video_section_youtube_video_id->value))
<div class="video-area section-bg2 d-flex align-items-center" data-background="{{ asset('assets/front/img/gallery/video-bg.png') }}">
    <div class="container">
        <div class="video-wrap position-relative">
            <div class="video-icon">
                <a class="popup-video btn-icon" href="https://www.youtube.com/watch?v={{$video_section_youtube_video_id->value}}"><i
                        class="fas fa-play"></i></a>
            </div>
        </div>
    </div>
</div>
@endif
<!-- video_end -->
@stop
@section('js')

@stop
