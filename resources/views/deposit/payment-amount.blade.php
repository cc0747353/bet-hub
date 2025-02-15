@extends('layouts.horizontal.app')
@section('title')
    {{__('messages.deposit.deposit')}}
@endsection
@section('header_toolbar')
    <div class="container-fluid">
        <div class="d-md-flex align-items-center justify-content-between mb-5">
            <h1 class="mb-0">@yield('title')</h1>
            <div class="text-end mt-4 mt-md-0">
                <a href="{{ route('user.deposit-transaction.create')}}"
                   class="btn btn-outline-primary">{{ __('messages.common.back') }}</a>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="card">
            {{ Form::open(['id'=>'addPaymentForm']) }}
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="test">
                            @foreach($range_data as $range)
                                <p class="text-dark min_max" value="{{ $range['value'] }}">{{ ucwords(str_replace('_', ' ',$range['key'])) }} : {{ $range['value'] }}</p>
                            @endforeach
                        </div>
                        @if($minAndMax[0]['value'] == null)
                            <p class="text-dark" value="{{ $minAndMax[1]['value'] }}" id="taxValuePercent">Tax : {{ $minAndMax[1]['value'] }} %</p>
                        @else
                            <p class="text-dark" value="{{ $minAndMax[0]['value'] }}" id="taxValueFixed">Tax : {{ $minAndMax[0]['value'] }} $</p>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <div>
                            {{Form::hidden('payment_type', $allPaymentStatus->name,['id' => 'paymentType'])}}
                            {{ Form::label('amount',__('messages.deposit.amount').(':'), ['class' => 'form-label required']) }}
                            
                            {{ Form::text('amount', null, ['id'=>'amount','class' => 'form-control mb-3','required','onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")','placeholder' => __('messages.deposit.amount')]) }}
                        </div>
                        @if($allPaymentStatus->name == 'Manually')
                        <div>
                            {{Form::label('notes',__('messages.deposit.notes').(':'),['class' => 'form-label required'])}}
                            {{ Form::textarea('notes', null,['class' => 'form-control required mb-3' ,'placeholder' => __('messages.deposit.notes'),'required'])}}
                        </div>
                        <div>
                            {{ Form::label('attach',__('messages.deposit.attachment').(':'), ['class' => 'form-label required']) }}
                            <input type="file" class="form-control custom-file-input mb-3" id="customFile" name="attach" required>
                        </div>
                        @endif
                        <div>
                            {{ Form::label('totalAmount',__('messages.deposit.total_amount').(':'), ['class' => 'form-label']) }}
                            <span class="required"></span>
                            {{ Form::text('totalAmount', null, ['id'=>'totalAmount','class' => 'form-control','required','placeholder' => __('messages.deposit.total_amount'),'readonly']) }}
                        </div>
                    </div>

                </div>

            </div>
            <div class="card-footer pt-0">
                {{ Form::submit(__('messages.deposit.deposit'),  ['class' => 'btn btn-primary','id' => 'paypalInit']) }}
            </div>
            {{Form::close()}}
        </div>
@endsection
