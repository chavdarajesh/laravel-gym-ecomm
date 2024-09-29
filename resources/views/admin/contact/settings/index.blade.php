@extends('admin.layouts.main')
@section('title', 'Contact Settings')
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Contact /</span> Contact Settings</h4>

        <div class="row">
            <div class="col-md-12">

                <div class="card mb-4">
                    <h5 class="card-header">Contact Settings</h5>
                    <!-- Account -->

                    <hr class="my-0" />
                    <div class="card-body">
                        <form id="form" method="POST" action="{{ route('admin.contact.settings.save') }}">
                            @csrf
                            <input type="hidden" name="id" value="{{ $ContactUsSetting ? $ContactUsSetting ['id'] : 1 }}">
                            <div class="row">
                                <div class="mb-3 col-md-12">
                                    <label for="map_iframe" class="form-label">Map IFrame</label>
                                    <textarea rows="5" class="form-control @error('map_iframe') is-invalid @enderror" type="text" id="map_iframe"
                                        name="map_iframe" autofocus>{{ $ContactUsSetting ? $ContactUsSetting ['map_iframe'] : old('map_iframe') }}</textarea>
                                    <div id="map_iframe_error" class="text-danger">
                                        @error('map_iframe')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 col-md-12">
                                    <label for="address_1" class="form-label">Address 1</label>
                                    <textarea class="form-control @error('address_1') is-invalid @enderror" type="text" id="address_1" name="address_1">{{ $ContactUsSetting ? $ContactUsSetting ['address_1'] : old('address_1') }}</textarea>
                                    <div id="location_error" class="text-danger">
                                        @error('address_1')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 col-md-12">
                                    <label for="address_2" class="form-label">Address 2</label>
                                    <textarea class="form-control @error('address_2') is-invalid @enderror" type="text" id="address_2" name="address_2">{{ $ContactUsSetting ? $ContactUsSetting ['address_2'] : old('address_2') }}</textarea>
                                    <div id="location_error" class="text-danger">
                                        @error('address_2')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 col-md-12">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input class="form-control @error('phone') is-invalid @enderror" type="text"
                                        id="phone" name="phone"
                                        value="{{ $ContactUsSetting ? $ContactUsSetting ['phone'] : old('phone') }}" />
                                    <div id="phone_error" class="text-danger">
                                        @error('phone')
                                            {{ $message }}
                                        @enderror
                                    </div>

                                </div>
                                <div class="mb-3 col-md-12">
                                    <label for="email" class="form-label">Email</label>
                                    <input class="form-control @error('email') is-invalid @enderror" type="text"
                                        id="email" name="email"
                                        value="{{ $ContactUsSetting ? $ContactUsSetting ['email'] : old('email') }}" />
                                    <div id="email_error" class="text-danger">
                                        @error('email')
                                            {{ $message }}
                                        @enderror
                                    </div>

                                </div>
                                <div class="mb-3 col-md-12">
                                    <label for="timing" class="form-label">Timing</label>
                                    <textarea rows="5" class="form-control @error('timing') is-invalid @enderror" type="text" id="timing"
                                        name="timing">{{ $ContactUsSetting ? $ContactUsSetting ['timing'] : old('timing') }}</textarea>
                                    <div id="timing_error" class="text-danger">
                                        @error('timing')
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
                    email: {
                        email: true
                    },
                    phone: {
                        minlength: 10,
                    },
                },
                messages: {
                    email: {
                        email: 'Enter a valid email',
                    },
                    phone: {
                        minlength: 'Phone must be at least 10 characters long'
                    },
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
