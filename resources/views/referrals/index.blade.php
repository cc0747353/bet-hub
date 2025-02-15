@extends('layouts.app')
@section('title')
    {{__('messages.referral.referrals')}}
@endsection
@section('header_toolbar')
    <div class="container-fluid mb-5">
        <h1> {{__('messages.referral.referrals')}}</h1>
    </div>
@endsection
@section('content')
    <div class="container-fluid">
        @include('layouts.errors')
        @include('flash::message')
        <div class="row">
            @foreach($referrals as $referral)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card mt-2 border-1">
                        <form action="{{ route('referrals.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="name" value="{{ $referral->name }}">
                            <h5 class="card-header border-1">
                                {{ $referral->name }}
                                <div class="form-check form-switch form-check-custom form-check-solid justify-content-center">
                                    <input class="form-check-input h-20px w-30px referrals-deposit-status" type="checkbox" id="referralsDepositStatus" data-id="{{ $referral->id }}" name="status" {{ $referral->status == 1 ? 'checked' : '' }}>
                                </div>
                            </h5>
                            <div class="p-5">
                                <div class="mt-2 mb-2">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th scope="col">{{__('messages.referral.level')}}</th>
                                            <th scope="col">{{__('messages.referral.commission')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($referral->referralLevel as $referralLevel)
                                            <tr>
                                                <td data-label="Level">{{__('messages.referral.level'). '#'}} {{ $referralLevel->level }}</td>
                                                <td data-label="Commission">{{ number_format((float)$referralLevel->commission, 2, '.', '')  }} %</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <hr>
                                <label class="text-warning"><small>{{ __('messages.referral.maximum_level')}}</small></label>
                                <div class="row mt-3 mb-5">
                                    <div class="col-md-6 mb-3">
                                        <input type="text" name="level"
                                               placeholder="{{__('messages.referral.how_many_level')}}"
                                               class="form-control referralLevelGenerate{{ $referral->id }}" min="0"
                                               id="levelValue" onkeyup="if (/\D/g.test(this.value)) { this.value = this.value.replace(/\D/g,'') } ">
                                    </div>
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-success" data-id="{{ $referral->id }}" id="generateReferralLevel">
                                            {{__('messages.referral.generate')}}
                                        </button>
                                    </div>
                                </div>
                                <div class="d-none referralLevelForm{{ $referral->id }}">
                                    <div class="form-group">
                                        <labelreferralLevelForm9842e60b-f898-4ab9-ae7e-59e13a13c049 class="text-success"> {{__('messages.referral.level_and_commission')}} :              <small>({{__('messages.referral.old_levels_will_remove_after_generate')}})</small>
                                        </labelreferralLevelForm9842e60b-f898-4ab9-ae7e-59e13a13c049>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="description">
                                                    <div class="row">
                                                        <div class="col-md-12 generateReferralLevelContainer{{$referral->id}}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" id="submitCommissionBtn" class="btn btn-primary btn-block my-3">{{ __('messages.submit') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
