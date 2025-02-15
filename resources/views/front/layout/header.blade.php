<header class="header" id="myHeader">
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <div class="col-lg-4 col-5">
                <div class="header-logo">
                    <a href="/"> <img src="{{ $settings['logo'] }}" alt="InfyBetting" class="web-logo" /> </a>
                </div>
            </div>
            <div class="col-lg-8 col-sm-1 col-2">
                <nav class="navbar navbar-expand-lg navbar-light justify-content-end">
                    <button class="navbar-toggler border-0 p-0" type="button" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" id="navBarBtn">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-lg-between justify-content-end" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link px-3 {{ Request::is('/') ? 'active' : '' }}" aria-current="page" href="/" >{{ __('messages.front.home') }}</a>
                            </li>
                            <li class="nav-item px-3">
                                <a class="nav-link {{ Request::is('blogs') || Request::is('blog-details*') ? 'active' : '' }}" href="{{ route('blogs') }}">{{ __('messages.front.blog') }}</a>
                            </li>
                            <li class="nav-item px-3">
                                <a class="nav-link {{ Request::is('about-us') ? 'active' : '' }}" href="{{ route('about-us') }}">{{ __('messages.front.about') }}</a>
                            </li>
                            <li class="nav-item px-3">
                                <a class="nav-link {{ Request::is('affiliate') ? 'active' : '' }}" href="{{ route('affiliate') }}">{{ __('messages.front.affiliate') }}</a>
                            </li>
                            <li class="nav-item px-3">
                                <a class="nav-link {{ Request::is('contact-us') ? 'active' : '' }}" href="{{ route('contact-us') }}">{{ __('messages.front.contact') }}</a>
                            </li>
                        </ul>
                        @if(getLogInUser())
                            <div class="d-flex px-lg-0 px-4 pb-lg-0 pb-4">
                                <a href="{{ getLogInUser()->hasRole('admin') || getLogInUser()->hasRole('superAdmin') ? route('admin.dashboard') : route('user.dashboard') }}" type="button" class="btn btn-transparent me-4" data-turbo="false"> {{ __('messages.front.dashboard') }}</a>
                            </div>
                        @else
                            <div class="d-flex px-lg-0 px-4 pb-lg-0 pb-4">
                                <a href="{{ route('register') }}" type="button" class="btn btn-transparent me-4" data-turbo="false"> {{ __('messages.front.register') }}</a>
                                <a href="{{ route('login') }}" type="button" class="btn btn-primary" data-turbo="false">{{ __('messages.front.login') }}</a>
                            </div>
                        @endif
                    </div>
                </nav>
            </div>
        </div>
    </div>
</header>
