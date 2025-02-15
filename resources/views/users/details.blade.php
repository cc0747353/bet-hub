@extends('layouts.app')
@section('title')
    {{ __('messages.user.user_details') }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-end mb-5">
            <h1> {{ __('messages.user.user_details') }}</h1>
            <a class="btn btn-outline-primary float-end"
               href="{{ route('users.index') }}">{{ __('messages.common.back') }}</a>
        </div>
        <div class="d-flex flex-column">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 d-flex flex-column mb-md-5 mb-5">
                            <label for="name"
                                   class="pb-2 fs-4 text-gray-600">{{ __('messages.user.full_name').':' }}</label>
                            <span class="fs-4 text-gray-800">{{$userDetails->full_name ?? 'N/A'}}</span>
                        </div>
                        <div class="col-md-4 d-flex flex-column mb-md-5 mb-5">
                            <label for="email"
                                   class="pb-2 fs-4 text-gray-600">{{ __('messages.user.email').':' }}</label>
                            <span class="fs-4 text-gray-800">{{$userDetails->email ?? 'N/A'}}</span>
                        </div>
                        <div class="col-md-4 d-flex flex-column mb-md-5 mb-5">
                            <label for="user_name"
                                   class="pb-2 fs-4 text-gray-600">{{ __('messages.user.user_name').':' }}</label>
                            <span class="fs-4 text-gray-800">{{$userDetails->user_name ?? 'N/A'}}</span>
                        </div>
                        <div class="col-md-4 d-flex flex-column mb-md-5 mb-5">
                            <label for="role" class="pb-2 fs-4 text-gray-600">{{ __('messages.user.role').':' }}</label>
                            <span class="fs-4 text-gray-800">{{$userDetails->roles[0]->display_name ?? 'N/A'}}</span>
                        </div>
                        <div class="col-md-4 d-flex flex-column mb-md-5 mb-5">
                            <label for="contact_no"
                                   class="pb-2 fs-4 text-gray-600">{{ __('messages.user.contact_no').':' }}</label>
                            <span class="fs-4 text-gray-800">{{isset($userDetails->contact) ? '+'.$userDetails->region_code.' '.$userDetails->contact : 'N/A'}}</span>
                        </div>
                        <div class="col-md-4 d-flex flex-column mb-md-5 mb-5">
                            <label for="address_1"
                                   class="pb-2 fs-4 text-gray-600">{{ __('messages.user.address_1').':' }}</label>
                            <span class="fs-4 text-gray-800">{{ $userAddress['address_1'] ?? 'N/A' }}</span>
                        </div>
                        <div class="col-md-4 d-flex flex-column mb-md-5 mb-5">
                            <label for="address_2"
                                   class="pb-2 fs-4 text-gray-600">{{ __('messages.user.address_2').':' }}</label>
                            <span class="fs-4 text-gray-800">{{ $userAddress['address_2'] ?? 'N/A' }}</span>
                        </div>
                        <div class="col-md-4 d-flex flex-column mb-md-5 mb-5">
                            <label for="state"
                                   class="pb-2 fs-4 text-gray-600">{{ __('messages.user.state').':' }}</label>
                            <span class="fs-4 text-gray-800">{{ $userAddress['state'] ?? 'N/A' }}</span>
                        </div>
                        <div class="col-md-4 d-flex flex-column mb-md-5 mb-5">
                            <label for="city" class="pb-2 fs-4 text-gray-600">{{ __('messages.user.city').':' }}</label>
                            <span class="fs-4 text-gray-800">{{ $userAddress['city'] ?? 'N/A' }}</span>
                        </div>
                        <div class="col-md-4 d-flex flex-column mb-md-5 mb-5">
                            <label for="country"
                                   class="pb-2 fs-4 text-gray-600">{{ __('messages.user.country').':' }}</label>
                            <span class="fs-4 text-gray-800">{{ $userAddress['country']['name'] ?? 'N/A' }}</span>
                        </div>
                        <div class="col-md-4 d-flex flex-column mb-md-5 mb-5">
                            <label for="zip" class="pb-2 fs-4 text-gray-600">{{ __('messages.user.zip').':' }}</label>
                            <span class="fs-4 text-gray-800">{{ $userAddress['zip'] ?? 'N/A' }}</span>
                        </div>
                        <div class="col-md-4 d-flex flex-column mb-md-5 mb-5">
                            <label for="status"
                                   class="pb-2 fs-4 text-gray-600">{{ __('messages.user.status').':' }}</label>
                            <span class="w-25 p-2 fs-4 badge {{ isset($userDetails->status) ? ($userDetails->status == 1) ? 'bg-success' : 'bg-danger' : 'N/A' }}">{{ isset($userDetails->status) ? \App\Models\User::STATUS[$userDetails->status] : 'N/A' }}</span>
                        </div>
                        <div class="col-md-4 d-flex flex-column mb-md-5 mb-5">
                            <label for="status"
                                   class="pb-2 fs-4 text-gray-600">{{ __('messages.withdraw.paypal_email').':' }}</label>
                            <span class="fs-4 text-gray-800">{{ $userBankDetails->email ?? 'N/A' }}</span>
                        </div>
                        <div class="col-md-4 d-flex flex-column mb-md-5 mb-5">
                            <label for="status"
                                   class="pb-2 fs-4 text-gray-600">{{ __('messages.withdraw.account_number').':' }}</label>
                            <span class="fs-4 text-gray-800">{{ $userBankDetails->account_number ?? 'N/A' }}</span>
                        </div>
                        <div class="col-md-4 d-flex flex-column mb-md-5 mb-5">
                            <label for="status"
                                   class="pb-2 fs-4 text-gray-600">{{ __('messages.withdraw.IFSC_number').':' }}</label>
                            <span class="fs-4 text-gray-800">{{ $userBankDetails->ifsc_number ?? 'N/A' }}</span>
                        </div>
                        <div class="col-md-4 d-flex flex-column mb-md-5 mb-5">
                            <label for="status"
                                   class="pb-2 fs-4 text-gray-600">{{ __('messages.withdraw.branch_name').':' }}</label>
                            <span class="fs-4 text-gray-800">{{ $userBankDetails->branch_name ?? 'N/A' }}</span>
                        </div>
                        <div class="col-md-4 d-flex flex-column mb-md-5 mb-5">
                            <label for="status"
                                   class="pb-2 fs-4 text-gray-600">{{ __('messages.withdraw.account_holder_name').':' }}</label>
                            <span class="fs-4 text-gray-800">{{ $userBankDetails->account_holder_name ?? 'N/A' }}</span>
                        </div>
                        <div class="col-md-4 d-flex flex-column mb-md-5 mb-5">
                            <label for="status"
                                   class="pb-2 fs-4 text-gray-600">{{ __('messages.withdraw.available_balance').':' }}</label>
                            <span class="fs-4 text-gray-800">{{ getCurrencyIcon().' '.numberFormatShort($userAvailableBalance) ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
