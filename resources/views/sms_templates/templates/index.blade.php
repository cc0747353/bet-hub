@extends('layouts.app')
@section('title')
    {{ __('messages.sms_manager.sms_template') }}
@endsection
@push('css')
    <link rel="stylesheet" href="{{ asset('css/header-padding.css') }}">
@endpush
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column ">
            @include('flash::message')
            <livewire:sms-template-table/>
        </div>
    </div>
@endsection
