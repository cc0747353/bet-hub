@extends('layouts.app')
@section('title')
    {{ __('messages.deposit.transaction') }}
@endsection
@section('content')
    <div class="container-fluid">
        <livewire:transaction-table/>
    </div>
@endsection
