@extends('layouts.app')
@section('title')
    {{__('messages.role.role')}}
@endsection
@section('content')
    <div class="container-fluid">
        @include('layouts.errors')
        @include('flash::message')
        <livewire:role-table/>
        @include('languages.create_modal')
        @include('languages.edit_modal')
    </div>
@endsection
