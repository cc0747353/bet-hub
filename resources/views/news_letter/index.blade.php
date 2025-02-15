@extends('layouts.app')
@section('title')
    {{__('messages.common.news_letters')}}
@endsection
@section('content')
    <div class="container-fluid">
        <livewire:news-letter-table/>
    </div>
@endsection
