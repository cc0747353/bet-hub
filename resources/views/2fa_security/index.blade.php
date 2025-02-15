@extends('layouts.horizontal.app')
@section('title')
    {{ __('messages.security.two_factor') }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-end mb-5">
            <h1>{{ __('messages.security.two_factor') }}</h1>
        </div>
        <div class="col-12">
            @include('layouts.errors')
            @include('flash::message')
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="card custom-2fa-card h-100">
                            <div class="card-header">
                                <h5 class="card-title py-2 text-white">{{ __('messages.security.two_factor') }}</h5>
                            </div>
                            <div class="card-body">
                                <div class="twofactor-content">
                                    @if($secret)
                                    <div class="input-group">
                                        <input type="text" name="key" value="{{ $secret }}"
                                               class="form-control" id="2faSecretKey" 
                                               readonly="">
                                        <span class="input-group-text bg--base form--control h--50px cursor-pointer copy-secret-text"
                                              id="copySecretBoard">
                                                <i class="lar la-copy"></i>
                                            </span>
                                    </div>
                                    <div class="twofactor-scan text-center my-4">
                                        <img src="{{ $imageRender }}" alt="QR Code" id="2faSecretKeyImage" class="qr-image-height"/>
                                    </div>
                                    @endif
                                    <div class="text-center">
                                        @if($user->google2fa_secret == null)
                                        <a href="javascript:void(0)" class="twoauth-enable btn btn-success"
                                           >{{ __('messages.security.enable_two_factor') }}</a>
                                        @else
                                        <a href="javascript:void(0)" class="twoauth-disable btn btn-danger"
                                        >{{ __('messages.security.disable_two_factor') }}</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card custom-2fa-card h-100">
                            <div class="card-header">
                                <h5 class="card-title py-2 text-white">{{ __('messages.security.google_authenticator') }}</h5>
                            </div>
                            <div class="card-body">
                                <div class="two-factor-content">
                                    <h6 class="subtitle--bordered">{{ __('messages.security.use_google_authenticator') }}</h6>
                                    <p class="two__fact__text">{{ __('messages.security.google_authenticator_is_a') }}</p>
                                    <a href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&amp;hl=en"
                                       target="_blank" class="btn btn-success">{{ __('messages.security.download_app') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('2fa_security.disable2fa_modal')
@endsection

