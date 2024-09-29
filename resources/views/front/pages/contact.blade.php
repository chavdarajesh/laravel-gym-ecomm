@extends('front.layouts.main')
@section('title', 'Contact')
@section('css')

@stop
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@24.5.0/build/css/intlTelInput.css">

<!-- <link rel="stylesheet" href="{{ asset('assets/front/css/intlTelInput.css') }}"> -->

<style>
    .map-responsive iframe {
        width: 100%;
        height: 100%;
    }

    .focus-none:focus {
        box-shadow: none !important;
        outline: none !important;
    }

    .iti.iti--allow-dropdown.iti--show-flags.iti--inline-dropdown {
        width: 100%;
        float: left;
        font-size: 16px;
        color: #727272;
        border: 0px;
        background-color: #ffff;
        /* padding: 15px; */
        margin-top: 20px;
        font-family: 'Roboto', sans-serif;
    }
</style>
@section('content')

<!-- contact section start -->
<div class="contact_section layout_padding margin_top90">
    <div class="container">
        <h1 class="contact_taital">Get In Touch</h1>
        <p class="contact_text">If You Have Any Query, Please Contact Us</p>
        <div class="contact_section_2 layout_padding">
            <div class="row">
                <div class="col-md-6">
                    <form id="form" action="{{ route('front.contact.message.save') }}" method="POST">
                        @csrf
                        <input type="text" class="mail_text @error('name') border border-danger @enderror " placeholder="Full Name" id="name" value="{{ old('name') }}" name="name">
                        <div id="name_error" class="text-danger"> @error('name')
                            {{ $message }}
                            @enderror
                        </div>
                        <input type="text" class="mail_text @error('company_name') border border-danger @enderror " placeholder="Company Name" id="company_name" value="{{ old('company_name') }}" name="company_name">
                        <div id="company_name_error" class="text-danger"> @error('company_name')
                            {{ $message }}
                            @enderror
                        </div>
                        <input type="text" class="mail_text @error('phone') border border-danger @enderror " placeholder="Phone" id="phone" value="{{ old('phone') }}" name="phone">
                        <div id="c_code_error" class="text-danger"> @error('email')
                            {{ $message }}
                            @enderror
                        </div>
                        <div id="phone_error" class="text-danger"> @error('phone')
                            {{ $message }}
                            @enderror
                        </div>
                        <input type="text" class="mail_text @error('email') border border-danger @enderror" placeholder="Email" id="email" name="email" value="{{ old('email') }}">
                        <div id="email_error" class="text-danger"> @error('email')
                            {{ $message }}
                            @enderror
                        </div>

                        <input type="text" class="mail_text @error('address') border border-danger @enderror " placeholder="Address" id="address" value="{{ old('address') }}" name="address">
                        <div id="address_error" class="text-danger"> @error('address')
                            {{ $message }}
                            @enderror
                        </div>
                        <textarea class="massage-bt @error('message') border border-danger @enderror " placeholder="Massage" rows="5" id="message" name="message">{{ old('message') }}</textarea>
                        <div id="message_error" class="text-danger"> @error('message')
                            {{ $message }}
                            @enderror
                        </div>
                        <div class="send_bt"><button type="submit">SEND</button></div>
                    </form>
                </div>
                @if ($ContactUsSetting)
                <div class="col-md-6">
                    <div class="map_main w-100 h-100">
                        <div class="map-responsive w-100 h-100">
                            {!! $ContactUsSetting['map_iframe'] !!}
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
<!-- contact section end -->
@stop
@section('js')
<script src="{{ asset('assets/front/js/intlTelInput.min.js') }}"></script>
<script>
    const input = document.querySelector("#phone");
    var iti = window.intlTelInput(input, {
        utilsScript: "{{ asset('assets/front/js/utils.js') }}",
        hiddenInput: function(telInputName) {
            return {
                phone: "phone_full",
                country: "c_code"
            };
        }
    });
    input.addEventListener("countrychange", function() {
        if (iti.getSelectedCountryData() && iti.isValidNumber()) {
            $('#c_code_error').html('');
        }
    });
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
                c_code: {
                    required: true,
                },
                phone: {
                    required: true,
                    number: true
                },
                address: {
                    required: true,
                },
                company_name: {
                    required: true,
                },
                message: {
                    required: true,
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
                    number: 'Please enter a valid phone number.',
                },
                address: {
                    required: 'This field is required',
                },
                message: {
                    required: 'This field is required',
                },
                company_name: {
                    required: 'This field is required',
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
                if (iti.isValidNumber()) {
                    form.submit();
                } else {
                    $('#c_code_error').html('Please select a contry code or enter a valid phone number.');
                }
            }
        });
    });
</script>
@stop
