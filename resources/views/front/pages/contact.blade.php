@extends('front.layouts.main')

@section('title', 'Contact')

@section('css')
<style>
    .map-responsive iframe {
        width: 100%;
        height: 100%;
    }
</style>
@stop
@php
 use App\Models\ContactUsSetting;
 $ContactUsSetting = ContactUsSetting::get_contact_us_details();
 @endphp
@section('content')
<main>
    <!--? Hero Start -->
    <div class="slider-area2">
        <div class="slider-height2 d-flex align-items-center">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="hero-cap hero-cap2 pt-70">
                            <h2>Contact me</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero End -->
    <!--?  Contact Area start  -->
    <section class="contact-section">
        <div class="container">
            @if ($ContactUsSetting && $ContactUsSetting['map_iframe'] != null)
            <div class="d-none d-sm-block mb-5 pb-4 map-responsive">
                {!! $ContactUsSetting['map_iframe'] !!}
            </div>
            @endif
            <div class="row">
                <div class="col-12">
                    <h2 class="contact-title">Get in Touch</h2>
                </div>
                <div class="col-lg-8">
                    <form id="form-contact" class="form-contact" action="{{ route('front.contact.message.save') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <textarea class="form-control w-100 @error('message') border border-danger @enderror" name="message" id="message" cols="30" rows="9" placeholder=" Enter Message">{{ old('message') }}</textarea>
                                    <div id="message_error" class="text-danger"> @error('message')
                                        {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input class="form-control  @error('name') border border-danger @enderror" name="name" id="name" type="text" placeholder="Enter your name" value="{{ old('name') }}">
                                    <div id="name_error" class="text-danger"> @error('name')
                                        {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input class="form-control @error('name') border border-danger @enderror" name="email" id="email" type="email" placeholder="Email" value="{{ old('email') }}">
                                    <div id="email_error" class="text-danger"> @error('email')
                                        {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <input class="form-control @error('name') border border-danger @enderror" name="subject" id="subject" type="text" placeholder="Enter Subject" value="{{ old('subject') }}">
                                    <div id="subject_error" class="text-danger"> @error('subject')
                                        {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <button type="submit" class="button button-contactForm boxed-btn">Send</button>
                        </div>
                    </form>
                </div>
                @if ($ContactUsSetting )
                <div class="col-lg-3 offset-lg-1">
                    @if($ContactUsSetting['address_1'] != null)
                    <div class="media contact-info">
                        <span class="contact-info__icon"><i class="ti-home"></i></span>
                        <div class="media-body">
                            <h3>{{$ContactUsSetting['address_1']}}</h3>
                            <p>{{$ContactUsSetting['address_2']}}</p>
                        </div>
                    </div>
                    @endif
                    @if($ContactUsSetting['phone'] != null)
                    <div class="media contact-info">
                        <span class="contact-info__icon"><i class="ti-tablet"></i></span>
                        <div class="media-body">
                            <h3>{{$ContactUsSetting['phone']}}</h3>
                            <p>{{$ContactUsSetting['timing']}}</p>
                        </div>
                    </div>
                    @endif
                    @if($ContactUsSetting['email'] != null)
                    <div class="media contact-info">
                        <span class="contact-info__icon"><i class="ti-email"></i></span>
                        <div class="media-body">
                            <h3>{{$ContactUsSetting['email']}}</h3>
                            <p>Send us your query anytime!</p>
                        </div>
                    </div>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </section>
    <!-- Contact Area End -->
    <!-- ? services-area -->
    @if ($ContactUsSetting)
    <section class="services-area">
        <div class="container">
            <div class="row justify-content-between">
            @if($ContactUsSetting ['address_1'])
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-8">
                    <div class="single-services mb-40">
                        <div class="features-icon">
                            <img src="{{ asset('assets/front/img/icon/icon1.svg') }}" alt="">
                        </div>
                        <div class="features-caption">
                            <h3>Location</h3>
                            <p>{{$ContactUsSetting ['address_1']}} , {{$ContactUsSetting ['address_2']}} </p>
                        </div>
                    </div>
                </div>
                @endif
                @if($ContactUsSetting ['phone'])
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-8">
                    <div class="single-services mb-40">
                        <div class="features-icon">
                            <img src="{{ asset('assets/front/img/icon/icon2.svg') }}" alt="">
                        </div>
                        <div class="features-caption">
                            <h3>Phone</h3>
                            <p>{{$ContactUsSetting ['phone']}}</p>
                        </div>
                    </div>
                </div>
                @endif
                @if($ContactUsSetting ['email'])
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-8">
                    <div class="single-services mb-40">
                        <div class="features-icon">
                            <img src="{{ asset('assets/front/img/icon/icon3.svg') }}" alt="">
                        </div>
                        <div class="features-caption">
                            <h3>Email</h3>
                            <p>{{$ContactUsSetting ['email']}}</p>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>
    @endif
</main>

@stop

@section('js')
<script>
    $(document).ready(function() {
        $('#form-contact').validate({
            rules: {
                name: {
                    required: true,
                },
                email: {
                    required: true,
                    email: true
                },
                subject: {
                    required: true,
                },
                phone: {
                    required: true,
                    number: true
                },
                message: {
                    required: true,
                }
            },
            // messages: {
            //     name: {
            //         required: 'This field is required',
            //     },
            //     email: {
            //         required: 'This field is required',
            //         email: 'Enter a valid email',
            //     },
            //     phone: {
            //         required: 'This field is required',
            //         number: 'Please enter a valid phone number.',
            //     },
            //     address: {
            //         required: 'This field is required',
            //     },
            //     message: {
            //         required: 'This field is required',
            //     },
            //     company_name: {
            //         required: 'This field is required',
            //     }
            // },
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
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
