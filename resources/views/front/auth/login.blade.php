@extends('front.layouts.main')
@section('title', 'Login & Register')
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
                        <h2 class="text-white">Login & Register</h2>
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
        <div class="row">
            <!-- Login Section -->
            <div class="col-md-5">
                <h5 class="text-center">Login</h5>
                <form id="login-form" class="form-contact" action="{{ route('front.post.login') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="login_email">Email address</label>
                        <input class="form-control @error('login_email') border border-danger @enderror" name="login_email" id="login_email" type="text" placeholder="Enter Email" value="{{ old('login_email') }}">
                        <div id="login_email_error" class="text-danger">
                            @error('login_email') {{ $message }} @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="login_password">Password</label>
                        <input class="form-control @error('login_password') border border-danger @enderror" name="login_password" id="login_password" type="login_password" placeholder="Enter Password" value="{{ old('login_password') }}">
                        <div id="login_password_error" class="text-danger">
                            @error('login_password') {{ $message }} @enderror
                        </div>
                        <a href="{{ route('front.forgotpassword') }}"> <small id="emailHelp" class="fa-1x form-text text-muted">
                                                <small>Forgot Password?</small>
                                            </small></a>
                    </div>

                    <button type="submit" class="button boxed-btn">Login</button>
                </form>
            </div>

            <!-- Divider -->
            <div class="col-md-2 d-none d-md-flex justify-content-center align-items-center">
                <div style="border-left: 1px solid #ccc; height: 100%;"></div>
            </div>
            <div class="col-12 d-md-none text-center py-3">
                <hr>
            </div>

            <!-- Register Section -->
            <div class="col-md-5">
                <h5 class="text-center">Register</h5>
                <form id="register-form" class="form-contact" action="{{ route('front.post.register') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input class="form-control @error('name') border border-danger @enderror" name="name" id="name" type="text" placeholder="Enter Full Name" value="{{ old('name') }}">
                        <div id="name_error" class="text-danger">
                            @error('name') {{ $message }} @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input class="form-control @error('email') border border-danger @enderror" name="email" id="email" type="email" placeholder="Enter Email" value="{{ old('email') }}">
                        <div id="email_error" class="text-danger">
                            @error('email') {{ $message }} @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input class="form-control @error('password') border border-danger @enderror" name="password" id="password" type="password" placeholder="Enter Password">
                        <div id="password_error" class="text-danger">
                            @error('password') {{ $message }} @enderror
                        </div>
                    </div>
                    <button type="submit" class="button boxed-btn">Register</button>
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
                login_email: {
                    required: true,
                    email: true
                },
                login_password: {
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
