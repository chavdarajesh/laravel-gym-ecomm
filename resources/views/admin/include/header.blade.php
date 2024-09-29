
@php $current_route_name=Route::currentRouteName();
use App\Models\SiteSetting;
$loader = SiteSetting::getSiteSettings('loader');
@endphp

@if(isset($loader))
<div id="preloader-active">
    <div class="preloader d-flex align-items-center justify-content-center">
        <div class="preloader-inner position-relative">
            <div class="preloader-circle"></div>
            <div class="preloader-img pere-text">
                <img src="{{ isset($loader) && isset($loader->value) && $loader != null ? asset($loader->value) : asset('custom-assets/default/admin/images/siteimages/logo/loder.png') }}" alt="">
            </div>
        </div>
    </div>
</div>
@endif

<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
    id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="bx bx-menu bx-sm"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <!-- Search -->
        <!-- <div class="navbar-nav align-items-center">
            <div class="nav-item d-flex align-items-center">
                <i class="bx bx-search fs-4 lh-0"></i>
                <input type="text" class="form-control border-0 shadow-none" placeholder="Search..."
                    aria-label="Search..." />
            </div>
        </div> -->
        <!-- /Search -->

        <ul class="navbar-nav flex-row align-items-center ms-auto">
            <!-- Place this tag where you want the button to render. -->


            <!-- User -->
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                        <img src="{{ Auth::user()->image ? asset(Auth::user()->image) : asset('assets/admin/img/avatars/1.png') }}"
                            alt class="w-px-40  rounded-circle" />
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="#">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar avatar-online">
                                        <img src="{{ Auth::user()->image ? asset(Auth::user()->image) : asset('assets/admin/img/avatars/1.png') }}"
                                            class="w-px-40  rounded-circle" />
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <span class="fw-semibold d-block">{{ Auth::user()->name }}</span>
                                </div>
                            </div>
                        </a>
                    </li>
                        <li>
                            <div class="dropdown-divider"></div>
                        </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('admin.profile.setting.index') }}">
                                    <i class="bx bx-user me-2"></i>
                                    <span class="align-middle">Profile Setting</span>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('admin.profile.settings.password.index') }}">
                                    <i class="bx bx-cog me-2"></i>
                                    <span class="align-middle">Password Settings</span>
                                </a>
                            </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <a target="_blank" class="dropdown-item" href="{{ route('front.home') }}">
                            <i class='bx bx-desktop  me-2'></i>
                            <span class="align-middle">Front Panel</span>
                        </a>
                    </li>

                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <form action="{{ route('admin.logout') }}" method="POST">
                            @csrf
                            <button class="dropdown-item" type="submit">
                                <i class="bx bx-power-off me-2"></i>
                                <span class="align-middle">Log Out</span>
                            </button>
                        </form>
                    </li>
                </ul>
            </li>
            <!--/ User -->
        </ul>
    </div>
</nav>
