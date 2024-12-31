@extends('front.layouts.main')
@section('title', 'OTP Verification')
@php
    use App\Models\User;
@endphp
@section('css')
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
                        <h2 class="text-white">OTP Verification</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Hero End -->
<!--? Team -->



<section class="py-5" id="auth-section">
    <div class="container py-5">
        <div class="row d-flex justify-content-center">
            <!-- Login Section -->
            <div class="col-md-6">
                <h5 class="text-center">OTP Verification</h5>
                <form id="login-form" class="form-contact" action="{{ route('front.post.otp_verification') }}" method="POST">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $user_id  ? $user_id : ''}}">
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input class="form-control @error('email') border border-danger @enderror" name="email" id="email" type="text" placeholder="Enter Email" value="{{ User::get_user_by_id($user_id)->email ? User::get_user_by_id($user_id)->email : old('email')}}">
                        <div id="email_error" class="text-danger">
                            @error('email') {{ $message }} @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="otp">OTP</label>
                        <input class="form-control @error('otp') border border-danger @enderror" name="otp" id="otp" minlength="6" type="number" placeholder="Enter OTP">
                        <div id="otp_error" class="text-danger">
                            @error('otp') {{ $message }} @enderror
                        </div>
                    </div>
                    <button type="submit" class="button boxed-btn">Submit</button>
                </form>
            </div>
        </div>
    </div>
</section>

@stop

@section('js')
<script>
    $(document).ready(function() {
        $('#login-form').validate({
            rules: {
                email: {
                    required: true,
                    email: true
                },
                otp: {
                    minlength: 6,
                    maxlength: 6,
                    required: true,
                }
            },
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
