@extends('layouts.app')
@section('title')
    {{__('messages.currency.currency')}}
@endsection
@section('content')
    <div class="container-fluid">
        @include('layouts.errors')
        @include('flash::message')
        <livewire:currencies-table/>
        @include('currencies.create-modal')
        @include('currencies.edit-modal')
    </div>
@endsection
