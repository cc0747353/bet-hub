@extends('front_settings.index')
@section('title')
    {{ __('messages.front_settings.about_us') }}
@endsection
@section('section')
    <div class="d-md-flex align-items-center justify-content-between mb-7">
        <h1 class="mb-0"> {{ __('messages.front_settings.about_us_details') }} </h1>
    </div>
    <div class="card">
        <div class="card-body">
            {{ Form::open(['route' => ['front.settings.update'], 'method' => 'post', 'files' => true, 'id' => 'updateAboutUsSetting']) }}
            {{ Form::hidden('sectionName', $sectionName) }}
            <div class="alert alert-danger d-none hide" id="aboutUsErrorsBox"></div>
            <div class="row">
                <div class="form-group col-sm-12 mb-5">
                    {{ Form::label('about_us_title', __('messages.front_settings.title').':', ['class' => 'form-label']) }}
                    <span class="required"></span>
                    {{ Form::text('about_us_title', $frontSettings['about_us_title'], ['class' => 'form-control', 'required', 'id'=>'aboutUsTitle', 'placeholder' => __('messages.front_settings.title')]) }}
                </div>
                <div class="form-group col-sm-12 mb-5">
                    {{ Form::label('about_us_description', __('messages.front_settings.description').':', ['class' => 'form-label']) }}
                    <span class="required"></span>
                    {{ Form::textarea('about_us_description', $frontSettings['about_us_description'], ['class' => 'form-control', 'required', 'rows' => 8,'id'=>'aboutUsDes', 'placeholder' => __('messages.front_settings.description')]) }}
                </div>

                <div class="form-group col-sm-6 mb-5">
                    {{ Form::label('about_us_image', __('messages.front_settings.image').':', ['class' => 'form-label']) }}
                    <span class="required"></span>
                    <div class="image-input image-input-outline">
                        <?php
                        $imageCss = 'style';
                        $background = 'background-image:';
                        ?>
                        <div class="image-picker">
                            <div class="image previewImage" id="aboutUsPreviewImage" {{$imageCss}}="{{$background}}
                            url('{{ isset($frontSettings) ? $frontSettings['about_us_image'] : asset('images/about.png') }}
                            ')">
                        </div>
                        <span class="picker-edit rounded-circle text-gray-500 fs-small" data-bs-toggle="tooltip"
                              data-placement="top"
                              data-bs-original-title="Change image"> 
                                <label> 
                                    <i class="fa-solid fa-pen" id="aboutUsImage"></i> 
                                    <input type="file" id="aboutUsImages" name="about_us_image"
                                           class="image-upload d-none" accept="image/*"/>
                                </label> 
                            </span>
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
    </div></div>
    
    <div class="d-md-flex align-items-center justify-content-between">
        <h1 class="my-5"> {{ __('messages.front_settings.feature') }} </h1>
    </div>
    <div class="card">
        <div class="card-body">
            {{ Form::open(['route' => ['front.settings.update'], 'method' => 'post', 'files' => true, 'id' => 'updateFeatureSetting']) }}
            {{ Form::hidden('sectionName', $sectionName) }}
            <div class="alert alert-danger d-none hide" id="FeatureErrorsBox"></div>
            <div class="row">
                <div class="form-group col-sm-12 mb-5">
                    {{ Form::label('feature_title', __('messages.front_settings.feature_title').':', ['class' => 'form-label']) }}
                    <span class="required"></span>
                    {{ Form::text('feature_title', isset($frontSettings) ? $frontSettings['feature_title'] : null, ['class' => 'form-control', 'required', 'id'=>'startTitle' , 'placeholder' => __('messages.front_settings.title')]) }}
                </div>
                <div class="form-group col-sm-12 mb-5">
                    {{ Form::label('feature_description', __('messages.front_settings.feature_description').':', ['class' => 'form-label']) }}
                    <span class="required"></span>
                    {{ Form::textarea('feature_description', isset($frontSettings) ? $frontSettings['feature_description'] : null, ['class' => 'form-control', 'required', 'rows' => 2,'id'=>'startDes' , 'placeholder' => __('messages.front_settings.description')]) }}
                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-6 mb-5">
                    {{ Form::label('feature_1_title', __('messages.front_settings.feature_1_title').':', ['class' => 'form-label']) }}
                    <span class="required"></span>
                    {{ Form::text('feature_1_title', isset($frontSettings) ? $frontSettings['feature_1_title'] : null, ['class' => 'form-control', 'required', 'id'=>'step1Title' , 'placeholder' => __('messages.front_settings.title')]) }}
                </div>
                <div class="form-group col-sm-6 mb-5">
                    {{ Form::label('feature_1_description', __('messages.front_settings.feature_1_description').':', ['class' => 'form-label']) }}
                    <span class="required"></span>
                    {{ Form::textarea('feature_1_description', isset($frontSettings) ? $frontSettings['feature_1_description'] : null, ['class' => 'form-control', 'required', 'rows' => 1, 'id'=>'step1Des' , 'placeholder' => __('messages.front_settings.description')]) }}
                </div>
                <div class="form-group col-sm-6 mb-5">
                    {{ Form::label('feature_2_title', __('messages.front_settings.feature_2_title').':', ['class' => 'form-label']) }}
                    <span class="required"></span>
                    {{ Form::text('feature_2_title', isset($frontSettings) ? $frontSettings['feature_2_title'] : null, ['class' => 'form-control', 'required', 'id'=>'step2Title' , 'placeholder' => __('messages.front_settings.title')]) }}
                </div>
                <div class="form-group col-sm-6 mb-5">
                    {{ Form::label('feature_2_description', __('messages.front_settings.feature_2_description').':', ['class' => 'form-label']) }}
                    <span class="required"></span>
                    {{ Form::textarea('feature_2_description', isset($frontSettings) ? $frontSettings['feature_2_description'] : null, ['class' => 'form-control', 'required', 'rows' => 1, 'id'=>'step2Des' , 'placeholder' => __('messages.front_settings.description')]) }}
                </div>
                <div class="form-group col-sm-6 mb-5">
                    {{ Form::label('feature_3_title', __('messages.front_settings.feature_3_title').':', ['class' => 'form-label']) }}
                    <span class="required"></span>
                    {{ Form::text('feature_3_title', isset($frontSettings) ? $frontSettings['feature_3_title'] : null, ['class' => 'form-control', 'required', 'id'=>'step3Title' , 'placeholder' => __('messages.front_settings.title')]) }}
                </div>
                <div class="form-group col-sm-6 mb-5">
                    {{ Form::label('feature_3_description', __('messages.front_settings.feature_3_description').':', ['class' => 'form-label']) }}
                    <span class="required"></span>
                    {{ Form::textarea('feature_3_description', isset($frontSettings) ? $frontSettings['feature_3_description'] : null, ['class' => 'form-control', 'required', 'rows' => 1, 'id'=>'step3Des' , 'placeholder' => __('messages.front_settings.description')]) }}
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
