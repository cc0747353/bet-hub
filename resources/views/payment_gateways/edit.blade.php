@extends('layouts.app')
@section('title')
    {{ __('messages.payment_gateways.edit_payment_gateways') }}
@endsection
@section('header_toolbar')
    <div class="container-fluid">
        <div class="d-md-flex align-items-center justify-content-between mb-5">
            <h1 class="mb-0">@yield('title')</h1>
            <div class="text-end mt-4 mt-md-0">
                <a href="{{ route('payment-gateways.index') }}"
                   class="btn btn-outline-primary">{{ __('messages.common.back') }}</a>
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
                {{ Form::model($gateways,['route' => 'payment-gateways.store', 'method' => 'post', 'id' => 'editPaymentGatewaysForm', 'files' => 'true']) }}
                <div class="section-body">
                    <div class="card mt-2">
                        <div class="card-body">
                            <div class="row">
                                @forelse($gateways as $gateway)
                                    @if(isset($gateway['key']) && $gateway['key'] == 'paypal_mode')
                                        <div class="col-sm-6">
                                            <div class="input-group mb-3">
                                                <label class="w-100 form-label">Select Paypal Mode</label>
                                                <div class="form-group d-flex">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="paypal_mode"
                                                               id="liveModeRadio" value="live" @if($gateway['value'] == 'live') checked="" @endif>
                                                        <label class="form-check-label" for="liveModeRadio">Live</label>
                                                    </div>
                                                    <div class="form-check ms-3">
                                                        <input class="form-check-input" type="radio" name="paypal_mode"
                                                               id="sandboxModeRadio" value="sandbox" @if($gateway['value'] == 'sandbox') checked="" @endif>
                                                        <label class="form-check-label"
                                                               for="sandboxModeRadio">Sandbox</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                    <div class="col-sm-6 mb-5">
                                        {{ Form::label('name',ucwords(str_replace('_', ' ',$gateway['key'])).(':'), ['class' => 'form-label']) }}
                                        <span class="required"></span>
                                        {{ Form::text($gateway['key'], $gateway['value'] ?? null, ['class'=>'credentials form-control','required','placeholder' => __(ucwords(str_replace('_', ' ',$gateway['key'])))]) }}
                                    </div>
                                    @endif
                                    @if($loop->last)
                                        <input type="hidden" value="{{ $gateway['payment_id'] }}" name="payment_id">
                                    @endif
								@empty
		                            <input type="hidden" id="manualPayment">
                                @endforelse
                            </div>
                            <div class="row">
                                @foreach($range_data as $range)
                                    <div class="col-sm-6">
                                        <div class="card border-primary mt-2">
                                            <div class="input-group mb-5">
                                                <label class="w-100 form-label">{{ ucwords(str_replace('_', ' ',$range['key'])) }}
                                                    <span class="text-danger">*</span></label>
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">$</div>
                                                </div>
                                                <input type="text" class="form-control rangeAmount" name="{{$range['key']}}"
                                                       value="{{ $range['value'] }}" placeholder="1" required="">
                                            </div>
                                        </div>
                                    </div>
                                    @if($loop->last)
                                        <input type="hidden" value="{{ $range['payment_id'] }}" name="payment_id">
                                    @endif
                                @endforeach
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="input-group mb-3">
                                        <label class="w-100 form-label">Select Charge Type</label>
                                        <div class="form-group d-flex">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="charge_type"
                                                       id="fixedChargeRadio" value="0">
                                                <label class="form-check-label" for="fixedChargeRadio">Fixed</label>
                                            </div>
                                            <div class="form-check ms-3">
                                                <input class="form-check-input" type="radio" name="charge_type"
                                                       id="percentChargeRadio" value="1">
                                                <label class="form-check-label" for="percentChargeRadio">Percent</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 fixedDiv">
                                    <div class="card border-primary mt-2">
                                        <div class="input-group">
                                            <label class="w-100 form-label">{{ ucwords(str_replace('_', ' ',$charge_data[0]['key'])) }}
                                                <span
                                                        class="text-danger">*</span></label>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">$</div>
                                            </div>
                                            <input type="text" class="form-control" placeholder="0"
                                                   name="{{ $charge_data[0]['key'] }}"
                                                   value="{{ $charge_data[0]['value'] }}" id="fixedCharge">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 percentDiv">
                                    <div class="card border-primary mt-2">
                                        <div class="input-group">
                                            <label class="w-100 form-label">{{ ucwords(str_replace('_', ' ',$charge_data[1]['key'])) }}
                                                <span
                                                        class="text-danger">*</span></label>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">%</div>
                                            </div>
                                            <input type="text" class="form-control" placeholder="0"
                                                   name="{{ $charge_data[1]['key'] }}"
                                                   value="{{ $charge_data[1]['value'] }}" id="percentCharge">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex mt-5">
                                {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary me-3 paymentGatewaysBtn']) }}
                                <a href="{{ route('payment-gateways.index') }}"
                                   class="btn btn-secondary me-2">{{__('messages.common.cancel')}}</a>
                            </div>
                        </div>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection
