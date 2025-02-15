<!doctype html>
@php
    $settings = App\Models\Setting::pluck('value','key')->toArray();
@endphp
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') |  {{getAppName()}}</title>
    <link rel="icon" href="{{ $settings['favicon'] }}" type="image/png">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/all.css')}}"/>
    <link href="{{ mix('assets/css/third-party.css') }}" rel="stylesheet">
    <link href="{{ mix('assets/css/pages.css') }}" rel="stylesheet">

    @if(Auth::user()->theme_mode)
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/plugins.css') }}">
    @else
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style-dark.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/plugins.dark.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ mix('assets/css/custom-pages-dark.css') }}">
    @endif

    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/laravel-admin-ext/code-mirror/codemirror.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/laravel-admin-ext/code-mirror/dracula.css') }}">
    <script src="{{ asset('vendor/laravel-admin-ext/code-mirror/codemirror.js') }}"></script>
    <script src="{{ asset('vendor/laravel-admin-ext/code-mirror/css.js') }}"></script>
    <script src="{{ asset('vendor/laravel-admin-ext/code-mirror/closebrackets.js') }}"></script>

    <script src="https://js.stripe.com/v3/"></script>

    <script src="{{ asset('assets/js/custom/helper.js') }}"></script>
    @livewireStyles
    @routes
    <script src="{{ asset('vendor/livewire/livewire.js') }}"></script>
    @include('livewire.livewire-turbo')
    <script src="{{ asset('assets/js/livewire-turbolinks.js') }}"
            data-turbolinks-eval="false" data-turbo-eval="false"></script>
    <script>
        let stripe = ''
        @if (config('services.stripe.key'))
            stripe = Stripe('{{ config('services.stripe.key') }}')
        @endif
        let sweetAlertIcon = "{{ asset('images/remove.png') }}"
        let defaultImage = "{{asset('images/avatar.png')}}"
        let defaultCountryCodeValue = "IN";
        let levelMessages = "{{ __('messages.referral.level') }}";
        let commissionMessages = "{{ __('messages.referral.commission') }}";
        let currentLoginUserId = "{{ getLogInUserId()}}";
    </script>

    <script src="{{ asset('js/vendor.js') }}"></script>
    <script src="{{ mix('js/third-party.js') }}"></script>
    <script src="{{ asset('messages.js') }}"></script>
    <script src="{{ asset('js/plugins.js') }}"></script>
    <script src="{{ mix('js/pages.js') }}"></script> @yield('page_js')
    <script data-turbo-eval="false">
        let updateLanguageURL = "{{ route('change-language')}}";
        let checkLanguageSession = '{{checkLanguageSession()}}';
        Lang.setLocale(checkLanguageSession);
    </script>
    @php $textCss = 'style' @endphp
</head>
<body>
<div class="d-flex flex-column flex-root">
    <div class="d-flex flex-row flex-column-fluid">
        @include('layouts.sidebar')
        <div class="wrapper d-flex flex-column flex-row-fluid">
            <div class='container-fluid d-flex align-items-stretch justify-content-between px-0'>
                @include('layouts.header')
            </div>
            <div class='content d-flex flex-column flex-column-fluid pt-7'>

                @yield('header_toolbar')
                <div class='d-flex flex-column-fluid'>
                    @yield('content')
                </div>
            </div>
            <div class='container-fluid'> @include('layouts.footer') </div>
        </div>
    </div>
    {{Form::hidden('currentLanguage',checkLanguageSession(),['class'=>'currentLanguage'])}}
</div>
@include('profile.changePassword')
@include('profile.change_language')
</body>
</html>
