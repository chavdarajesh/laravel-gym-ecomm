@extends('front.layouts.main')
@section('title', 'Login')
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
                        <h2 class="text-white">Login</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Hero End -->
<!--? Team -->



<section class="py-5" id="login">
    <h5 class="text-center">Login</h5>
    <div class="container d-flex justify-content-center py-5">
        <div class="row">
            <form id="login-form" class="form-contact" action="{{ route('front.post.login') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-sm-12 mb-3">
                        <div>
                            <input class="form-control @error('email') border border-danger @enderror" name="email" id="email" type="text" placeholder="Enter Email" value="{{ old('email') }}">
                            <div id="email_error" class="text-danger"> @error('email')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 mb-3">
                        <div>
                            <input class="form-control  @error('password') border border-danger @enderror" name="password" id="password" type="password" placeholder="Enter Password" value="{{ old('password') }}">
                            <div id="password_error" class="text-danger"> @error('password')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <button type="submit" class="button boxed-btn">Login</button>
                </div>
            </form>
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
                password: {
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
