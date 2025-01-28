@extends('admin.layouts.main')
@section('title', 'Create User')
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Users /</span> All Users / Create User</h4>

        <div class="row">
            <div class="col-md-12">

                <div class="card mb-4">
                    <h5 class="card-header">Create User</h5>
                    <hr class="my-0" />
                    <div class="card-body">
                        <form id="form" method="POST" action="{{ route('admin.users.save') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <!-- <div class="row mb-3">
                                <div class="d-flex align-items-start align-items-sm-center gap-4">
                                    <img src="{{ asset('assets/admin/img/avatars/1.png') }}" alt="user-avatar"
                                        class="d-block rounded" height="100" width="100" id="uploadedAvatar" />
                                    <div id="dvPreview">
                                    </div>
                                    <div class="button-wrapper">
                                        <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                            <span class="d-none d-sm-block">Upload new photo</span>
                                            <i class="bx bx-upload d-block d-sm-none"></i>
                                            <input type="file" id="upload" class="account-file-input" hidden
                                                accept="image/*" name="image" onchange="readURL(this)" />
                                        </label>
                                        <p class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 4Mb</p>
                                    </div>
                                </div>
                                <div id="image_error" class="text-danger"> @error('image')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div> -->

                            <div class="row">
                                <div class="mb-3 col-md-12">
                                    <label for="name" class="form-label">Name</label>
                                    <input class="form-control  @error('name') is-invalid @enderror" type="text"
                                        id="name" name="name" value="{{ old('name') }}" autofocus />
                                    <div id="name_error" class="text-danger"> @error('name')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3 col-md-12">
                                    <label for="email" class="form-label">E-mail</label>
                                    <input class="form-control  @error('email') is-invalid @enderror" type="text"
                                        id="email" name="email" value="{{ old('email') }}" />
                                    <div id="email_error" class="text-danger"> @error('email')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 col-md-12">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input class="form-control  @error('phone') is-invalid @enderror" type="text"
                                        id="phone" name="phone" value="{{ old('phone') }}" />
                                    <div id="phone_error" class="text-danger"> @error('phone')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3 col-md-12">
                                    <label for="adminname" class="form-label">Address</label>
                                    <textarea name="address" id="address" rows="3" class="form-control @error('address') is-invalid @enderror">{{ old('address') }}</textarea>
                                    <div id="address_error" class="text-danger"> @error('address')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                                <!-- <div class="mb-3 col-md-12">
                                    <label for="dateofbirth" class="form-label">Date OF Birth</label>
                                    <input class="form-control @error('dateofbirth') is-invalid @enderror" type="date"
                                        id="dateofbirth" name="dateofbirth" value="{{ old('dateofbirth') }}" />
                                    <div id="dateofbirth_error" class="text-danger"> @error('dateofbirth')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div> -->
                                <div class="mb-3 col-md-12 form-password-toggle">
                                    <label for="password" class="form-label"> Password</label>
                                    <div class="input-group input-group-merge">
                                        <input autocomplete="off" name="password" type="password"
                                            class="form-control  @error('dateofbirth') is-invalid @enderror"
                                            id="password" placeholder="············"
                                            aria-describedby="basic-default-password">
                                        <span class="input-group-text cursor-pointer" id="basic-default-password"><i
                                                class="bx bx-hide"></i></span>
                                    </div>
                                    <div id="password_error" class="text-danger">
                                        @error('password')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 col-md-12 form-password-toggle">
                                    <label for="confirmpassword" class="form-label">Conform Password</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="confirmpassword"
                                            class="form-control  @error('confirmpassword') is-invalid @enderror"
                                            name="confirmpassword"
                                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                            aria-describedby="password" value="{{ old('confirmpassword') }}" />
                                        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                    </div>
                                    <div id="confirmpassword_error" class="text-danger">
                                        @error('confirmpassword')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                                <!-- <div class="mb-3 col-md-12">
                                    <label for="referral_code" class="form-label">Used Referral Code</label>
                                    <input class="form-control @error('referral_code') is-invalid @enderror"
                                        type="text" id="referral_code" name="referral_code"
                                        value="{{ old('referral_code') }}" />
                                    <div id="referral_code_error" class="text-danger"> @error('referral_code')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div> -->

                            </div>
                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary me-2">Save</button>
                                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Back</a>
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
        // function readURL(input) {
        //     if (input.files && input.files[0]) {
        //         if (input.files[0].type.startsWith('image/')) {
        //             var reader = new FileReader();
        //             reader.onload = function(e) {
        //                 document.querySelector("#uploadedAvatar").setAttribute("src", e.target.result);
        //             };
        //             reader.readAsDataURL(input.files[0]);
        //         } else {
        //             $('#image_error').html('Allowed JPG, GIF or PNG.')
        //             $('#upload').val('');
        //         }
        //     }
        // }
        // dateofbirth.max = new Date().toISOString().split("T")[0];
    </script>

    <script>
        $(document).ready(function() {
            $('#form').validate({
                rules: {
                    name: {
                        required: true,
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    phone: {
                        required: true,
                        minlength: 10,
                    },
                    address: {
                        required: true,
                    },
                    // dateofbirth: {
                    //     required: true,
                    // },
                    password: {
                        required: true,
                        minlength: 6,
                    },
                    confirmpassword: {
                        required: true,
                        minlength: 6,
                        equalTo: "#password"
                    }
                },
                messages: {
                    name: {
                        required: 'This field is required',
                    },
                    email: {
                        required: 'This field is required',
                        email: 'Enter a valid email',
                    },
                    phone: {
                        required: 'This field is required',
                        minlength: 'Phone must be at least 10 characters long'
                    },
                    address: {
                        required: 'This field is required',
                    },
                    // dateofbirth: {
                    //     required: 'This field is required',
                    // },
                    password: {
                        required: 'This field is required',
                        minlength: 'Password must be at least 6 characters long'
                    },
                    confirmpassword: {
                        required: 'This field is required',
                        minlength: 'Confirm password must be at least 6 characters long',
                        equalTo: 'Confirm password and Password is not same'
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
