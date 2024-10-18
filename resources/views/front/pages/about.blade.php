@extends('front.layouts.main')
@section('title', 'About')
@section('css')

@stop
@php
use App\Models\SiteSetting;
$video_section_youtube_video_id = SiteSetting::getSiteSettings('video_section_youtube_video_id');
@endphp
@section('content')
<!--? Hero Start -->
<div class="slider-area2">
    <div class="slider-height2 d-flex align-items-center">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="hero-cap hero-cap2 pt-70">
                        <h2>About Me</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Hero End -->
<!--? Team -->
<section class="team-area pt-80">
    <div class="container">
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
<!--? About Area-2 Start -->
<section class="about-area2 fix pb-padding pt-50 pb-80">
    <div class="support-wrapper align-items-center">
        <div class="right-content2 wow fadeInUp" data-wow-duration="1s" data-wow-delay=".2s">
            <!-- img -->
            <div class="right-img">
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
@stop
