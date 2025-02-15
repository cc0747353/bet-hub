@extends('layouts.app')
@section('title')
    {{__('messages.setting.setting')}}
@endsection
@section('header_toolbar')
    <div class="container-fluid mb-5">
        <h1>{{__('messages.setting.setting')}}</h1>
    </div>
@endsection
@section('content')
    <div class="container-fluid">
        @include('layouts.errors')
        @include('flash::message')
        <div class="card">
            {{ Form::open(['route' => 'settings.update', 'files' => true, 'id'=>'SEOToolsForm','class'=>'form']) }}
            <div class="card-body">
                <div class="row mb-5">
                    <div class="col-lg-4">
                        {{ Form::label('app_name',__('messages.setting.app_name').':',['class'=>'form-label required']) }}
                    </div>
                    <div class="col-lg-8">
                        {{ Form::text('app_name', $setting['app_name'], ['class' => 'form-control','placeholder'=>__('messages.setting.app_name'),'required']) }}
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-lg-4">
                        {{ Form::label('contact_no',__('messages.setting.contact_number').':',['class'=>'form-label required']) }}
                    </div>
                    <div class="col-lg-8">
                        {{ Form::tel('contact_no', isset($setting) && $setting['contact_no'] ? '+'.$setting['region_code'].$setting['contact_no'] : null, ['class' => 'form-control w-100', 'placeholder' => __('messages.setting.contact_number'), 'onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")','id'=>'phoneNumber']) }}
                        {{ Form::hidden('region_code',isset($setting) ? $setting['region_code'] : null,['id'=>'prefix_code']) }}
                        <span id="valid-msg"
                              class="text-success d-none fw-400 fs-small mt-2">{{ __('messages.valid_number') }}</span>
                        <span id="error-msg"
                              class="text-danger d-none fw-400 fs-small mt-2">{{ __('messages.invalid_number') }}</span>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-lg-4">
                        {{ Form::label('email',__('messages.user.email').':',['class'=>'form-label required']) }}
                    </div>
                    <div class="col-lg-8">
                        {{ Form::email('email', $setting['email'], ['class' => 'form-control','placeholder'=>__('messages.user.email'),'required']) }}
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-lg-4">
                        {{ Form::label('address',__('messages.setting.address').':',['class'=>'form-label required']) }}
                    </div>
                    <div class="col-lg-8">
                        {{ Form::text('address', $setting['address'] ?? null, ['class' => 'form-control','placeholder'=>__('messages.setting.address'),'required']) }}
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-lg-4">
                        {{ Form::label('copy_right_text',__('messages.setting.copy_right_text').':',['class'=>'form-label required ']) }}
                    </div>
                    <div class="col-lg-8">
                        {{ Form::text('copy_right_text', $setting['copy_right_text']??null, ['class' => 'form-control','placeholder'=>__('messages.setting.copy_right_text'),'required']) }}
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-lg-4">
                        {{ Form::label('min_bet',__('messages.setting.min_bet').':',['class'=>'form-label required ']) }}
                    </div>
                    <div class="col-lg-8">
                        {{ Form::text('min_bet', $setting['min_bet']??null, ['class' => 'form-control','placeholder'=>__('messages.setting.copy_right_text'),'required']) }}
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-lg-4">
                        {{ Form::label('max_bet',__('messages.setting.max_bet').':',['class'=>'form-label required ']) }}
                    </div>
                    <div class="col-lg-8">
                        {{ Form::text('max_bet', $setting['max_bet']??null, ['class' => 'form-control','placeholder'=>__('messages.setting.copy_right_text'),'required']) }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <label for="exampleInputImage" class="form-label">{{__('messages.setting.logo')}}: </label>
                        <span data-bs-toggle="tooltip"
                              data-placement="top"
                              data-bs-original-title="Best resolution for this logo will be 90x60.">
                                <i class="fas fa-question-circle ml-1 general-question-mark"></i>
                        </span>
                    </div>
                    <div class="col-lg-8">
                        <div class="mb-3" io-image-input="true">
                            <div class="d-block">
                                <div class="image-picker">
                                    @php
                                        $imageCss = 'style="background-image: url('.(!empty(asset($setting['logo'])) ? asset($setting['logo']) : asset('images/logo.png')).')"';
                                    @endphp
                                    <div class="image previewImage" id="exampleInputImage"{!! $imageCss !!}></div>
                                    <span class="picker-edit rounded-circle text-gray-500 fs-small"
                                          data-bs-toggle="tooltip"
                                          data-placement="top"
                                          data-bs-original-title="{{__('messages.setting.change_logo')}}">
                                        <label> 
                                            <i class="fa-solid fa-pen" id="profileImageIcon"></i> 
                                            <input type="file" name="logo" class="image-upload d-none"
                                                   accept="image/*"/> 
                                        </label> 
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-lg-4">
                        <label for="exampleInputImage" class="form-label">{{__('messages.setting.favicon')}}: </label>
                        <span data-bs-toggle="tooltip"
                              data-placement="top"
                              data-bs-original-title="Best resolution for this favicon will be 32X32.">
                                <i class="fas fa-question-circle ml-1 general-question-mark"></i>
                        </span>
                    </div>
                    <div class="col-lg-8">
                        <div class="" io-image-input="true">
                            <div class="d-block">
                                <div class="image-picker">
                                    @php
                                        $imageCss = 'style="background-image: url('.(!empty(asset($setting['favicon'])) ? asset($setting['favicon']) : asset('images/Infy-hms-logo.png')).')"';
                                    @endphp
                                    <div class="image previewImage w-60px h-60px" id="exampleInputImage"{!! $imageCss !!}></div>
                                    <span class="picker-edit rounded-circle text-gray-500 fs-small"
                                          data-bs-toggle="tooltip"
                                          data-placement="top"
                                          data-bs-original-title="{{__('messages.user.change_favicon')}}">
                                        <label> 
                                            <i class="fa-solid fa-pen" id="profileImageIcon"></i> 
                                            <input type="file" name="favicon" class="image-upload d-none"
                                                   accept="image/*"/> 
                                        </label> 
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-lg-4">
                        {{ Form::label('clear_cache',__('messages.setting.clear_cache').':',['class'=>'form-label']) }}
                    </div>
                    <div class="form-group col-sm-2">
                        <a class="btn btn-primary" data-turbo="false" aria-current="page"
                           href="{{ route('clear-cache') }}">
                            <span>{{ __('messages.setting.clear_cache') }}</span>
                        </a>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-lg-4">
                        {{ Form::label('currency',__('messages.setting.currency').':',['class'=>'col-lg-4 form-label']) }}
                    </div>
                    <div class="col-lg-8">
                        {{ Form::select('currency', $currencies, $setting['currency'], [
                                    'class' => 'form-select', 'aria-label'=>"Select a Currency",
                                    'data-control'=>'select2','placeholder' => __('messages.setting.currency')]) }}
                    </div>
                </div>
                <div class="d-flex pt-0 justify-content-start">
                    {{ Form::submit(__('messages.common.save'),['class' => 'btn btn-primary']) }}
                </div>
                {{Form::close()}}
                <div class="card-header px-0 border-1">
                    <div class="d-flex align-items-center justify-content-center">
                        <h3 class="m-0">{{__('messages.google_captcha.google_captcha')}}</h3>
                    </div>
                </div>
                {{ Form::open(['route' => 'settings.update', 'files' => true, 'id'=>'google_captcha_form','class'=>'form']) }}
                <div class="row my-5">
                    <div class="col-lg-4">
                        {{ Form::label('show_captcha',__('messages.google_captcha.show_captcha').':',
                                     ['class'=>'form-label fs-6']) }}
                    </div>
                    <div class="col-lg-8">
                        <div class="form-check form-switch form-check-custom form-check-solid">
                            <input class="form-check-input w-30px h-20px is-active"
                                   name="show_captcha" id="show_captcha"
                                   type="checkbox" value="1"
                                    {{ $setting['show_captcha'] ? 'checked' : ''}} >
                        </div>
                    </div>
                </div>
                <div class="row mt-5 mb-5 captchaOptions {{$setting['show_captcha'] ? '' : 'd-none'}}">
                    <div class="col-lg-4">
                        {{ Form::label('site_key',__('messages.google_captcha.site_key').':',
                                 ['class'=>'form-label required fs-6']) }}
                    </div>
                    <div class="col-lg-8">
                        {{ Form::text('site_key', $setting['site_key']??null, ['class' => 'form-control','placeholder'=>__('messages.google_captcha.site_key')]) }}
                    </div>
                </div>
                <div class="row mb-5 captchaOptions {{$setting['show_captcha'] ? '' : 'd-none'}}">
                    <div class="col-lg-4">
                        {{ Form::label('secret_key',__('messages.google_captcha.secret_key').':',
                                ['class'=>'col-lg-4 form-label required fs-6']) }}
                    </div>
                    <div class="col-lg-8">
                        {{ Form::text('secret_key', $setting['secret_key']??null, ['class' => 'form-control','placeholder'=>__('messages.google_captcha.secret_key')]) }}
                    </div>
                </div>
                <div class="d-flex justify-content-start mt-5">
                    {{ Form::submit(__('messages.google_captcha.save_changes'),['class' => 'btn btn-primary']) }}
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection

