@extends('layouts.app')
@section('title')
    {{ __('messages.sms_manager.global_setting') }}
@endsection
@section('header_toolbar')
    <div class="container-fluid">
        <div class="d-md-flex align-items-center justify-content-between mb-5">
            <h1 class="mb-0">@yield('title')</h1>
        </div>
    </div>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column">
            <div class="row">
                <div class="col-12">
                    @include('flash::message')
                    @include('layouts.errors')
                </div>
                {{ Form::open(['route' => 'sms.global.setting.store', 'method' => 'post', 'id' => 'editSmsGlobalSettingForm', 'files' => 'true']) }}
                <div class="section-body">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    {{ Form::label('global_template',__('messages.sms_manager.global_template').(':'), ['class' => 'form-label']) }}
                                    <span class="required"></span>
                                    {{ Form::text('global_template', $globalSetting['global_template'] ?? null, ['id'=>'editGlobalTemplate','class' => 'form-control']) }}
                                </div>
                                <div class="mt-6">
                                    {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary me-3']) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection
