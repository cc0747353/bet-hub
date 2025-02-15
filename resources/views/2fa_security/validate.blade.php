@extends('layouts.auth')
@section('title')
    {{__('Two Step Verification')}}
@endsection
@section('content')
    <div class="d-flex flex-column flex-column-fluid align-items-center mt-12 p-4">
        <div class="col-12 text-center">
            <a href="{{ route('login') }}" class="image mb-7 mb-sm-10">
                <img alt="Logo" src="{{ asset(getAppLogo()) }}" class="img-fluid loginImg">
            </a>
        </div>
        <div class="width-540">
            @include('layouts.errors')
        </div>
        <div class="bg-white rounded-15 shadow-md width-540 px-5 px-sm-7 py-10 mx-auto mx-auto">
            <h1 class="text-center mb-7">{{__('messages.security.two_step_verification')}}</h1>
            <div class="fs-4 mb-4 text-center mb-5">{{ __('messages.security.please_confirm') }}</div>
            <form class="form w-100" method="POST" action="{{ route('user.token.validation') }}">
                @csrf
                <div class="row">
                    <div class="mb-4">
                        <label class="form-label" for="email">{{ __('messages.security.one_time_password') }}</label>
                        <input type="text" class="form-control form-control-solid" placeholder="{{ __('messages.security.one_time_password') }}" name="totp" autofocus required autocomplete="off" onkeyup='if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")'/>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Submit Field -->
                        <div class="form-group col-sm-12 d-flex text-start align-items-center">
                            <button type="submit" class="btn btn-primary">
                              {{ __('Validate') }}
                            </button>
    
                            <a href="{{ route('login') }}"
                               class="btn btn-secondary my-0 ms-5 me-0">{{__('messages.common.cancel')}}</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endsection
