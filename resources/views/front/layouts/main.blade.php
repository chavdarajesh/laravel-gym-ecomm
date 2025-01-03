@php
use App\Models\SiteSetting;
$favicon = SiteSetting::getSiteSettings('favicon');
$current_route_name=Route::currentRouteName();


// Routes that do not require the 'black-bg' class
$excludedRoutes = [
    'front.contact',
    'front.blogs',
    'front.blog.details',
    'front.blog.search',
    'front.products',
    'front.products-sidebar',
    'front.products-category',
    'front.products-brand',
    'front.products-sub-category',
    'front.products-top-selling',
    'front.products-search',
    'front.products-details',
    'front.products-cart',
    'front.products-checkout',
    'front.products-completed',
    'front.login',
    'front.otp_verification.get',
    'front.forgotpassword',
    'front.reset.password.get',
    'front.profilepage',
    'front.orders',
    'front.orders-details',
];
@endphp

<!DOCTYPE html>
<html lang="en" class="no-js" lang="zxx">

<head>
      <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <!-- site metas -->
        <!-- site metas -->
        {{-- <meta name="keywords" content=""> --}}
        {{-- <meta name="author" content=""> --}}
        <title>{{ env('APP_NAME', 'Laravel App') }} | @yield('title')</title>
    <!-- favicons Icons -->
    <link rel="apple-touch-icon" sizes="180x180"
        href="{{ isset($favicon) && isset($favicon->value) && $favicon != null && $favicon->value != '' ? asset($favicon->value) : asset('custom-assets/default/admin/images/siteimages/logo/favicon.png') }}" />
    <link rel="icon" type="image/png" sizes="32x32"
        href="{{ isset($favicon) && isset($favicon->value) && $favicon != null && $favicon->value != '' ? asset($favicon->value) : asset('custom-assets/default/admin/images/siteimages/logo/favicon.png') }}" />
    <link rel="icon" type="image/png" sizes="16x16"
        href="{{ isset($favicon) && isset($favicon->value) && $favicon != null && $favicon->value != '' ? asset($favicon->value) : asset('custom-assets/default/admin/images/siteimages/logo/favicon.png') }}" />
    <meta name="description" content="@yield('description')" />

    @include('front.layouts.head')
</head>

<body class="{{ !in_array($current_route_name, $excludedRoutes) ? 'black-bg' : '' }}">
    @include('front.include.header')
    <main>
    @yield('content')
    </main>

    @include('front.include.footer')

    @include('front.layouts.footer')

</body>

</html>
