@extends('layouts.app')
@section('title')
    {{ __('messages.common.payment_gateways') }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column ">
            @include('flash::message')
            <livewire:payment-gateways-table/>
        </div>
    </div>
@endsection
