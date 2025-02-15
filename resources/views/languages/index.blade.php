@extends('layouts.app')
@section('title')
    {{__('messages.languages.language')}}
@endsection
@section('content')
    <div class="container-fluid">
        <livewire:language-table/>
        @include('languages.create_modal')
        @include('languages.edit_modal')
    </div>
@endsection
