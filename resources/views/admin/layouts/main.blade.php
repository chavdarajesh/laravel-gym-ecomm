@php
     use App\Models\SiteSetting;
    $favicon = SiteSetting::getSiteSettings('favicon');
    $loader = SiteSetting::getSiteSettings('loader');
@endphp

<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default"
    data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <!-- Favicon -->
    <title>{{ env('APP_NAME', 'Laravel App') }} Admin | @yield('title')</title>
    <link rel="apple-touch-icon" sizes="180x180" href="{{ isset($favicon) && isset($favicon->value) && $favicon != null && $favicon->value != '' ? asset($favicon->value) : asset('custom-assets/default/admin/images/siteimages/logo/favicon.png') }}" />
    <link rel="icon" type="image/png" sizes="32x32"
        href="{{ isset($favicon) && isset($favicon->value) && $favicon != null && $favicon->value != '' ? asset($favicon->value) : asset('custom-assets/default/admin/images/siteimages/logo/favicon.png') }}" />
    <link rel="icon" type="image/png" sizes="16x16"
        href="{{ isset($favicon) && isset($favicon->value) && $favicon != null && $favicon->value != '' ? asset($favicon->value) : asset('custom-assets/default/admin/images/siteimages/logo/favicon.png') }}" />
    {{-- <link rel="manifest" href="{{ asset('assets/front/images/favicons/site.webmanifest') }}" /> --}}
    <meta name="description" content="@yield('description')" />
    @include('admin.layouts.head')

</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

            @include('admin.include.sidebar')
            <div class="layout-page">
                @include('admin.include.header')
                <div class="content-wrapper">
                    @yield('content')
                </div>
                @include('admin.include.footer')
            </div>
            @include('admin.layouts.footer')


</body>

</html>
