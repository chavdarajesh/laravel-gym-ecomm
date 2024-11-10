@php
$current_route_name = Route::currentRouteName();
use App\Models\SiteSetting;
$headerLogo = SiteSetting::getSiteSettings('header_logo');
@endphp
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo d-flex justify-content-center align-items-center">
        <a href="{{ route('admin.dashboard') }}" class="app-brand-link">

            <span class="app-brand-text demo menu-text fw-bolder"><img width="60"
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
        <li class="menu-item {{ $current_route_name == 'admin.users.index' ||$current_route_name == 'admin.users.create' ||$current_route_name == 'admin.users.edit' ||$current_route_name == 'admin.users.view' ? 'open active': '' }}">
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
        <li class="menu-item {{ $current_route_name == 'admin.subcategorys.index' ||$current_route_name == 'admin.subcategorys.create' ||$current_route_name == 'admin.subcategorys.edit' ||$current_route_name == 'admin.subcategorys.view' || $current_route_name == 'admin.categorys.index' ||$current_route_name == 'admin.categorys.create' ||$current_route_name == 'admin.categorys.edit' ||$current_route_name == 'admin.categorys.view' || $current_route_name == 'admin.brands.index' ||$current_route_name == 'admin.brands.create' ||$current_route_name == 'admin.brands.edit' ||$current_route_name == 'admin.brands.view' || $current_route_name == 'admin.sizes.index' ||$current_route_name == 'admin.sizes.create' ||$current_route_name == 'admin.sizes.edit' ||$current_route_name == 'admin.sizes.view' || $current_route_name == 'admin.flavors.index' ||$current_route_name == 'admin.flavors.create' ||$current_route_name == 'admin.flavors.edit' ||$current_route_name == 'admin.flavors.view' || $current_route_name == 'admin.products.index' ||$current_route_name == 'admin.products.create' ||$current_route_name == 'admin.products.edit' ||$current_route_name == 'admin.products.view' || $current_route_name == 'admin.productsliders.index' || $current_route_name == 'admin.productsliders.create' || $current_route_name == 'admin.productsliders.edit' || $current_route_name == 'admin.productsliders.view' ? 'open active': '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class='menu-icon tf-icons bx bxl-product-hunt'></i>
                <div data-i18n="Layouts">Product Management</div>
            </a>
            <ul class="menu-sub">
                <li
                    class="menu-item  {{ $current_route_name == 'admin.products.index' || $current_route_name == 'admin.products.create' || $current_route_name == 'admin.products.edit' || $current_route_name == 'admin.products.view'  ? 'active' : '' }}">
                    <a href="{{ route('admin.products.index') }}" class="menu-link">
                        <div>Product</div>
                    </a>
                </li>
                <li
                    class="menu-item  {{ $current_route_name == 'admin.sizes.index' || $current_route_name == 'admin.sizes.create' || $current_route_name == 'admin.sizes.edit' || $current_route_name == 'admin.sizes.view'  ? 'active' : '' }}">
                    <a href="{{ route('admin.sizes.index') }}" class="menu-link">
                        <div>Size</div>
                    </a>
                </li>
                <li
                    class="menu-item  {{ $current_route_name == 'admin.flavors.index' || $current_route_name == 'admin.flavors.create' || $current_route_name == 'admin.flavors.edit' || $current_route_name == 'admin.flavors.view'  ? 'active' : '' }}">
                    <a href="{{ route('admin.flavors.index') }}" class="menu-link">
                        <div>Flavor</div>
                    </a>
                </li>
                <li
                    class="menu-item  {{ $current_route_name == 'admin.brands.index' || $current_route_name == 'admin.brands.create' || $current_route_name == 'admin.brands.edit' || $current_route_name == 'admin.brands.view'  ? 'active' : '' }}">
                    <a href="{{ route('admin.brands.index') }}" class="menu-link">
                        <div>Brand</div>
                    </a>
                </li>
                <li
                    class="menu-item  {{ $current_route_name == 'admin.categorys.index' || $current_route_name == 'admin.categorys.create' || $current_route_name == 'admin.categorys.edit' || $current_route_name == 'admin.categorys.view'  ? 'active' : '' }}">
                    <a href="{{ route('admin.categorys.index') }}" class="menu-link">
                        <div>Category</div>
                    </a>
                </li>
                <li
                    class="menu-item  {{ $current_route_name == 'admin.subcategorys.index' || $current_route_name == 'admin.subcategorys.create' || $current_route_name == 'admin.subcategorys.edit' || $current_route_name == 'admin.subcategorys.view'  ? 'active' : '' }}">
                    <a href="{{ route('admin.subcategorys.index') }}" class="menu-link">
                        <div>Subcategory</div>
                    </a>
                </li>
                <li
                    class="menu-item  {{ $current_route_name == 'admin.productsliders.index' || $current_route_name == 'admin.productsliders.create' || $current_route_name == 'admin.productsliders.edit' || $current_route_name == 'admin.productsliders.view'  ? 'active' : '' }}">
                    <a href="{{ route('admin.productsliders.index') }}" class="menu-link">
                        <div>Product Slider</div>
                    </a>
                </li>

            </ul>
        </li>
        <li class="menu-item  {{ $current_route_name == 'admin.blogs.index' ||$current_route_name == 'admin.blogs.create' ||$current_route_name == 'admin.blogs.edit' ||$current_route_name == 'admin.blogs.view'  ? 'active' : '' }}">
            <a href="{{ route('admin.blogs.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-list-ul"></i>
                <div>Blogs</div>
            </a>
        </li>
        <li class="menu-item {{ $current_route_name == 'admin.contact.messages.index' || $current_route_name == 'admin.contact.settings.index' || $current_route_name == 'admin.contact.messages.view' ? 'open active' : '' }}">
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
        <li class="menu-item {{ $current_route_name == 'admin.newsletters.index' || $current_route_name == 'admin.newsletters.create' || $current_route_name == 'admin.newsletters.edit' || $current_route_name == 'admin.newsletters.view' || $current_route_name == 'admin.newslettermails.index' || $current_route_name == 'admin.newslettermails.create' || $current_route_name == 'admin.newslettermails.edit' || $current_route_name == 'admin.newslettermails.view' ? 'open active' : '' }}">
            <a href="{{ route('admin.newsletters.index') }}" class="menu-link menu-toggle">
                <i class='menu-icon tf-icons bx bxs-envelope'></i>
                <div data-i18n="Layouts">Newsletter Settings</div>
            </a>

            <ul class="menu-sub">
                <li
                    class="menu-item  {{ $current_route_name == 'admin.newsletters.index' || $current_route_name == 'admin.newsletters.create' || $current_route_name == 'admin.newsletters.edit' || $current_route_name == 'admin.newsletters.view' ? 'active' : '' }}">
                    <a href="{{ route('admin.newsletters.index') }}" class="menu-link">
                        <div>Newsletter</div>
                    </a>
                </li>
                <li
                    class="menu-item  {{ $current_route_name == 'admin.newslettermails.index' || $current_route_name == 'admin.newslettermails.create' || $current_route_name == 'admin.newslettermails.edit' || $current_route_name == 'admin.newslettermails.view' ? 'active' : '' }}">
                    <a href="{{ route('admin.newslettermails.index') }}" class="menu-link">
                        <div>Newsletter Mails</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Settings</span>
        </li>

        <li class="menu-item {{ $current_route_name == 'admin.profile.settings.password.index' || $current_route_name == 'admin.profile.setting.index' ? 'open active' : '' }}">
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
