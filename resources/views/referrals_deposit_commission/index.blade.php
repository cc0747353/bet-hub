@extends('layouts.horizontal.app')
@section('title')
    {{__('messages.common.referrals')}}
@endsection
@section('content')
    <div class="container-fluid">
        @include('users_referral.index')
        @include('layouts.errors')
        @include('flash::message')
        <livewire:referral-deposit-commission-table/>
    </div>
@endsection
