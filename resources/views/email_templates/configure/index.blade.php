@extends('layouts.app')
@section('title')
    {{ __('messages.email_template.email_configuration') }}
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
                {{ Form::open(['route' => 'email.configure.update', 'method' => 'post', 'id' => 'addEmailConfigureSettings']) }}
                <div class="section-body">
                    <div class="card mt-2">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6 mb-5">
                                    {{ Form::label('email_send_method',__('messages.email_template.email_send_method').(':'), ['class' => 'form-label']) }}
                                    <span class="required"></span>
                                    {{ Form::select('email_send_method', $emailSendMethod, $emailData['email_send_method'] ?? null, [
                                   'class' => 'form-select', 'aria-label'=>"Select a Method",
                                   'data-control'=>'select2','id' => 'sendEmailMethod']) }}
                                </div>
                                <div class="col-sm-6 mt-8 text-end">
                                    <button class="btn btn-primary" id="sendTestEmail" type="button">{{ __('messages.email_template.send_test_mail') }}</button>
                                </div>
                            </div>
                            <div class="mail-block">
                                <div class="smtp-block">
                                    <div class="row">
                                        <h5>{{ __('messages.email_template.SMTP_configuration') }}</h5>
                                        <div class="col-sm-4 mb-5">
                                            {{ Form::label('smtp_host', __('messages.email_template.host').(':'), ['class' => 'form-label']) }}
                                            <span class="required"></span>
                                            {{ Form::text('smtp_host',$emailData['smtp_host'] ?? null, ['id'=>'editSmtpHost','class' => 'form-control','placeholder' => 'e.g. smtp.googlemail.com']) }}
                                        </div>
                                        <div class="col-sm-4 mb-5">
                                            {{ Form::label('smtp_port',__('messages.email_template.port').(':'), ['class' => 'form-label']) }}
                                            <span class="required"></span>
                                            {{ Form::text('smtp_port',$emailData['smtp_port'] ?? null, ['id'=>'editSmtpPort','class' => 'form-control','placeholder' => __('messages.email_template.available_port') ]) }}
                                        </div>
                                        <div class="col-sm-4 mb-5">
                                            {{ Form::label('smtp_encryption',__('messages.email_template.encryption').(':'), ['class' => 'form-label']) }}
                                            {{ Form::select('smtp_encryption', $emailEncryption, $emailData['smtp_encryption'] ?? null, [
                                           'class' => 'form-select', 'aria-label'=> "Select a Encryption",
                                           'data-control'=>'select2']) }}
                                        </div>
                                        <div class="col-sm-6 mb-5">
                                            {{ Form::label('smtp_username', __('messages.email_template.username').(':'), ['class' => 'form-label']) }}
                                            <span class="required"></span>
                                            {{ Form::text('smtp_username',$emailData['smtp_username'] ?? null, ['id'=>'editSmtpUsername','class' => 'form-control','placeholder' => __('messages.email_template.normally_your_email_address')]) }}
                                        </div>
                                        <div class="col-sm-6 mb-5">
                                            {{ Form::label('smtp_password', __('messages.email_template.password').(':'), ['class' => 'form-label']) }}
                                            <span class="required"></span>
                                            {{ Form::text('smtp_password',$emailData['smtp_password'] ?? null, ['id'=>'editSmtpPassword','class' => 'form-control','placeholder' => __('messages.email_template.normally_your_email_password')]) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="sendgrid-block">
                                    <div class="row">
                                        <h5>{{ __('messages.email_template.SendGrid_API_Configuration') }}</h5>
                                        <div class="col-sm-12 mb-5">
                                            {{ Form::label('sendgrid_key',__('messages.email_template.app_key').(':'), ['class' => 'form-label']) }}
                                            <span class="required"></span>
                                            {{ Form::text('sendgrid_key',$emailData['sendgrid_key'] ?? null, ['class' => 'form-control','placeholder' => __('messages.email_template.sendGrid_app_key')]) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="mailjet-block">
                                    <div class="row">
                                        <h5>{{ __('messages.email_template.Mailjet_API_Configuration') }}</h5>
                                        <div class="col-sm-6 mb-5">
                                            {{ Form::label('mailjet_public_key',__('messages.email_template.api_public_key').(':'), ['class' => 'form-label']) }}
                                            <span class="required"></span>
                                            {{ Form::text('mailjet_public_key',$emailData['mailjet_public_key'] ?? null, ['class' => 'form-control','placeholder' => __('messages.email_template.Mailjet_api_public_key')]) }}
                                        </div>
                                        <div class="col-sm-6 mb-5">
                                            {{ Form::label('mailjet_secret_key', __('messages.email_template.api_secret_key').(':'), ['class' => 'form-label']) }}
                                            <span class="required"></span>
                                            {{ Form::text('mailjet_secret_key',$emailData['mailjet_secret_key'] ?? null, ['class' => 'form-control','placeholder' => __('messages.email_template.Mailjet_api_secret_key')]) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-10">
                                {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary me-3', 'id' => 'emailConfigurationSaveBtn']) }}
                            </div>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
    @include('email_templates.configure.send_email_model')
@endsection
