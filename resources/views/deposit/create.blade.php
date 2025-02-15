@extends('layouts.horizontal.app')
@section('title')
    {{__('messages.deposit.deposit')}}
@endsection
@section('header_toolbar')
    <div class="container-fluid">
        <div class="d-md-flex align-items-center justify-content-between mb-5">
            <h1 class="mb-0">@yield('title')</h1>
            <div class="text-end mt-4 mt-md-0">
                <a href="{{ route('user.deposit-transaction.index')}}"
                   class="btn btn-outline-primary">{{ __('messages.common.back') }}</a>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row d-flex justify-content-around">
            @if($allPaymentStatus->where('status', 1)->count() == 0)
                <div class="text-center mt-2">
                    <h3>
                        <span class="bg-info rounded-2 p-3 text-white">All Payment Gateways Method Are Off</span>
                    </h3>
                </div>
            @endif
            @foreach(\App\Models\PaymentGateway::PAYMENT_METHOD as $gateway => $value)
                @if($allPaymentStatus[$value]->status)
                    <div class="card col-md-3 mx-5 mt-5">
                        <div class="card-body">
                            <img src="{{asset(\App\Models\PaymentGateway::IMG_URL[$gateway])}}" alt
                                 class="img-fluid">
                            <div class="pt-5">
                                <a type="button" id="addAmountm" class="btn btn-primary w-100"
                                   href="{{route('user.get-deposit-amount',$allPaymentStatus[$value]->id)}}" data-turbo="false">{{ __('messages.deposit.deposit') }}</a>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@endsection

