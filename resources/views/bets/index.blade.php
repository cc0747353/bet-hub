@extends('layouts.app')
@section('title')
    {{ __('messages.bets.bets') }}
@endsection
@push('css')
    <link rel="stylesheet" href="{{ asset('css/header-padding.css') }}">
@endpush
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column ">
            @include('flash::message')
            <livewire:bet-table/>
        </div>
    </div>
@endsection
