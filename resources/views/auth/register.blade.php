@extends('front.layout.app')
@section('title')
    {{__('messages.registration')}}
@endsection
@section('content')
    @php
        $settings = App\Models\Setting::pluck('value','key')->toArray();
    @endphp
    <div class="contact-page bg-dark">
        <section class="contact-section">
            <div class="container">
                <div class="section-heading pt-60 pb-60 border-bottom">
                    <div class="row justify-content-center">
                        <div class="col-12 text-center">
                            <h2 class="text-primary mb-0">{{__('messages.registration')}}</h2>
                        </div>
                    </div>
                </div>
                <div class="get-in-touch pt-40 pb-120">
                    <div class="row justify-content-center">
                        <div class="col-lg-6">
                            @include('flash::message')
                            @include('layouts.errors')
                            <form method="POST" action="{{ route('register') }}" >
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group mb-40">
                                            <label for="first_name" class="text-white fs-20 mb-20">{{ __('messages.user.first_name').':' }}
                                                <span class="required"></span>
                                            </label>
                                            <input name="first_name" type="text" class="form-control" id="first_name" aria-describedby="name" placeholder="{{ __('messages.user.first_name') }}" value="{{ old('first_name') }}" required>
                                        </div>
                                       
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group mb-40">
                                            <label for="last_name" class="text-white fs-20 mb-20">{{ __('messages.user.last_name').':' }}<span class="required"></span></label>
                                            <input name="last_name" type="text" class="form-control" id="last_name" aria-describedby="name" placeholder="{{ __('messages.user.last_name') }}" value="{{ old('last_name') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group mb-40">
                                            <label for="email" class="text-white fs-20 mb-20"> {{ __('messages.user.email').':' }}<span class="required"></span></label>
                                            <input name="email" type="email" class="form-control" id="email" aria-describedby="email" placeholder="{{ __('messages.user.email') }}" value="{{ old('email') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group mb-40">
                                            <label for="user_name" class="text-white fs-20 mb-20"> {{ __('messages.user.user_name').':' }}<span class="required"></span></label>
                                            <input name="user_name" type="text" class="form-control" aria-describedby="user_name" placeholder="{{ __('messages.user.user_name') }}" value="{{ old('email') }}" required id="user_name">
                                            <input type="hidden" name="referral_by"  value="{{  isset($userName) ? $userName : null }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group mb-40">
                                            <label for="password" class="text-white fs-20 mb-20"> {{ __('messages.user.password').':' }}<span class="required"></span></label>
                                            <input type="password" name="password" class="form-control" id="password" placeholder="{{ __('messages.user.password') }}" aria-describedby="password" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group mb-40">
                                            <label for="password_confirmation" class="text-white fs-20 mb-20"> {{ __('messages.user.password_confirmation').':' }}<span class="required"></span></label>
                                            <input name="password_confirmation" type="password" class="form-control" placeholder="{{ __('messages.user.password_confirmation') }}" id="password_confirmation" aria-describedby="confirmPassword" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-sm-7 mb-4 form-check">
                                            <input type="checkbox" class="form-check-input" name="toc" value="1" required/>
                                            <span class="text-white me-2 ml-1">{{__('messages.by_signing')}}
									        <a href="{{ route('terms-of-service') }}" class="ms-1 link-info text-decoration-underline" target="_blank">{{__('messages.terms_and_conditions') }}</a>
                                            .</span>
                                        </div>
                                    </div>
                                    @if($settings['show_captcha'] == "1")
                                        <input type="hidden" value="{{ $settings['show_captcha'] }}" id="googleCaptch">
                                        <div class="form-group mb-1">
                                            <div class="g-recaptcha" id="gRecaptchaContainer"
                                                 data-sitekey="{{ $settings['site_key'] }}"></div>
                                            <div id="g-recaptcha-error"></div>
                                        </div>
                                    @endif
                                    <div class="col-12 text-center">
                                        <div class="d-grid gap-2">
                                            <button type="submit" class="btn btn-primary btn-block" id="contactUsFormSaveBtn">Submit</button>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center mt-4">
                                        <span class="text-white me-2">{{__('messages.already_have_an_account').'?'}}</span>
                                        <a href="{{ route('login') }}" class="link-info fs-6 text-decoration-none" data-turbo="false">
                                            {{__('messages.sign_in_here')}}
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
