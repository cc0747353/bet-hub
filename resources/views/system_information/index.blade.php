@extends('layouts.app')
@section('title')
    {{__('messages.system_information.system_information')}}
@endsection
@section('header_toolbar')
    <div class="container-fluid mb-5">
        <h1>{{__('messages.system_information.system_information')}}</h1>
    </div>
@endsection
@section('content')
    <div class="container-fluid">
        @include('layouts.errors')
        @include('flash::message')
        <div class="card">
            <div class="card-body">
                <div class="row mb-5">
                    <div class="col-lg-4">
                        {{ Form::label('php_version',__('messages.system_information.php_version').':',['class'=>'form-label']) }}
                    </div>
                    <div class="col-lg-8">
                        <h5>{{ phpversion() }}</h5>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-lg-4">
                        {{ Form::label('laravel_version',__('messages.system_information.laravel_version').':',['class'=>'form-label']) }}
                    </div>
                    <div class="col-lg-8">
                        <h5>{{ app()->version() }}</h5>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-lg-4">
                        {{ Form::label('server_software',__('messages.system_information.server_software').':',['class'=>'form-label']) }}
                    </div>
                    <div class="col-lg-8">
                        <h5>{{ $_SERVER['SERVER_SOFTWARE'] }}</h5>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-lg-4">
                        {{ Form::label('server_ip_address',__('messages.system_information.server_ip_address').':',['class'=>'form-label']) }}
                    </div>
                    <div class="col-lg-8">
                        <h5>{{ $_SERVER['SERVER_ADDR'] }}</h5>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-lg-4">
                        {{ Form::label('server_protocol',__('messages.system_information.server_protocol').':',['class'=>'form-label']) }}
                    </div>
                    <div class="col-lg-8">
                        <h5>{{ $_SERVER['SERVER_PROTOCOL'] }}</h5>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-lg-4">
                        {{ Form::label('http_host',__('messages.system_information.http_host').':',['class'=>'form-label']) }}
                    </div>
                    <div class="col-lg-8">
                        <h5>{{ config('app.url') }}</h5>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-lg-4">
                        {{ Form::label('database_port',__('messages.system_information.database_port').':',['class'=>'form-label']) }}
                    </div>
                    <div class="col-lg-8">
                        <h5>{{ config('app.database_port') }}</h5>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-lg-4">
                        {{ Form::label('app_environment',__('messages.system_information.app_environment').':',['class'=>'form-label']) }}
                    </div>
                    <div class="col-lg-8">
                        <h5>{{ config('app.env') }}</h5>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-lg-4">
                        {{ Form::label('app_debug',__('messages.system_information.app_debug').':',['class'=>'form-label']) }}
                    </div>
                    <div class="col-lg-8">
                        <h5>{{ config('app.debug') == 1 ? 'true': 'false' }}</h5>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-lg-4">
                        {{ Form::label('timezone',__('messages.system_information.timezone').':',['class'=>'form-label']) }}
                    </div>
                    <div class="col-lg-8">
                        <h5>{{ config('app.timezone') }}</h5>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-lg-4">
                        {{ Form::label('version',__('messages.system_information.app_version').':',['class'=>'form-label']) }}
                    </div>
                    <div class="col-lg-8">
                        <h5>v{{ getCurrentVersion() }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

