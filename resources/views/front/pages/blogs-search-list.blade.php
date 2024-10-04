@extends('front.layouts.main')
@section('title', 'Search Blog : '.$search)
@section('css')
<style>
    .blog-pagination .page-item.active .page-link {
        background-color: #FF0000;
        border-color: #fff;
        color: #fff;
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
                        <h2>Search Blog : {{$search}} </h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Hero End -->
<!--? Blog Area Start-->
<section class="blog_area section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="blog_right_sidebar">
                    <aside class="single_sidebar_widget search_widget">
                        <form action="{{ route('front.blog.search') }}" method="GET">
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder='Search Keyword' name="search" value="{{$search}}">
                                    <div class="input-group-append">
                                        <button class="btns" type="submit"><i class="ti-search"></i></button>
                                    </div>
                                </div>
                            </div>
                            <!-- <button class="button rounded-0 primary-bg text-white w-100 btn_1 boxed-btn"
                                type="submit">Search</button> -->
                        </form>
                    </aside>
                </div>
            </div>
            <div class="col-lg-12 mb-5 mb-lg-0">
                @if (!$Blogs->isEmpty())
                <div class="blog_left_sidebar">
                    @foreach ($Blogs as $Blog)
                    <article class="blog_item">
                        <div class="blog_item_img">
                            <img width="800px" height="400px" class="card-img rounded-0" src="{{ $Blog && isset($Blog->image) && $Blog->image ? asset($Blog->image) : asset('custom-assets/front/placeholder/dummy-image-square.jpg') }}" alt="Blog Image">
                            <a href="{{ route('front.blog.details', ['id' => $Blog->id]) }}" class="blog_item_date">
                            <h3>{{ \Carbon\Carbon::parse($Blog->published_date)->format('d') }}</h3>
                            <p>{{ \Carbon\Carbon::parse($Blog->published_date)->format('M') }}</p>
                            </a>
                        </div>
                        <div class="blog_details">
                            <a class="d-inline-block" href="{{ route('front.blog.details', ['id' => $Blog->id]) }}">
                                <h2 class="blog-head" style="color: #2d2d2d;">{{ $Blog && $Blog->title ? (strlen($Blog->title) > 70 ? substr($Blog->title, 0, 70) . '..' : $Blog->title) : '' }}</h2>
                            </a>
                            <p>{{ $Blog && $Blog->description ? (strlen($Blog->description) > 150 ? substr(strip_tags($Blog->description), 0, 150) . '..' : strip_tags($Blog->description)) : '' }}</p>
                            <ul class="blog-info-link">
                            <li>{{ \Carbon\Carbon::parse($Blog->published_date)->format('d-m-Y') }} |</li>
                                <li><a href="javascript:void(0);"><i class="fa fa-user"></i> {{ $Blog && $Blog->user && $Blog->user->name ? $Blog->user->name : 'Admin'  }}</a></li>
                                @if (!$Blog->tags->isEmpty())
                                <li><span><i class="fa fa-tags"></i>{{ implode(', ', $Blog->tags->pluck('name')->toArray()) }}</span></li>
                                @endif
                            </ul>
                        </div>
                    </article>
                    @endforeach
                    <!-- <nav class="blog-pagination justify-content-center d-flex">
                        <ul class="pagination">
                            <li class="page-item">
                                <a href="#" class="page-link" aria-label="Previous">
                                    <i class="ti-angle-left"></i>
                                </a>
                            </li>
                            <li class="page-item">
                                <a href="#" class="page-link">1</a>
                            </li>
                            <li class="page-item active">
                                <a href="#" class="page-link">2</a>
                            </li>
                            <li class="page-item">
                                <a href="#" class="page-link" aria-label="Next">
                                    <i class="ti-angle-right"></i>
                                </a>
                            </li>
                        </ul>
                    </nav> -->
                    {{ $Blogs->links('vendor.pagination.bootstrap-4') }}
                </div>
                @else
                <div class="d-flex flex-column align-items-center">
                    <h2 class="blog-head d-flex flex-column" style="color: #2d2d2d;">No result found for {{$search}}!</h2>
                    <div class="d-flex flex-column align-items-center">
                        <a href="{{route('front.blogs')}}" class="button rounded-0 primary-bg text-white btn_1 boxed-btn"
                            type="submit">Blogs</a>
                    </div>
                </div>
                @endif
            </div>
            <div class="col-lg-12">
                <div class="blog_right_sidebar">
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
