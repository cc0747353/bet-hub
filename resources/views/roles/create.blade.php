@extends('layouts.app')
@section('title')
    {{__('messages.role.add_role')}}
@endsection
@section('header_toolbar')
    <div class="container-fluid">
        <div class="d-md-flex align-items-center justify-content-between mb-5">
            <h1 class="mb-0">@yield('title')</h1>
            <div class="text-end mt-4 mt-md-0">
                <a href="{{ route('roles.index') }}" class="btn btn-outline-primary">{{ __('messages.common.back') }}</a>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex  flex-lg-row">
            <div class="flex-lg-row-fluid mb-10 mb-lg-0">
                <div class="row">
                    <div class="col-12">
                        @include('layouts.errors')
                    </div>
                </div>
                {{ Form::hidden('is_edit', $permissions['count'],['id' => 'totalPermissions']) }}
                {{ Form::hidden('is_edit', false,['id' => 'roleIsEdit']) }}
                <div class="card">
                    <div class="card-body p-0">
                        {{ Form::open(['route' => 'roles.store']) }}
                        <div class="card-body p-9">
                            @include('roles.fields')
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
