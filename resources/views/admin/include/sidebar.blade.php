@php
$current_route_name = Route::currentRouteName();
use App\Models\SiteSetting;
$headerLogo = SiteSetting::getSiteSettings('header_logo');
@endphp
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo d-flex justify-content-center align-items-center bg-primary">
        <a href="{{ route('admin.dashboard') }}" class="app-brand-link">

            <span class="app-brand-text demo menu-text fw-bolder"><img width="100"
                    src="{{ isset($headerLogo) && isset($headerLogo->value) && $headerLogo != null ? asset($headerLogo->value) : asset('custom-assets/default/admin/images/siteimages/logo/header-logo.png') }}"
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
        <li class="menu-item  {{ $current_route_name == 'admin.dashboard' ? 'active' : '' }}">
            <a href="{{ route('admin.dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div>Dashboard</div>
            </a>
        </li>
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Module</span>
        </li>
        <li class="menu-item {{ $current_route_name == 'admin.users.index' ||$current_route_name == 'admin.users.create' ||$current_route_name == 'admin.users.edit' ||$current_route_name == 'admin.users.view' ||$current_route_name == 'admin.admins.index' ||$current_route_name == 'admin.admins.create' ||$current_route_name == 'admin.admins.edit' ||$current_route_name == 'admin.admins.view' ||$current_route_name == 'admin.admins.referrals' ||$current_route_name == 'admin.employees.index' ||$current_route_name == 'admin.employees.create' ||$current_route_name == 'admin.employees.edit' ||$current_route_name == 'admin.employees.view' ||$current_route_name == 'admin.employees.referrals' ||$current_route_name == 'admin.managers.index' ||$current_route_name == 'admin.managers.create' ||$current_route_name == 'admin.managers.edit' ||$current_route_name == 'admin.managers.view' ||$current_route_name == 'admin.managers.referrals' ||$current_route_name == 'admin.organizations.index' ||$current_route_name == 'admin.organizations.create' ||$current_route_name == 'admin.organizations.edit' ||$current_route_name == 'admin.organizations.view'? 'open active': '' }}"
            >
            <a href="{{ route('admin.users.index') }}" class="menu-link menu-toggle">
                <i class='menu-icon tf-icons bx bxs-user-detail'></i>
                <div data-i18n="Layouts">Users Management</div>
            </a>
            <ul class="menu-sub">
                <li
                    class="menu-item  {{ $current_route_name == 'admin.users.index' || $current_route_name == 'admin.users.create' || $current_route_name == 'admin.users.edit' || $current_route_name == 'admin.users.view' || $current_route_name == 'admin.users.referrals' ? 'active' : '' }}">
                    <a href="{{ route('admin.users.index') }}" class="menu-link">
                        <div>Users</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item {{ $current_route_name == 'admin.contact.messages.index' || $current_route_name == 'admin.contact.settings.index' || $current_route_name == 'admin.contact.messages.view' ? 'open active' : '' }}"
            >
            <a href="{{ route('admin.contact.messages.index') }}" class="menu-link menu-toggle">
                <i class='menu-icon tf-icons bx bxs-contact'></i>
                <div data-i18n="Layouts">Contacts Us Settings</div>
            </a>
            <ul class="menu-sub">
                <li
                    class="menu-item {{ $current_route_name == 'admin.contact.messages.index' || $current_route_name == 'admin.contact.messages.view' ? 'active' : '' }}">
                    <a href="{{ route('admin.contact.messages.index') }}" class="menu-link">
                        <div data-i18n="Without menu">Contact Messages</div>
                    </a>
                </li>
                <li class="menu-item {{ $current_route_name == 'admin.contact.settings.index' ? 'active' : '' }}">
                    <a href="{{ route('admin.contact.settings.index') }}" class="menu-link">
                        <div data-i18n="Without menu">Contact Settings</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Settings</span>
        </li>

        <li class="menu-item {{ $current_route_name == 'admin.profile.settings.password.index' || $current_route_name == 'admin.profile.setting.index' ? 'open active' : '' }}"
            >
            <a href="{{ route('admin.profile.settings.password.index') }}" class="menu-link menu-toggle">
                <i class='menu-icon tf-icons bx bxs-user-account'></i>
                <div data-i18n="Layouts">Account Settings</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item {{ $current_route_name == 'admin.profile.setting.index' ? 'active' : '' }}">
                    <a href="{{ route('admin.profile.setting.index') }}" class="menu-link">
                        <div data-i18n="Without menu">Profile Setting</div>
                    </a>
                </li>

                <li
                    class="menu-item {{ $current_route_name == 'admin.profile.settings.password.index' ? 'active' : '' }}">
                    <a href="{{ route('admin.profile.settings.password.index') }}" class="menu-link ">
                        <div data-i18n="Without menu">Password Setiing</div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-item  {{ $current_route_name == 'admin.site.settings.index' ? 'active' : '' }}">
            <a href="{{ route('admin.site.settings.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-cog"></i>
                <div>Site Settings</div>
            </a>
        </li>
    </ul>
</aside>
