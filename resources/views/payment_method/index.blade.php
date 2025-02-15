@extends('layouts.app')
@section('title')
    {{__('messages.payment.payment_method')}}
@endsection
@section('header_toolbar')
    <div class="container-fluid mb-5">
        <h1>{{__('messages.payment.payment_method')}}</h1>
    </div>
@endsection
@section('content')
    <div class="container-fluid">
        @include('layouts.errors')
        @include('flash::message')
        <div class="card">
            {{ Form::open(['route' => 'payment-method.update', 'files' => true, 'id'=>'cookieForm','class'=>'form']) }}
            <div class="card-body">
                <div class="row mb-6">
                    <div class="table-responsive px-0">
                        <table>
                            <tbody class="d-flex flex-wrap">
                            @foreach($paymentGateways as $key => $paymentGateway)
                                <tr class="w-100 d-flex justify-content-between">
                                    <td class="p-2">
                                        <div class="form-check form-check-custom">
                                            <input class="form-check-input" type="checkbox" value="{{$key}}"
                                                   name="payment_gateway[]"
                                                   id="{{$key}}" {{in_array($paymentGateway, $selectedPaymentGateways) ?'checked':''}} />
                                            <label class="form-label" for="{{$key}}">
                                                {{$paymentGateway}}
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="d-flex pt-0 justify-content-start">
                    {{ Form::submit(__('messages.common.save'),['class' => 'btn btn-primary']) }}
                </div>
            </div>
        </div>
        {{Form::close()}}
    </div>
@endsection

