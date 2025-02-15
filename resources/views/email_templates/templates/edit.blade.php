@extends('layouts.app')
@section('title')
    {{ __('messages.email_template.edit_email_template') }}
@endsection
@section('header_toolbar')
    <div class="container-fluid">
        <div class="d-md-flex align-items-center justify-content-between mb-5">
            <h1 class="mb-0">@yield('title')</h1>
            <div class="text-end mt-4 mt-md-0">
                <a href="{{ route('email.template.index') }}" class="btn btn-outline-primary">{{ __('messages.common.back') }}</a>
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
                {{ Form::model($emailTemplate, ['route' => ['email.template.update', $emailTemplate->id], 'method' => 'put', 'id' => 'editEmailTemplateForm', 'files' => 'true']) }}
                <div class="section-body">
                    <div class="card mt-2">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 mb-5">
                                    {{ Form::label('name',__('messages.email_template.name').(':'), ['class' => 'form-label']) }}
                                    <span class="required"></span>
                                    {{ Form::text('name', null, ['id'=>'addEmailName','class' => 'form-control','required','readonly','placeholder' => __('messages.email_template.name')]) }}
                                </div>
                                <div class="col-sm-12 mb-5">
                                    {{ Form::label('subject',__('messages.email_template.subject').(':'), ['class' => 'form-label']) }}
                                    <span class="required"></span>
                                    {{ Form::text('subject', null, ['id'=>'editSubject','class' => 'form-control','required','placeholder' => __('messages.email_template.subject')]) }}
                                </div>
                                <div class="">
                                    <div class="col-sm-12 mb-5">
                                        {{ Form::label('message', __('messages.email_template.message').(':'),['class' => 'form-label']) }}
                                        <span class="required"></span>
                                        {{ Form::hidden('message', null, ['id' => 'editTemplateDescription']) }}
                                        <div id="emailTemplateEditBodyQuillData"> {!! $emailTemplate->message??null !!} </div>
                                    </div>
                                    <div class="col-sm-12 mb-5">
                                        {{ Form::label('variables',__('messages.email_template.variables').(':'), ['class' => 'form-label']) }}
                                        {{ Form::text('variables', $emailTemplate->variables, ['id'=>'addEmailVariables','class' => 'form-control','readonly','placeholder' => __('messages.email_template.name')]) }}
                                    </div>
                                </div>
                                <div class="col-sm-12 mb-5">
                                    {{ Form::label('status',__('messages.email_template.status').(':'), ['class' => 'form-label']) }}
                                    <div class="form-check form-switch form-check-custom form-check-solid justify-content-center">
                                        <input class="form-check-input h-20px w-30px" type="checkbox" name="status"
                                               value="1"
                                                {{ $emailTemplate->status == 1 ? 'checked' : '' }} >
                                    </div>
                                </div>
                                <div class="d-flex">
                                    {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary me-3']) }}
                                    <a href="{{ route('email.template.index') }}"
                                       class="btn btn-secondary me-2">{{__('messages.common.cancel')}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
        {{Form::hidden('emailBody',json_encode($emailTemplate->message),['id'=>'editEmailBody'])}}
    </div>
@endsection
