@extends('front.layouts.main')
@section('title', 'Blogs Details')
@section('css')
<style>
    .blog-image {
        width: 100%;
        max-width: 800px !important;
        height: 400px !important;
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
                        <h2>Blog Details</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Hero End -->
<!--? Blog Area Start -->
<section class="blog_area single-post-area section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 posts-list">
                <div class="single-post">
                    <div class="feature-img">
                        <img class="img-fluid blog-image" src="{{ $Blog->image && isset($Blog->image) ? asset($Blog->image) : asset('custom-assets/front/placeholder/dummy-image-square.jpg') }}" alt="Blog Image">
                    </div>
                    <div class="blog_details">
                        <h2 style="color: #2d2d2d;">{{ $Blog->title }}
                        </h2>
                        <ul class="blog-info-link mt-3 mb-4">
                            <li>{{ \Carbon\Carbon::parse($Blog->published_date)->format('d-m-Y') }} |</li>
                            <li><a href="javascript:void(0);"><i class="fa fa-user"></i> {{ $Blog && $Blog->user && $Blog->user->name ? $Blog->user->name : 'Admin'  }}</a></li>
                            @if (!$Blog->tags->isEmpty())
                            <li><a href="javascript:void(0);"><i class="fa fa-tags"></i>@foreach ($Blog->tags as $tag) {{$tag->name }} @endforeach</a></li>
                            @endif
                        </ul>
                        {!! $Blog->description !!}
                    </div>
                </div>
                <div class="navigation-top">
                    <!-- <div class="d-sm-flex justify-content-between text-center">
                        <p class="like-info"><span class="align-middle"><i class="fa fa-heart"></i></span> Lily and 4
                            people like this</p>
                        <div class="col-sm-4 text-center my-2 my-sm-0">
                        </div>
                        <ul class="social-icons">
                            <li><a href="https://www.facebook.com/sai4ull"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fab fa-dribbble"></i></a></li>
                            <li><a href="#"><i class="fab fa-behance"></i></a></li>
                        </ul>
                    </div> -->
                    <div class="navigation-area">
                        <div class="row">
                            @if(isset($prevBlog) && $prevBlog != null)
                            <div
                                class="col-lg-6 col-md-6 col-12 nav-left flex-row d-flex justify-content-start align-items-center">
                                <div class="thumb">
                                    <a href="{{ route('front.blog.details', ['id' => $prevBlog->id]) }}">
                                        <img width="60px" height="60px" class="img-fluid" src="{{ $prevBlog->image && isset($prevBlog->image) ? asset($prevBlog->image) : asset('custom-assets/front/placeholder/dummy-image-square.jpg') }}" alt="prevBlog Image">
                                    </a>
                                </div>
                                <div class="arrow">
                                    <a href="{{ route('front.blog.details', ['id' => $prevBlog->id]) }}">
                                        <span class="lnr text-white ti-arrow-left"></span>
                                    </a>
                                </div>
                                <div class="detials">
                                    <p>Prev Blog</p>
                                    <a href="{{ route('front.blog.details', ['id' => $prevBlog->id]) }}">
                                        <h4 style="color: #2d2d2d;">{{ $prevBlog && $prevBlog->title ? (strlen($prevBlog->title) > 25 ? substr($prevBlog->title, 0, 25) . '..' : $prevBlog->title) : '' }}</h4>
                                    </a>
                                </div>
                            </div>
                            @endif
                            @if(isset($nextBlog) && $nextBlog != null)
                            <div
                                class="col-lg-6 col-md-6 col-12 nav-right flex-row d-flex justify-content-end align-items-center">
                                <div class="detials">
                                    <p>Next Blog</p>
                                    <a href="{{ route('front.blog.details', ['id' => $nextBlog->id]) }}">
                                        <h4 style="color: #2d2d2d;">{{ $nextBlog && $nextBlog->title ? (strlen($nextBlog->title) > 25 ? substr($nextBlog->title, 0, 25) . '..' : $nextBlog->title) : '' }}</h4>
                                    </a>
                                </div>

                                <div class="arrow">
                                    <a href="{{ route('front.blog.details', ['id' => $nextBlog->id]) }}">
                                        <span class="lnr text-white ti-arrow-right"></span>
                                    </a>
                                </div>
                                <div class="thumb">
                                    <a href="{{ route('front.blog.details', ['id' => $nextBlog->id]) }}">
                                        <img width="60px" height="60px" class="img-fluid" src="{{ $nextBlog->image && isset($nextBlog->image) ? asset($nextBlog->image) : asset('custom-assets/front/placeholder/dummy-image-square.jpg') }}" alt="nextBlog Image">
                                    </a>
                                </div>

                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="blog-author">
                    <div class="media align-items-center">
                        <img src="{{ $Blog && $Blog->user && $Blog->user->image ? $Blog->user->image : asset('custom-assets/default/front/placeholder/author-1.png') }}" alt="">
                        <div class="media-body">
                            <a href="javascript:void(0);">
                                <h4>{{ $Blog && $Blog->user && $Blog->user->name ? $Blog->user->name : 'Admin'  }}</h4>
                            </a>
                            <!-- <p>Second divided from form fish beast made. Every of seas all gathered use saying you're, he
                                    our dominion twon Second divided from</p> -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="blog_right_sidebar">
                    <aside class="single_sidebar_widget search_widget">
                        <form action="{{ route('front.blog.search') }}" method="GET">
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder='Search Keyword' name="search">
                                    <div class="input-group-append">
                                        <button class="btns" type="submit"><i class="ti-search"></i></button>
                                    </div>
                                </div>
                            </div>
                            <button class="button rounded-0 primary-bg text-white w-100 btn_1 boxed-btn"
                                type="submit">Search</button>
                        </form>
                    </aside>
                    @if (!$latestBlogs->isEmpty())
                    <aside class="single_sidebar_widget popular_post_widget">
                        <h3 class="widget_title" style="color: #2d2d2d;">Recent Post</h3>
                        @foreach ($latestBlogs as $latestBlog)
                        <div class="media post_item">
                            <img width="80px" height="80px" src="{{ $latestBlog && isset($latestBlog->image) && $latestBlog->image ? asset($latestBlog->image) : asset('custom-assets/front/placeholder/dummy-image-square.jpg') }}" alt="post">
                            <div class="media-body">
                                <a href="{{ route('front.blog.details', ['id' => $latestBlog->id]) }}">
                                    <h3 style="color: #2d2d2d;">{{ $latestBlog && $latestBlog->title ? (strlen($latestBlog->title) > 25 ? substr($latestBlog->title, 0, 25) . '..' : $latestBlog->title) : '' }}</h3>
                                </a>
                                <p>{{ \Carbon\Carbon::parse($latestBlog->published_date)->format('d-m-Y') }}</p>
                            </div>
                        </div>
                        @endforeach
                    </aside>
                    @endif
                    <aside class="single_sidebar_widget newsletter_widget">
                        <h4 class="widget_title" style="color: #2d2d2d;">Newsletter</h4>
                        <form id="form" action="{{ route('front.newsletter.save') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <input type="email" name="email" class="form-control @error('email') border border-danger @enderror" placeholder='Enter email'>
                                <div id="email_error" class="text-danger w-100 mx-4"> @error('email')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                            <button class="button rounded-0 primary-bg text-white w-100 btn_1 boxed-btn"
                                type="submit">Subscribe</button>
                        </form>
                    </aside>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Blog Area End -->


@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('#form').validate({
                rules: {
                    email: {
                        required: true,
                        email: true
                    }
                },
                // messages: {

                //     email: {
                //         required: 'This field is required',
                //         email: 'Enter a valid email',
                //     }
                // },
                errorPlacement: function(error, element) {
                    error.addClass('text-danger');
                    $('#' + element.attr('name') + '_error').html(error)
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('border border-danger');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('border border-danger');
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        });
    </script>
@stop
