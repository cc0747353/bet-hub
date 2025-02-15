@extends('layouts.app')
@section('title')
    {{__('messages.user.add_user')}}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-md-flex align-items-center justify-content-between mb-5">
            <h1 class="mb-0">@yield('title')</h1>
            <a href="{{ route('users.index') }}"
               class="btn btn-outline-primary">{{ __('messages.common.back') }}</a>
        </div>
        <div class="col-12">
            @include('layouts.errors')
        </div>
        <div class="card">
            <div class="card-body">
                {{ Form::open(['route' => 'users.store' ,'files' => true, 'id'=> 'userCreateForm']) }}
                @include('users.fields')
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection
