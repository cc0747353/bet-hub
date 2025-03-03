@extends('layouts.auth')
@section('title')
    {{__('messages.login')}}
@endsection
@section('content')
    @php
        $settings = App\Models\Setting::pluck('value','key')->toArray();
    @endphp
    <div class="d-flex flex-column flex-column-fluid align-items-center justify-content-center p-4">
        <div class="col-12 text-center">
            <a href="{{ route('home') }}" class="image mb-7 mb-sm-10">
                <img alt="Logo" src="{{asset(getAppLogo())}}" class="img-fluid loginImg">
            </a>
        </div>
        <div class="width-540">
            @include('flash::message')
            @include('layouts.errors')
        </div>
        <div class="bg-white rounded-15 shadow-md width-540 px-5 px-sm-7 py-10 mx-auto">
            <h1 class="text-center mb-7">{{__('auth.sign_in')}}</h1>
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-sm-7 mb-4">
                    <label for="email" class="form-label">
                        {{ __('messages.user.email').':' }}<span class="required"></span>
                    </label>
                    <input name="email" type="email" class="form-control" id="email" aria-describedby="emailHelp" required placeholder="Enter Email">
                </div>

                <div class="mb-sm-7 mb-4">
                    <div class="d-flex justify-content-between">
                        <label for="password" class="form-label">{{ __('messages.user.password') .':' }}<span
                                    class="required"></span></label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="link-info fs-6 text-decoration-none">
                                {{ __('messages.common.forgot_your_password').'?' }}
                            </a>
                        @endif
                    </div>
                    <input name="password" type="password" class="form-control" id="password" required placeholder="Enter Password">
                </div>
                <div class="mb-sm-7 mb-4 form-check">
                    <input type="checkbox" class="form-check-input" id="remember_me">
                    <label class="form-check-label" for="remember_me">{{ __('messages.common.remember_me') }}</label>
                </div>
                @if($settings['show_captcha'] == "1")
                    <input type="hidden" value="{{ $settings['show_captcha'] }}" id="googleCaptch">
                    <div class="form-group mb-1">
                        <div class="g-recaptcha" id="gRecaptchaContainer"
                             data-sitekey="{{ $settings['site_key'] }}"></div>
                        <div id="g-recaptcha-error"></div>
                    </div>
                @endif
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">{{ __('messages.login') }}</button>
                </div>

                <div class="d-flex align-items-center mb-10 mt-4">
                    <span class="text-gray-700 me-2">{{__('messages.new_here').'?'}}</span>
                    <a href="{{ route('register') }}" class="link-info fs-6 text-decoration-none" data-turbo="false">
                        {{__('messages.create_an_account')}}
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
