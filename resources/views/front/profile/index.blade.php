@extends('front.layouts.main')
@section('title', 'Profile')
@section('css')

@stop

@section('content')
<!--? Hero Start -->
<div class="slider-area2">
    <div class="slider-height2 d-flex align-items-center">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="hero-cap hero-cap2 pt-70">
                        <h2 class="text-white">Profile</h2>
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
                <h5 class="text-center">Profile</h5>
                <form id="register-form" class="form-contact" action="{{ route('front.post.profilepage') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input class="form-control @error('name') border border-danger @enderror" name="name" id="name" type="text" placeholder="Enter Full Name" value="{{ $user->name }}">
                        <div id="name_error" class="text-danger">
                            @error('name') {{ $message }} @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input class="form-control @error('email') border border-danger @enderror" name="email" id="email" type="email" placeholder="Enter Email" value="{{ $user->email }}">
                        <div id="email_error" class="text-danger">
                            @error('email') {{ $message }} @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input class="form-control @error('phone') border border-danger @enderror" name="phone" id="phone" type="tel" placeholder="Enter Phone" value="{{ $user->phone }}">
                        <div id="phone_error" class="text-danger">
                            @error('phone') {{ $message }} @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea name="address" class="form-control @error('address') border border-danger @enderror" name="address" id="address"
                            rows="2" placeholder="Enter Address" required>{{ $user->address }}</textarea>
                        <div id="address_error" class="text-danger">
                            @error('address') {{ $message }} @enderror
                        </div>
                    </div>
                    <button type="submit" class="button boxed-btn">Save</button>
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
                <h5 class="text-center">Password Setting</h5>
                <form id="password-form" class="form-contact" action="{{ route('front.post.profile.changepassword') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="oldpassword">Current Password</label>
                        <input class="form-control @error('oldpassword') border border-danger @enderror" name="oldpassword" id="oldpassword" type="password" placeholder="Enter Password">
                        <div id="oldpassword_error" class="text-danger">
                            @error('oldpassword') {{ $message }} @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="newpassword">New Password</label>
                        <input class="form-control @error('newpassword') border border-danger @enderror" name="newpassword" id="newpassword" type="password" placeholder="Enter Password" value="{{ old('newpassword') }}">
                        <div id="newpassword_error" class="text-danger">
                            @error('newpassword') {{ $message }} @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="confirmnewpasswod">New Conform Password</label>
                        <input class="form-control @error('confirmnewpasswod') border border-danger @enderror" name="confirmnewpasswod" id="confirmnewpasswod" type="text" placeholder="Enter Password" value="{{ old('confirmnewpasswod') }}">
                        <div id="confirmnewpasswod_error" class="text-danger">
                            @error('confirmnewpasswod') {{ $message }} @enderror
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
        $('#register-form').validate({
            rules: {
                email: {
                    required: true,
                    email: true
                },
                name: {
                    required: true,
                },
                address: {
                    required: true,
                },
                phone: {
                    required: true,
                    digits: true,
                    minlength: 10,
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

    $(document).ready(function() {
        $('#password-form').validate({
            rules: {
                oldpassword: {
                    required: true,
                    minlength: 6,
                },
                confirmnewpasswod: {
                    required: true,
                    minlength: 6,
                },
                newpassword: {
                    required: true,
                    minlength: 6,
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
