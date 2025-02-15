@extends('layouts.app')
@section('title')
    {{__('messages.user.users')}}
@endsection
@section('content')
    <div class="container-fluid">
        @include('layouts.errors')
        @include('flash::message')
        <livewire:user-table/>
        @include('languages.create_modal')
        @include('languages.edit_modal')
    </div>
@endsection
