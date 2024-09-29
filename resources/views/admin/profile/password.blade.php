@extends('admin.layouts.main')
@section('title', 'Password Setting')
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Account Settings /</span> Password Setting</h4>

        <div class="row">
            <div class="col-md-12">
               
                <div class="card mb-4">
                    <h5 class="card-header">Password Setting</h5>
                    <!-- Account -->

                    <hr class="my-0" />
                    <div class="card-body">
                        <form id="form" method="POST" action="{{ route('admin.profile.settings.password.save') }}">
                            @csrf
                            <div class="row">
                                <div class="mb-3 col-md-12 form-password-toggle">
                                    <label for="oldpassword" class="form-label">Old Password</label>
                                    <div class="input-group input-group-merge">
                                        <input name="oldpassword" type="password"
                                            class="form-control @error('oldpassword') is-invalid @enderror" id="oldpassword"
                                            placeholder="············" aria-describedby="basic-default-password"
                                            value="{{ old('oldpassword') }}">
                                        <span class="input-group-text cursor-pointer" id="basic-default-password"><i
                                                class="bx bx-hide"></i></span>
                                    </div>
                                    <div id="oldpassword_error" class="text-danger"> @error('oldpassword')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3 col-md-12 form-password-toggle">
                                    <label for="newpassword" class="form-label">New Password</label>
                                    <div class="input-group input-group-merge">
                                        <input name="newpassword" type="text"
                                            class="form-control @error('newpassword') is-invalid @enderror" id="newpassword"
                                            placeholder="············" aria-describedby="basic-default-password"
                                            value="{{ old('newpassword') }}">
                                        <span class="input-group-text cursor-pointer" id="basic-default-password"><i
                                                class="bx bx-hide"></i></span>
                                    </div>
                                    <div id="newpassword_error" class="text-danger"> @error('newpassword')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 col-md-12 form-password-toggle">
                                    <label class="form-label" for="confirmnewpassword">Confirm New Password</label>
                                    <div class="input-group input-group-merge">
                                        <input name="confirmnewpassword" type="password"
                                            class="form-control @error('confirmnewpassword') is-invalid @enderror"
                                            id="confirmnewpassword" placeholder="············"
                                            aria-describedby="basic-default-password"
                                            value="{{ old('confirmnewpassword') }}">
                                        <span class="input-group-text cursor-pointer" id="basic-default-password"><i
                                                class="bx bx-hide"></i></span>
                                    </div>
                                    <div id="confirmnewpassword_error" class="text-danger">
                                        @error('confirmnewpassword')
                                            {{ $message }}
                                        @enderror
                                    </div>

                                </div>
                            </div>
                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary me-2">Save changes</button>
                            </div>
                        </form>
                    </div>
                    <!-- /Account -->
                </div>
            </div>
        </div>
    </div>
@stop
@section('js')
    <script src="{{ asset('assets/admin/js/jquery.validate.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#form').validate({
                rules: {
                    oldpassword: {
                        required: true,
                        minlength: 6,
                    },
                    newpassword: {
                        required: true,
                        minlength: 6,
                    },
                    confirmnewpassword: {
                        required: true,
                        minlength: 6,
                        equalTo: "#newpassword"
                    }
                },
                messages: {
                    password: {
                        required: 'This field is required',
                        minlength: 'Old Password must be at least 6 characters long'
                    },
                    newpassword: {
                        required: 'This field is required',
                        minlength: 'New Password must be at least 6 characters long'
                    },
                    confirmnewpassword: {
                        required: 'This field is required',
                        minlength: 'Confirm Password must be at least 6 characters long',
                        equalTo: 'Confirm password and New Password is not same'
                    }
                },
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    $('#' + element.attr('name') + '_error').html(error)
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        });
    </script>
@stop
