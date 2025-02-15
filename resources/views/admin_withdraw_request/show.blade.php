@extends('layouts.app')
@section('title')
    {{ __('messages.transaction.transaction_details') }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-end mb-5">
            <h1> {{ __('messages.transaction.withdraw_req_details') }}</h1>
            <a class="btn btn-outline-primary float-end" href="{{ route('show-all-withdraw-request') }}">{{ __('messages.common.back') }}</a>
        </div>
        <div class="d-flex flex-column">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 d-flex flex-column mb-md-10 mb-5">
                            <label for="name" class="pb-2 fs-4 text-gray-600">{{ __('messages.user.username').':' }}</label>
                            <span class="fs-4 text-gray-800">{{$withdrawRequest->user->full_name}}</span>
                        </div>
                        <div class="col-md-6 d-flex flex-column mb-md-10 mb-5">
                            <label for="name" class="pb-2 fs-4 text-gray-600">{{ __('messages.user.email').':' }}</label>
                            <span class="fs-4 text-gray-800">{{$withdrawRequest->user->email}}</span>
                        </div>
                        <div class="col-md-6 d-flex flex-column mb-md-10 mb-5">
                            <label for="name" class="pb-2 fs-4 text-gray-600">{{ __('messages.deposit.total_amount').':' }}</label>
                            <span class="fs-4 text-gray-800">{{$withdrawRequest->currency->currency_icon.' '.numberFormatShort($withdrawRequest->amount) }}</span>
                        </div>

                        <div class="col-md-6 d-flex flex-column mb-md-10 mb-5">
                            <label for="name" class="pb-2 fs-4 text-gray-600">{{ __('messages.payment.payment_method').':' }}</label>
                            <span class="fs-4 text-gray-800"><span class="badge bg-primary">{{\App\Models\WithdrawRequests::PAYMENT_METHOD[$withdrawRequest->method]}}</span></span>
                        </div>

                        <div class="col-md-6 d-flex flex-column mb-md-10 mb-5">
                            <label for="name" class="pb-2 fs-4 text-gray-600">{{ __('messages.deposit.status').':' }}</label>
                            <span class="fs-4 text-gray-800"><span class="badge bg-{{ \App\Models\WithdrawRequests::STATUS_COLOR[$withdrawRequest->status] }}">{{\App\Models\WithdrawRequests::PAYMENT_STATUS[$withdrawRequest->status]}}</span></span>    
                        </div>
                        @if(!empty($withdrawRequest->notes))
                            <div class="col-md-6 d-flex flex-column mb-md-10 mb-5">
                                <label for="name" class="pb-2 fs-4 text-gray-600">{{ __('messages.deposit.notes').':' }}</label>
                                <span class="fs-4 text-gray-800">{!! $withdrawRequest->notes !!}</span>
                            </div>
                        @endif
                        @if(!empty($withdrawRequest->user_notes))
                            <div class="col-md-6 d-flex flex-column mb-md-10 mb-5">
                                <label for="name" class="pb-2 fs-4 text-gray-600">{{ __('messages.referral.user') }} {{ __('messages.deposit.notes').':' }}</label>
                                <span class="fs-4 text-gray-800">{!! $withdrawRequest->user_notes !!}</span>
                            </div>
                        @endif
                        @if(!empty($withdrawRequest->attachment))
                            <div class="col-md-6 d-flex flex-column mb-md-10 mb-5">
                                <label for="name" class="pb-2 fs-4 text-gray-600">{{ __('messages.deposit.attachment').':' }}</label>
                                <span class="fs-4 text-gray-800"><a href="{{$withdrawRequest->attachment}}" target="_blank" download="">{{basename($withdrawRequest->attachment)}}</a></span>
                            </div>
                        @endif
                        @if(!empty($paymentSettings->email))
                            <div class="col-md-6 d-flex flex-column mb-md-10 mb-5">
                                <label for="name" class="pb-2 fs-4 text-gray-600">Paypal {{ __('messages.user.email').':' }}</label>
                                <span class="fs-4 text-gray-800">{{$paymentSettings->email}}</span>
                            </div>
                        @endif
                        @if(!empty($paymentSettings->account_number))
                            <div class="col-md-6 d-flex flex-column mb-md-10 mb-5">
                                <label for="name" class="pb-2 fs-4 text-gray-600">{{ __('messages.withdraw.account_number').':' }}</label>
                                <span class="fs-4 text-gray-800">{{$paymentSettings->account_number}}</span>
                            </div>
                        @endif

                        @if(!empty($paymentSettings->ifsc_number))
                            <div class="col-md-6 d-flex flex-column mb-md-10 mb-5">
                                <label for="name" class="pb-2 fs-4 text-gray-600">{{ __('messages.withdraw.IFSC_number').':' }}</label>
                                <span class="fs-4 text-gray-800">{{$paymentSettings->ifsc_number}}</span>
                            </div>
                        @endif

                        @if(!empty($paymentSettings->branch_name))
                            <div class="col-md-6 d-flex flex-column mb-md-10 mb-5">
                                <label for="name" class="pb-2 fs-4 text-gray-600">{{ __('messages.withdraw.branch_name').':' }}</label>
                                <span class="fs-4 text-gray-800">{{$paymentSettings->branch_name}}</span>
                            </div>
                        @endif

                        @if(!empty($paymentSettings->account_holder_name))
                            <div class="col-md-6 d-flex flex-column mb-md-10 mb-5">
                                <label for="name" class="pb-2 fs-4 text-gray-600">{{ __('messages.withdraw.account_holder_name').':' }}</label>
                                <span class="fs-4 text-gray-800">{{$paymentSettings->account_holder_name}}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
