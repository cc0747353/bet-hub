@extends('layouts.horizontal.app')
@section('title')
    {{__('messages.deposit.deposit')}}
@endsection
@section('content')
    <div class="container-fluid">
        @include('layouts.errors')
        @include('flash::message')
        <livewire:user-payment-table/>
    </div>
@endsection
