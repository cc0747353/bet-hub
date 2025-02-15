@extends('layouts.app')
@section('title')
    {{ __('messages.common.categories') }}
@endsection
@section('content')
    <div class="container-fluid">
                <livewire:category-table/>
                @include('categories.create_modal')
                @include('categories.edit_modal')
    </div>
@endsection
