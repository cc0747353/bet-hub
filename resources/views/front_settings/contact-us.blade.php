@extends('front_settings.index')
@section('title')
    {{ __('messages.front_settings.contact_us') }}
@endsection
@section('section')
    <div class="d-md-flex align-items-center justify-content-between mb-7">
        <h1 class="mb-0"> {{ __('messages.front_settings.contact_us_details') }} </h1>
    </div>
    <div class="card">
        <div class="card-body">
            {{ Form::open(['route' => ['front.settings.update'], 'method' => 'post', 'files' => true, 'id' => 'updateContactUsSetting']) }}
            {{ Form::hidden('sectionName', $sectionName) }}
            <div class="alert alert-danger d-none hide" id="aboutUsErrorsBox"></div>
            <div class="row">
                <!-- About Us title Field -->
                <div class="form-group col-sm-12 mb-5">
                    {{ Form::label('contact_us_title', __('messages.front_settings.title').':', ['class' => 'form-label']) }}
                    <span class="required"></span>
                    {{ Form::text('contact_us_title', $frontSettings['contact_us_title'] ?? null, ['class' => 'form-control', 'required', 'id'=>'contactUsTitle', 'placeholder' => __('messages.front_settings.title')]) }}
                </div>
                <!-- About Us description Field -->
                <div class="form-group col-sm-12 mb-5">
                    {{ Form::label('contact_us_description', __('messages.front_settings.description').':', ['class' => 'form-label']) }}
                    <span class="required"></span>
                    {{ Form::textarea('contact_us_description', $frontSettings['contact_us_description'] ?? null, ['class' => 'form-control', 'required', 'rows' => 8,'id'=>'contactUsDes', 'placeholder' => __('messages.front_settings.description')]) }}
                </div>

                <!-- About US Image Field -->
                <div class="form-group col-sm-6 mb-5">
                    {{ Form::label('contact_us_image', __('messages.front_settings.image').':', ['class' => 'form-label']) }}
                    <span class="required"></span>
                    <div class="image-input image-input-outline">
                        <?php
                        $imageCss = 'style';
                        $background = 'background-image:';
                        ?>
                        <div class="image-picker">
                            <div class="image previewImage" id="contactUsPreviewImage" {{$imageCss}}="{{$background}}
                            url('{{ $frontSettings['contact_us_image'] ?? asset('images/contact.png') }}')"></div>
                            <span class="picker-edit rounded-circle text-gray-500 fs-small" data-bs-toggle="tooltip"
                                  data-placement="top"
                                  data-bs-original-title="Change image">
                                    <label> 
                                        <i class="fa-solid fa-pen" id="contactUsImage"></i>
                                        <input type="file" id="contactUsImages" name="contact_us_image"
                                               class="image-upload d-none" accept="image/*"/>
                                    </label>
                            </span>
                        </div>
                    </div>
                </div>
            <div class="clearfix"></div>
            <div class="row">
                <!-- Submit Field -->
                <div class="d-flex justify-content-start mt-5">
                    {{ Form::submit(__('messages.common.save_changes'), ['class' => 'btn btn-primary']) }}
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection
