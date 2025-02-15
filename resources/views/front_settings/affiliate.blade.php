@extends('front_settings.index')
@section('title')
    {{ __('messages.front_settings.affiliate') }}
@endsection
@section('section')
    <div class="d-md-flex align-items-center justify-content-between mb-7">
        <h1 class="mb-0"> {{ __('messages.front_settings.referral_details') }} </h1>
    </div>
    <div class="card">
        <div class="card-body">
            {{ Form::open(['route' => ['front.settings.update'], 'method' => 'post', 'files' => true, 'id' => 'updateAffiliateSetting']) }}
            {{ Form::hidden('sectionName', $sectionName) }}
            <div class="alert alert-danger d-none hide" id="aboutUsErrorsBox"></div>
            <div class="row">
                <div class="form-group col-sm-12 mb-5">
                    {{ Form::label('affiliate_title', __('messages.front_settings.title').':', ['class' => 'form-label']) }}
                    <span class="required"></span>
                    {{ Form::text('affiliate_title', isset($frontSettings) ? $frontSettings['affiliate_title'] : null, ['class' => 'form-control', 'required', 'id'=>'homeTitle' , 'placeholder' => __('messages.front_settings.title')]) }}
                </div>
                <div class="form-group col-sm-12 mb-5">
                    {{ Form::label('affiliate_description', __('messages.front_settings.description').':', ['class' => 'form-label']) }}
                    <span class="required"></span>
                    {{ Form::textarea('affiliate_description', isset($frontSettings) ? $frontSettings['affiliate_description'] : null, ['class' => 'form-control', 'required', 'rows' => 8,'id'=>'affiliateDes' , 'placeholder' => __('messages.front_settings.description')]) }}
                </div>
                <div class="form-group col-sm-6 mb-5">
                    {{ Form::label('affiliate_image', __('messages.front_settings.image').':', ['class' => 'form-label']) }}
                    <span class="required"></span>
                    <div class="image-input image-input-outline">
                        <div class="image-picker">
                            @php
                                $imageCss = 'style';
                                $background = 'background-image:';
                            @endphp
                            <div class="image previewImage" id="affiliatePreviewImage" {{$imageCss}}="{{$background}}
                            url('{{ $frontSettings['affiliate_image'] ?? asset('images/referal.png') }}')"></div>
                        <span class="picker-edit rounded-circle text-gray-500 fs-small" data-bs-toggle="tooltip"
                              data-placement="top"
                              data-bs-original-title="Change image"> 
                                  <label>
                                    <i class="fa-solid fa-pen" id="affiliateImage"></i> 
                                    <input type="file" id="affiliateImages" name="affiliate_image"
                                           class="image-upload d-none" accept="image/*"/>
                                </label>
                            </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="d-flex justify-content-start mt-5">
                {{ Form::submit(__('messages.common.save_changes'), ['class' => 'btn btn-primary']) }}
            </div>
        </div>
        {{ Form::close() }}
    </div>
    </div>

    <div class="d-md-flex align-items-center justify-content-between">
        <h1 class="my-5"> {{ __('messages.front_settings.start_details') }} </h1>
    </div>
    <div class="card">
        <div class="card-body">
            {{ Form::open(['route' => ['front.settings.update'], 'method' => 'post', 'files' => true, 'id' => 'updateStartSetting']) }}
            {{ Form::hidden('sectionName', $sectionName) }}
            <div class="alert alert-danger d-none hide" id="aboutUsErrorsBox"></div>
            <div class="row">
                <div class="form-group col-sm-12 mb-5">
                    {{ Form::label('start_title', __('messages.front_settings.start_title').':', ['class' => 'form-label']) }}
                    <span class="required"></span>
                    {{ Form::text('start_title', isset($frontSettings) ? $frontSettings['start_title'] : null, ['class' => 'form-control', 'required', 'id'=>'startTitle' , 'placeholder' => __('messages.front_settings.title')]) }}
                </div>
                <div class="form-group col-sm-12 mb-5">
                    {{ Form::label('start_description', __('messages.front_settings.start_description').':', ['class' => 'form-label']) }}
                    <span class="required"></span>
                    {{ Form::textarea('start_description', isset($frontSettings) ? $frontSettings['start_description'] : null, ['class' => 'form-control', 'required', 'rows' => 4,'id'=>'startDes' , 'placeholder' => __('messages.front_settings.description')]) }}
                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-6 mb-5">
                    {{ Form::label('step_1_title', __('messages.front_settings.step_1_title').':', ['class' => 'form-label']) }}
                    <span class="required"></span>
                    {{ Form::text('step_1_title', isset($frontSettings) ? $frontSettings['step_1_title'] : null, ['class' => 'form-control', 'required', 'id'=>'step1Title' , 'placeholder' => __('messages.front_settings.title')]) }}
                </div>
                <div class="form-group col-sm-6 mb-5">
                    {{ Form::label('step_1_description', __('messages.front_settings.step_1_description').':', ['class' => 'form-label']) }}
                    <span class="required"></span>
                    {{ Form::textarea('step_1_description', isset($frontSettings) ? $frontSettings['step_1_description'] : null, ['class' => 'form-control', 'required', 'rows' => 1, 'id'=>'step1Des' , 'placeholder' => __('messages.front_settings.description')]) }}
                </div>
                <div class="form-group col-sm-6 mb-5">
                    {{ Form::label('step_2_title', __('messages.front_settings.step_2_title').':', ['class' => 'form-label']) }}
                    <span class="required"></span>
                    {{ Form::text('step_2_title', isset($frontSettings) ? $frontSettings['step_2_title'] : null, ['class' => 'form-control', 'required', 'id'=>'step2Title' , 'placeholder' => __('messages.front_settings.title')]) }}
                </div>
                <div class="form-group col-sm-6 mb-5">
                    {{ Form::label('step_2_description', __('messages.front_settings.step_2_description').':', ['class' => 'form-label']) }}
                    <span class="required"></span>
                    {{ Form::textarea('step_2_description', isset($frontSettings) ? $frontSettings['step_2_description'] : null, ['class' => 'form-control', 'required', 'rows' => 1, 'id'=>'step2Des' , 'placeholder' => __('messages.front_settings.description')]) }}
                </div>
                <div class="form-group col-sm-6 mb-5">
                    {{ Form::label('step_3_title', __('messages.front_settings.step_3_title').':', ['class' => 'form-label']) }}
                    <span class="required"></span>
                    {{ Form::text('step_3_title', isset($frontSettings) ? $frontSettings['step_3_title'] : null, ['class' => 'form-control', 'required', 'id'=>'step3Title' , 'placeholder' => __('messages.front_settings.title')]) }}
                </div>
                <div class="form-group col-sm-6 mb-5">
                    {{ Form::label('step_3_description', __('messages.front_settings.step_3_description').':', ['class' => 'form-label']) }}
                    <span class="required"></span>
                    {{ Form::textarea('step_3_description', isset($frontSettings) ? $frontSettings['step_3_description'] : null, ['class' => 'form-control', 'required', 'rows' => 1, 'id'=>'step3Des' , 'placeholder' => __('messages.front_settings.description')]) }}
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="d-flex justify-content-start mt-5">
                    {{ Form::submit(__('messages.common.save_changes'), ['class' => 'btn btn-primary']) }}
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection
