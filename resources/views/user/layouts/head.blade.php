{{-- <link rel="icon" type="image/x-icon" href="{{ asset('assets/user/img/favicon/favicon.png') }}" /> --}}

<!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link
    href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
    rel="stylesheet" />

<!-- Icons. Uncomment required icon fonts -->
<link rel="stylesheet" href="{{ asset('assets/user/vendor/fonts/boxicons.css') }}" />

<!-- Core CSS -->
<link rel="stylesheet" href="{{ asset('assets/user/vendor/css/core.css') }}" class="template-customizer-core-cssZ" />
<link rel="stylesheet" href="{{ asset('assets/user/vendor/css/theme-default.css') }}"
    class="template-customizer-theme-css" />
<link rel="stylesheet" href="{{ asset('assets/user/css/demo.css') }}" />

<!-- Vendors CSS -->
<link rel="stylesheet" href="{{ asset('assets/user/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

<link rel="stylesheet" href="{{ asset('assets/user/vendor/libs/apex-charts/apex-charts.css') }}" />

<!-- Page CSS -->

<!-- Helpers -->
<script src="{{ asset('assets/user/vendor/js/helpers.js') }}"></script>

<!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
<!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
<script src="{{ asset('assets/user/js/config.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('custom-assets/default/user/css/toastr.min.css') }}">

@yield('css')

<style>
    /* 20. preloader */
    /* line 577, C:/Users/HP/Desktop/July-HTML/292 Health coach/assets/scss/_common.scss */
    .preloader {
        background-color: #f7f7f7;
        width: 100%;
        height: 100%;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 999999;
        -webkit-transition: .6s;
        -o-transition: .6s;
        transition: .6s;
        margin: 0 auto;
    }

    /* line 593, C:/Users/HP/Desktop/July-HTML/292 Health coach/assets/scss/_common.scss */
    .preloader .preloader-circle {
        width: 100px;
        height: 100px;
        position: relative;
        border-style: solid;
        border-width: 1px;
        border-top-color: #ffcc29;
        border-bottom-color: transparent;
        border-left-color: transparent;
        border-right-color: transparent;
        z-index: 10;
        border-radius: 50%;
        -webkit-box-shadow: 0 1px 5px 0 rgba(35, 181, 185, 0.15);
        box-shadow: 0 1px 5px 0 rgba(35, 181, 185, 0.15);
        background-color: #fff;
        -webkit-animation: zoom 2000ms infinite ease;
        animation: zoom 2000ms infinite ease;
        -webkit-transition: .6s;
        -o-transition: .6s;
        transition: .6s;
    }

    /* line 615, C:/Users/HP/Desktop/July-HTML/292 Health coach/assets/scss/_common.scss */
    .preloader .preloader-circle2 {
        border-top-color: #0078ff;
    }

    /* line 618, C:/Users/HP/Desktop/July-HTML/292 Health coach/assets/scss/_common.scss */
    .preloader .preloader-img {
        position: absolute;
        top: 50%;
        z-index: 200;
        left: 0;
        right: 0;
        margin: 0 auto;
        text-align: center;
        display: inline-block;
        -webkit-transform: translateY(-50%);
        -ms-transform: translateY(-50%);
        transform: translateY(-50%);
        padding-top: 6px;
        -webkit-transition: .6s;
        -o-transition: .6s;
        transition: .6s;
    }

    /* line 636, C:/Users/HP/Desktop/July-HTML/292 Health coach/assets/scss/_common.scss */
    .preloader .preloader-img img {
        max-width: 55px;
    }

    /* line 639, C:/Users/HP/Desktop/July-HTML/292 Health coach/assets/scss/_common.scss */
    .preloader .pere-text strong {
        font-weight: 800;
        color: #dca73a;
        text-transform: uppercase;
    }

    @-webkit-keyframes zoom {
        0% {
            -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
            -webkit-transition: .6s;
            -o-transition: .6s;
            transition: .6s;
        }

        100% {
            -webkit-transform: rotate(360deg);
            transform: rotate(360deg);
            -webkit-transition: .6s;
            -o-transition: .6s;
            transition: .6s;
        }
    }

    @keyframes zoom {
        0% {
            -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
            -webkit-transition: .6s;
            -o-transition: .6s;
            transition: .6s;
        }

        100% {
            -webkit-transform: rotate(360deg);
            transform: rotate(360deg);
            -webkit-transition: .6s;
            -o-transition: .6s;
            transition: .6s;
        }
    }
</style>
