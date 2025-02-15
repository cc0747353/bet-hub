<header class='container-fluid container-xxl d-flex align-items-stretch justify-content-between'>
    <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
        <a href="/" class="text-decoration-none horizontal-sidebar-logo d-flex align-items-center pe-xl-8 me-4"
           data-turbo="false">
            <div class="me-3">
                <img src="{{asset(getAppLogo())}}"
                     class="w-70px" alt="profile image">
            </div>
            <span class="text-gray-900 fs-4 d-none d-sm-block">{{getAppName()}}</span>
        </a>
        <button type="button" class="btn px-0 horizontal-menubar d-block d-xl-none text-gray-600">
            <i class="fa-solid fa-bars fs-1"></i>
        </button>
    </div>
    <div class="d-flex align-items-stretch justify-content-xl-between justify-content-end flex-grow-1">
        <nav class="navbar navbar-expand-xl navbar-light horizontal-sidebar d-xl-flex d-block align-items-stretch py-3 py-xl-0"
             id="nav-header">
            @include('layouts.horizontal.sidebar')
        </nav>
        <ul class="nav align-items-stretch flex-nowrap">
            @impersonating
            <li class="px-xxl-3 px-2 d-flex align-items-center">
            <span class="text-primary">
                <a data-turbo="false" data-turbo-eval="false" href="{{ route('user.impersonate.leave') }}" class="">
                    <i class="fas fa-user-check fs-2"></i>
                </a>
            </span>
            </li>
            @endImpersonating
            <li class="px-xxl-3 px-2 d-flex align-items-stretch">
                @if(Auth::user()->theme_mode)
                    <a href="javascript:void(0)" title="Switch to Dark mode" data-bs-toggle="tooltip"
                       class="d-flex align-items-center"><i
                                class="fa-solid fa-moon text-primary fs-2 apply-dark-mode "></i></a>
                @else
                    <a href="javascript:void(0)" title="Switch to Light mode" data-bs-toggle="tooltip"
                       class="d-flex align-items-center"><i
                                class="fa-solid fa-sun text-primary fs-2 apply-dark-mode"></i></a>
                @endif
            </li>
            <li class="px-xxl-3 px-2 d-flex align-items-stretch">
                <div class="dropdown dropdown-transparent d-flex align-items-stretch">
                    <button class="btn dropdown-toggle px-0 text-gray-600 d-flex align-items-center" type="button"
                            id="dropdownMenuButton1"
                            data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                        <div class="image image-circle image-mini d-flex align-items-center me-sm-3">
                            <img src="{{ getLogInUser() ? getLogInUser()->profile_image : asset('images/avatar.png')}}"
                                 class="img-fluid" alt="profile image">
                        </div>
                        {{ getLogInUser()->full_name }}
                        <i class="fa-solid fa-angle-down ms-2"></i>
                    </button>
                    <div class="dropdown-menu py-7 pb-4" aria-labelledby="dropdownMenuButton1">
                        <div class="text-center border-bottom pb-5 ">
                            <div class="image image-circle image-tiny mb-5">
                                <img src="{{ getLogInUser() ? getLogInUser()->profile_image : asset('images/avatar.png')}}"
                                     class="img-fluid" alt="profile image">
                            </div>
                            <h3 class="text-gray-900"> {{ getLogInUser()->full_name }}</h3>
                            <h4 class="mb-0 fw-400 fs-6"> {{ getLogInUser()->email }}</h4>
                        </div>
                        <ul class="pt-4">
                            <li>
                                <a class="dropdown-item text-gray-900" href="{{route('user.profile.setting')}}">
                                <span class="dropdown-icon me-4 text-gray-600">
                                    <i class="fa-solid fa-user"></i>
                                </span>
                                    {{ __('messages.user.edit_profile') }}
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item text-gray-900" href="{{route('user.twofactor.auth')}}">
                                <span class="dropdown-icon me-4 text-gray-600">
                                    <i class="fa-solid fa-user-lock"></i>
                                </span>
                                    {{ __('messages.user.2FA_security') }}
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item text-gray-900" href="javascript:void(0)"
                                   data-bs-toggle="modal"
                                   data-bs-target="#changePasswordModal">
                                <span class="dropdown-icon me-4 text-gray-600">
                                    <i class="fa-solid fa-lock"></i>
                                </span>
                                    {{ __('messages.user.change_password') }}
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item text-gray-900" id="changeLanguage" href="javascript:void(0)">
                               <span class="dropdown-icon me-4 text-gray-600">
                                   <i class="fa-solid fa-globe"></i>
                               </span>
                                    {{ __('messages.user.change_language') }}
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item text-gray-900" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); localStorage.clear();  document.getElementById('logout-form').submit();">
                                <span class="dropdown-icon me-4 text-gray-600">
                                    <i class="fa-solid fa-right-from-bracket"></i>
                                </span>
                                    {{ __('messages.user.logout') }}
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        {{ csrf_field() }}
                                    </form>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</header>
<div class="bg-overlay" id="horizontal-menubar-overly"></div>
