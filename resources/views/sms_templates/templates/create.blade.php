@extends('layouts.app')
@section('title')
    {{ __('messages.sms_manager.template_name') }}
@endsection
@section('header_toolbar')
    <div class="container-fluid">
        <div class="d-md-flex align-items-center justify-content-between mb-5">
            <h1 class="mb-0">@yield('title')</h1>
            <div class="text-end mt-4 mt-md-0">
                <a href="{{ route('sms-template.index') }}" class="btn btn-outline-primary">{{ __('messages.common.back') }}</a>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column">
            <div class="row">
                <div class="col-12">
                    @include('layouts.errors')
                </div>
                {{ Form::open(['route' => 'sms-template.store', 'method' => 'post', 'id' => 'addSmsTemplateForm', 'files' => 'true']) }}
                <div class="section-body">
                    <div class="card mt-2">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 mb-5">
                                    {{ Form::label('name',__('Name').(':'), ['class' => 'form-label']) }}
                                    <span class="required"></span>
                                    {{ Form::text('name', null, ['id'=>'addSmsName','class' => 'form-control','required','placeholder' => __('Name')]) }}
                                </div>
                                @php
                                    $messageCss = 'style="height: 256px"';
                                @endphp
                                <div class="col-sm-12 mb-5">
                                    <label for="description" class="form-label">{{ __('messages.sms_manager.message') }}
                                        :</label>
                                    <textarea class="form-control" placeholder="{{ __('messages.sms_manager.message') }}"
                                              id="smsMessage" rows="5" name="message"
                                              cols="50" maxlength="800" {!! $messageCss !!}></textarea>
                                </div>
                                <div class="col-sm-12">
                                    {{ Form::label('status',__('messages.sms_manager.status').(':'), ['class' => 'form-label']) }}
                                    <div class="form-check form-switch form-check-custom form-check-solid justify-content-center">
                                        <input class="form-check-input h-20px w-30px" type="checkbox" name="status"
                                               value="1">
                                    </div>
                                </div>
                                <div class="d-flex mt-5">
                                    {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary me-3']) }}
                                    <a href="{{ route('sms-template.index') }}"
                                       class="btn btn-secondary me-2">{{__('messages.common.cancel')}}</a>
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
