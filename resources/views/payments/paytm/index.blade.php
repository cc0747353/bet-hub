@extends('layouts.auth')
@section('title')
    {{ __('Paytm') }}
@endsection
@section('content')
    <div class="d-flex flex-column flex-column-fluid align-items-center justify-content-center p-4">
        <div class="width-540">
            @include('flash::message')
            @include('layouts.errors')
        </div>
        <div class="bg-white rounded-15 shadow-md px-5 px-sm-7 py-10 mx-auto width-540">
            <h1 class="text-center mb-7">{{ __('messages.payment.payment_detail') }}</h1>
            <form action="{{ route('make.payment') }}" method="POST"
                  enctype="multipart/form-data">
                {!! csrf_field() !!}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <span>{{$errors->first()}}</span>
                    </div>
                @endif
                @if(session('success_msg'))
                    <div class="alert alert-success fade in alert-dismissible show">
                        {{ session('success_msg') }}
                    </div>
                @endif
                @if(session('error_msg'))
                    <div class="alert alert-danger fade in alert-dismissible show">
                        {{ session('error_msg') }}
                    </div>
                @endif

                <div class="mb-sm-7 mb-4">
                    <label for="email" class="form-label">
                        {{ __('messages.user.full_name') }}:<span class="required"></span>
                    </label>
                    <input type="text" class="form-control" name="name"
                           value="{{getLogInUser()->full_name}}" placeholder="Enter name" required
                           readonly>
                </div>

                <div class="mb-sm-7 mb-4">
                    <label for="email" class="form-label">
                        {{ __('messages.web.email') }}:<span class="required"></span>
                    </label>

                    <input type="email" class="form-control" name="email"
                           value="{{getLogInUser()->email}}" placeholder="Enter email" required
                           readonly>
                </div>

                <div class="mb-sm-7 mb-4">
                    <label for="email" class="form-label">
                        {{ __('messages.mobile_no') }}:<span class="required"></span>
                    </label>

                    <input type="text" class="form-control" name="mobile"
                           value="{{getLogInUser()->contact}}"
                           placeholder="Mobile No" required>
                </div>
                <input type="hidden" value="{{$amount}}" name="amount" id="amount">
                <h6>  {{ __('messages.payment.amount') }} : {{$amount}} Rs/-</h6>

                <div class="d-inline-flex">
                    <a href="{{route('paytm.failed')}}">
                        <button type="button" class="btn btn-light me-5">
                            {{ __('messages.common.cancel') }}
                        </button>
                    </a>
                    <button type="submit" class="btn btn-primary">{{ __('messages.submit') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
