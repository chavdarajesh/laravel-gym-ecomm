@php
$current_route_name = Route::currentRouteName();
use App\Models\SiteSetting;
$headerLogo = SiteSetting::getSiteSettings('header_logo');
@endphp
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo d-flex justify-content-center align-items-center bg-primary">
        <a href="{{ route('user.dashboard') }}" class="app-brand-link">

            <span class="app-brand-text demo menu-text fw-bolder"><img width="100"
                    src="{{ isset($headerLogo) && isset($headerLogo->value) && $headerLogo != null ? asset($headerLogo->value) : asset('custom-assets/default/user/images/siteimages/logo/header-logo.png') }}"
                    alt="Header Logo"></span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>
    <div class="">
        <hr>
    </div>
    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item  {{ $current_route_name == 'user.dashboard' ? 'active' : '' }}">
            <a href="{{ route('user.dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div>Dashboard</div>
            </a>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Settings</span>
        </li>

        <li class="menu-item {{ $current_route_name == 'user.profile.settings.password.index' || $current_route_name == 'user.profile.setting.index' ? 'open active' : '' }}"
            >
            <a href="{{ route('user.profile.settings.password.index') }}" class="menu-link menu-toggle">
                <i class='menu-icon tf-icons bx bxs-user-account'></i>
                <div data-i18n="Layouts">Account Settings</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item {{ $current_route_name == 'user.profile.setting.index' ? 'active' : '' }}">
                    <a href="{{ route('user.profile.setting.index') }}" class="menu-link">
                        <div data-i18n="Without menu">Profile Setting</div>
                    </a>
                </li>

                <li
                    class="menu-item {{ $current_route_name == 'user.profile.settings.password.index' ? 'active' : '' }}">
                    <a href="{{ route('user.profile.settings.password.index') }}" class="menu-link ">
                        <div data-i18n="Without menu">Password Setiing</div>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</aside>
