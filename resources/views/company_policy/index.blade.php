@extends('layouts.app')
@section('title')
    {{__('messages.common.company_policy')}}
@endsection
@section('header_toolbar')
    <div class="container-fluid mb-5">
        <h1>{{__('messages.common.company_policy')}}</h1>
    </div>
@endsection
@section('content')
    <div class="container-fluid">
        @include('layouts.errors')
        @include('flash::message')
        <div class="card">
            {{ Form::open(['route' => 'company-policy.update', 'id'=>'companyPolicyForm', 'class'=>'form']) }}
            <div class="card-body">
                <div class="row mb-5">
                    <div class="col-sm-12 mb-32 mb-md-20">
                        {{ Form::label('licences_info', __('messages.front.licences_info').(':'),['class' => 'form-label',]) }}
                        <span class="required"></span>
                        {{ Form::hidden('licences_info', null, ['id' => 'licencesInfo']) }}
                        <div id="licencesInfoQuillData">{!! !empty( $companyPolicyData['licences_info']) ? $companyPolicyData['licences_info'] : null !!}</div>
                    </div>
                    <div class="col-sm-12 mb-32 mb-md-20 mt-18 mt-md-8">
                        {{ Form::label('rules_for_bet', __('messages.front.rules_for_bet').(':'),['class' => 'form-label',]) }}
                        <span class="required"></span>
                        {{ Form::hidden('rules_for_bet', null, ['id' => 'rulesForBet']) }}
                        <div id="rulesForBetQuillData">{!! !empty($companyPolicyData['rules_for_bet']) ? $companyPolicyData['rules_for_bet'] : null !!}</div>
                    </div>
                    <div class="col-sm-12 mb-32 mb-md-20 mt-18 mt-md-8">
                        {{ Form::label('terms_of_service', __('messages.front.terms_of_service').(':'),['class' => 'form-label',]) }}
                        <span class="required"></span>
                        {{ Form::hidden('terms_of_service', null, ['id' => 'termsOfService']) }}
                        <div id="termsOfServiceQuillData">{!! !empty($companyPolicyData['terms_of_service']) ? $companyPolicyData['terms_of_service'] : null !!}</div>
                    </div>
                    <div class="col-sm-12 mb-32 mb-md-20 mt-18 mt-md-8">
                        {{ Form::label('privacy_policy', __('messages.front.privacy_policy').(':'),['class' => 'form-label',]) }}
                        <span class="required"></span>
                        {{ Form::hidden('privacy_policy', null, ['id' => 'privacyPolicy']) }}
                        <div id="privacyPolicyQuillData">{!! !empty($companyPolicyData['privacy_policy']) ? $companyPolicyData['privacy_policy'] : null !!}</div>
                    </div>
                </div>
                <div class="mt-10">
                    {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary me-3']) }}
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection

