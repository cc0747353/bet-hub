@extends('layouts.horizontal.app')
@section('title')
    {{__('messages.withdraw.withdraw_requests')}}
@endsection
@section('content')
    <div class="container-fluid">
        @include('layouts.errors')
        @include('flash::message')
        <div class="card mb-5">
            {{ Form::open(['route' => 'user.settings-update', 'class'=>'form' ]) }}
            <div class="card-body p-8">
                <div class="paypal">
                    <div class="row">
                        <div class="col-12 d-flex align-items-center">
                            <span class="text-gray-700 fw-bolder fs-3 mb-5">{{ __('messages.withdraw.paypal_details') }}</span>
                        </div>
                        <div class="form-group col-sm-6 mb-5">
                            {{ Form::label('email', __('messages.withdraw.email').' :', ['class' => 'form-label fs-6 fw-bolder text-gray-700 mb-3 required']) }}
                            {{ Form::text('email', $setting['email']??null, ['class' => 'form-control form-control-solid', 'required', 'id' => '' , 'placeholder' => __('messages.withdraw.email')]) }}
                        </div>
                    </div>
                </div>
                <div class="bank">
                    <div class="row">
                        <div class="col-12 d-flex align-items-center">
                            <span class="text-gray-700 fw-bolder fs-3 mb-5">{{ __('messages.withdraw.bank_details') }}</span>
                        </div>
                        <div class="form-group col-sm-6 mb-4">
                            <label for="account_number" class="form-label fs-6 fw-bolder text-gray-700 mb-3 required">{{ __('messages.withdraw.account_number') }} :</label>
                            <input class="form-control form-control-solid" required id="" placeholder="{{ __('messages.withdraw.account_number') }}"
                                   name="account_number" type="text" value="{{ $setting['account_number'] ?? null }}">
                        </div>
                        <div class="form-group col-sm-6 mb-4">
                            <label for="ifsc_number" class="form-label fs-6 fw-bolder text-gray-700 mb-3 required">{{ __('messages.withdraw.IFSC_number') }} :</label>
                            <input class="form-control form-control-solid" required id="" placeholder="{{ __('messages.withdraw.IFSC_number') }}"
                                   name="ifsc_number" type="text" value="{{ $setting['ifsc_number'] ?? null }}">
                        </div>
                        <div class="form-group col-sm-6 mb-4">
                            <label for="branch_name" class="form-label fs-6 fw-bolder text-gray-700 mb-3 required">{{ __('messages.withdraw.branch_name') }} :</label>
                            <input class="form-control form-control-solid" required id="" placeholder="{{ __('messages.withdraw.branch_name') }}"
                                   name="branch_name" type="text" value="{{ $setting['branch_name'] ?? null }}">
                        </div>
                        <div class="form-group col-sm-6 mb-4">
                            <label for="account_holder_name" class="form-label fs-6 fw-bolder text-gray-700 mb-3 required">{{ __('messages.withdraw.account_holder_name') }} :</label>
                            <input class="form-control form-control-solid" required id="" placeholder="{{ __('messages.withdraw.account_holder_name') }}"
                                   name="account_holder_name" type="text" value="{{ $setting['account_holder_name'] ?? null }}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer pt-0">
                <button type="submit" class="btn btn-primary" id="payoutSettingBtn">{{ __('messages.common.save') }}</button>
            </div>
            {{Form::close()}}
        </div>
    </div>
    <div class="container-fluid">
        @include('withdraw_request.create_modal')
        <livewire:user-withdraw-request-table/>
    </div>
@endsection
