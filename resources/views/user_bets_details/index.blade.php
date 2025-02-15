@extends('layouts.horizontal.app')
@section('title')
    {{ __('messages.deposit.deposits') }}
@endsection
@section('content')
    <div class="container-fluid">
        <livewire:user-bets-details-table/>
    </div>
@endsection
