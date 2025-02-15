@extends('layouts.app')
@section('title')
    {{ __('messages.front_settings.cms') }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column">
            @include('flash::message')
            @include('layouts.errors')
            @include('front_settings.setting-menu')
            @yield('section')
        </div>
    </div>
@endsection
