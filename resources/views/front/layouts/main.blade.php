@php
use App\Models\SiteSetting;
$favicon = SiteSetting::getSiteSettings('favicon');
$current_route_name=Route::currentRouteName();
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

<body class="{{ Route::currentRouteName() != 'front.contact' && Route::currentRouteName() != 'front.blogs' && Route::currentRouteName() != 'front.blog.details' && Route::currentRouteName() != 'front.blog.search' && Route::currentRouteName() != 'front.products'? 'black-bg' : '' }}">
    @include('front.include.header')
    <main>
    @yield('content')
    </main>

    @include('front.include.footer')

    @include('front.layouts.footer')

</body>

</html>
