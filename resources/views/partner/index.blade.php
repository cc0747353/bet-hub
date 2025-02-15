@extends('layouts.app')
@section('title')
    {{ __('messages.common.partner') }}
@endsection
@section('content')
    <div class="container-fluid">
        <livewire:partner-table/>
        @include('partner.create_modal')
        @include('partner.edit_modal')
    </div>
@endsection
