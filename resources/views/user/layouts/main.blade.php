@php
     use App\Models\SiteSetting;
    $favicon = SiteSetting::getSiteSettings('favicon');
@endphp

<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default"
    data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <!-- Favicon -->
    <title>{{ env('APP_NAME', 'Laravel App') }} User | @yield('title')</title>
    <link rel="apple-touch-icon" sizes="180x180" href="{{ isset($favicon) && isset($favicon->value) && $favicon != null && $favicon->value != '' ? asset($favicon->value) : asset('custom-assets/default/user/images/siteimages/logo/favicon.png') }}" />
    <link rel="icon" type="image/png" sizes="32x32"
        href="{{ isset($favicon) && isset($favicon->value) && $favicon != null && $favicon->value != '' ? asset($favicon->value) : asset('custom-assets/default/user/images/siteimages/logo/favicon.png') }}" />
    <link rel="icon" type="image/png" sizes="16x16"
        href="{{ isset($favicon) && isset($favicon->value) && $favicon != null && $favicon->value != '' ? asset($favicon->value) : asset('custom-assets/default/user/images/siteimages/logo/favicon.png') }}" />
    {{-- <link rel="manifest" href="{{ asset('assets/front/images/favicons/site.webmanifest') }}" /> --}}
    <meta name="description" content="@yield('description')" />
    @include('user.layouts.head')

</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

            @include('user.include.sidebar')
            <div class="layout-page">
                @include('user.include.header')
                <div class="content-wrapper">
                    @yield('content')
                </div>
                @include('user.include.footer')
            </div>
            @include('user.layouts.footer')


</body>

</html>
