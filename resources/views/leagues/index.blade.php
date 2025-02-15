@extends('layouts.app')
@section('title')
    {{ __('messages.common.leagues') }}
@endsection
@section('content')
    <div class="container-fluid">
        <livewire:league-table/>
        @include('leagues.create_modal')
        @include('leagues.edit_modal')
    </div>
@endsection
