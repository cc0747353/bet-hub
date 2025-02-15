@extends('layouts.app')
@section('title')
    {{ __('messages.matches.all_matches') }}
@endsection
@push('css')
    <link rel="stylesheet" href="{{ asset('css/header-padding.css') }}">
@endpush
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column ">
            @include('flash::message')
            <livewire:all-matches-table/>
        </div>
    </div>
@endsection
