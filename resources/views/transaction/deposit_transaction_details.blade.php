@extends('layouts.app')
@section('title')
    {{ __('messages.transaction.transaction_details') }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-end mb-5">
            <h1> {{ __('messages.transaction.transaction_details') }}</h1>
            <a class="btn btn-outline-primary float-end" href="{{ route('show-all-deposit') }}">{{ __('messages.common.back') }}</a>
        </div>
        <div class="d-flex flex-column">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 d-flex flex-column mb-md-10 mb-5">
                            <label for="name" class="pb-2 fs-4 text-gray-600">{{ __('messages.user.username').':' }}</label>
                            <span class="fs-4 text-gray-800">{{$transaction->user->full_name}}</span>
                        </div>
                        <div class="col-md-6 d-flex flex-column mb-md-10 mb-5">
                            <label for="name" class="pb-2 fs-4 text-gray-600">{{ __('messages.user.email').':' }}</label>
                            <span class="fs-4 text-gray-800">{{$transaction->user->email}}</span>
                        </div>

                        <div class="col-md-6 d-flex flex-column mb-md-10 mb-5">
                            <label for="name" class="pb-2 fs-4 text-gray-600">{{ __('messages.transaction.transaction_id').':' }}</label>
                            <span class="fs-4 text-gray-800">{{$transaction->transaction_id}}</span>
                        </div>

                        <div class="col-md-6 d-flex flex-column mb-md-10 mb-5">
                            <label for="name" class="pb-2 fs-4 text-gray-600">{{ __('messages.deposit.total_amount').':' }}</label>
                            <span class="fs-4 text-gray-800">{{ !empty($transaction->amount) ? $transaction->currency->currency_icon.' '.numberFormatShort($transaction->amount) : 'NA' }}</span>
                        </div>

                        <div class="col-md-6 d-flex flex-column mb-md-10 mb-5">
                            <label for="name" class="pb-2 fs-4 text-gray-600">{{ __('messages.deposit.tax').':' }}</label>
                            <span class="fs-4 text-gray-800">{{ !empty($transaction->tax) ? $transaction->tax.'%' : 'NA' }}</span>
                        </div>

                        <div class="col-md-6 d-flex flex-column mb-md-10 mb-5">
                            <label for="name" class="pb-2 fs-4 text-gray-600">{{ __('messages.deposit.deposit') }} {{ __('messages.deposit.amount').':' }}</label>
                            <span class="fs-4 text-gray-800">{{ !empty($transaction->deposit_amount) ? $transaction->currency->currency_icon.' '.numberFormatShort($transaction->deposit_amount) : 'NA' }}</span>
                        </div>

                        <div class="col-md-6 d-flex flex-column mb-md-10 mb-5">
                            <label for="name" class="pb-2 fs-4 text-gray-600">{{ __('messages.payment.payment_method').':' }}</label>
                            <span class="fs-4 text-gray-800"><span class="badge bg-primary">{{\App\Models\PaymentGateway::REFERRAL_PAYMENT_METHOD[$transaction->type]}}</span></span>
                        </div>

                        <div class="col-md-6 d-flex flex-column mb-md-10 mb-5">
                            <label for="name" class="pb-2 fs-4 text-gray-600">{{ __('messages.deposit.status').':' }}</label>
                            <span class="fs-4 text-gray-800"><span class="badge bg-{{ \App\Models\DepositTransaction::STATUS_COLOR[$transaction->status] }}">{{\App\Models\DepositTransaction::PAYMENT_STATUS[$transaction->status]}}</span></span>    
                        </div>
                        @if(!empty($transaction->notes))
                            <div class="col-md-6 d-flex flex-column mb-md-10 mb-5">
                                <label for="name" class="pb-2 fs-4 text-gray-600">{{ __('messages.deposit.notes').':' }}</label>
                                <span class="fs-4 text-gray-800">{!! $transaction->notes !!}</span>
                            </div>
                        @endif
                        @if(!empty($transaction->attachment))
                            <div class="col-md-6 d-flex flex-column mb-md-10 mb-5">
                                <label for="name" class="pb-2 fs-4 text-gray-600">{{ __('messages.deposit.attachment').':' }}</label>
                                <span class="fs-4 text-gray-800"><a href="{{$transaction->attachment}}" target="_blank" download="">{{basename($transaction->attachment)}}</a></span>
                            </div>
                        @endif
                        @if(!empty($transaction->message))
                            <div class="col-md-6 d-flex flex-column mb-md-10 mb-5">
                                <label for="name" class="pb-2 fs-4 text-gray-600">{{ __('messages.email_template.message').':' }}</label>
                                <span class="fs-4 text-gray-800">{!! $transaction->message !!}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
