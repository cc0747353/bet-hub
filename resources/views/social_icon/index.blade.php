@extends('layouts.app')
@section('title')
    {{ __('Social Icon') }}
@endsection
@section('content')
    <div class="container-fluid">
        <livewire:social-icon-table/>
        @include('social_icon.create_modal')
        @include('social_icon.edit_modal')
    </div>
@endsection
