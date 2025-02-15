<!DOCTYPE html>
@php
    $settings = App\Models\Setting::pluck('value','key')->toArray();
    $frontSettings = \App\Models\FrontSetting::pluck('value','key')->toArray();
    $socialIcons = \App\Models\SocialIcon::all();
@endphp
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <link rel="icon" href="{{ $settings['favicon'] }}" type="image/png">
    <title>@yield('title') | {{getAppName()}}</title>
    
    <link href="{{ mix('assets/css/third-party.css') }}" rel="stylesheet">
    <link href="{{ mix('css/front-third-party.css') }}" rel="stylesheet">
    <link href="{{ mix('css/front-pages.css') }}" rel="stylesheet">
    <script src="{{ asset('assets/js/custom/helper.js') }}"></script>
    @livewireStyles
    
    <script src="{{ asset('vendor/livewire/livewire.js') }}"></script>
    @include('livewire.livewire-turbo')
    <script src="https://js.stripe.com/v3/"></script>
    @routes
    <script src='{{ asset('assets/js/api.js') }}'></script>
    <script>
        var siteKey = "{{$settings['site_key']}}"
    </script>
    <script src="{{ mix('js/third-party.js') }}"></script>
    <script src="{{ mix('js/front-third-party.js') }}"></script>
    <script src="{{ mix('assets/js/front-pages.js') }}"></script>
  
    @yield('page_js')
</head>

<body>
<!-- start header section -->
@include('front.layout.header')
<!-- end header section -->
@yield('content')
<!-- start footer-section -->
@include('front.layout.footer')
<!-- end footer-section -->

</body>
</html>
