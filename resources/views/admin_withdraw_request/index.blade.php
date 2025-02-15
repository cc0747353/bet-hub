@extends('layouts.app')
@section('title')
    {{ __('messages.withdraw.withdraw_requests') }}
@endsection
@section('content')
    <div class="container-fluid">
        <livewire:admin-withdraw-request-table/>
        @include('admin_withdraw_request.withdraw_request_modal')
        @include('admin_withdraw_request.withdraw_reject_request_modal')
    </div>
@endsection
