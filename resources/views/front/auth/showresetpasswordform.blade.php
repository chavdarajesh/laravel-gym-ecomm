@extends('front.layouts.main')
@section('title', 'Reset Password')
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
                        <h2 class="text-white">Reset Password</h2>
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
            <div class="col-md-5">
                <h5 class="text-center">Reset Password</h5>
                <form id="login-form" class="form-contact" action="{{ route('front.reset.password.post') }}" method="POST">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="form-group">
                        <label for="newpassword">New Password</label>
                        <input class="form-control @error('newpassword') border border-danger @enderror" name="newpassword" id="newpassword" type="newpassword" placeholder="Enter Password" value="{{ old('newpassword') }}">
                        <div id="newpassword_error" class="text-danger">
                            @error('newpassword') {{ $message }} @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="confirmnewpasswod">New Conform Password</label>
                        <input class="form-control @error('confirmnewpasswod') border border-danger @enderror" name="confirmnewpasswod" id="confirmnewpasswod" type="confirmnewpasswod" placeholder="Enter Password" value="{{ old('confirmnewpasswod') }}">
                        <div id="confirmnewpasswod_error" class="text-danger">
                            @error('confirmnewpasswod') {{ $message }} @enderror
                        </div>
                    </div>

                    <button type="submit" class="button boxed-btn">Login</button>
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
                newpassword: {
                    required: true,
                    minlength: 6,
                },
                confirmnewpasswod: {
                    required: true,
                    minlength: 6,
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
