@extends('front.layouts.main')
@section('title', 'Forgot Password')
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
                        <h2 class="text-white">Forgot Password</h2>
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
                <h5 class="text-center">Forgot Password</h5>
                <form id="login-form" class="form-contact" action="{{ route('front.post.forgotpassword') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input class="form-control @error('email') border border-danger @enderror" name="email" id="email" type="text" placeholder="Enter Email" value="{{ old('email') }}">
                        <div id="email_error" class="text-danger">
                            @error('email') {{ $message }} @enderror
                        </div>
                    </div>
                    <button type="submit" class="button boxed-btn">Send Reset Link</button>
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
