@extends('front_settings.index')
@section('title')
    {{ __('messages.front_settings.home') }}
@endsection
@section('section')
    <div class="d-md-flex align-items-center justify-content-between mb-7">
        <h1 class="mb-0"> {{ __('messages.front_settings.home_details') }} </h1>
    </div>
    <div class="card">
        <div class="card-body">
            {{ Form::open(['route' => ['front.settings.update'], 'method' => 'post', 'files' => true, 'id' => 'updateHomeSetting']) }}
            {{ Form::hidden('sectionName', $sectionName) }}
            <div class="alert alert-danger d-none hide" id="aboutUsErrorsBox"></div>
            <div class="row">
                <!-- Home title Field -->
                <div class="form-group col-sm-12 mb-5">
                    {{ Form::label('home_title', __('messages.front_settings.title').':', ['class' => 'form-label']) }}
                    <span class="required"></span>
                    {{ Form::text('home_title', $frontSettings['home_title'], ['class' => 'form-control', 'required',
'id'=>'homeTitle' , 'placeholder' => __('messages.front_settings.title')]) }}
                </div>
                <!-- Home description Field -->
                <div class="form-group col-sm-12 mb-5">
                    {{ Form::label('home_description', __('messages.front_settings.description').':', ['class' => 'form-label']) }}
                    <span class="required"></span>
                    {{ Form::textarea('home_description', $frontSettings['home_description'], ['class' => 'form-control', 'required', 'rows' => 8,'id'=>'homeDes' , 'placeholder' => __('messages.front_settings.description')]) }}
                </div>

                <!-- Home Image Field -->
                <div class="form-group col-sm-6 mb-5">
                    {{ Form::label('home_bg_image', __('messages.front_settings.home_bg_image').':', ['class' => 'form-label']) }}
                                    <input type="file" id="homeBgImage" name="home_bg_image[]" multiple="multiple"
                                           class="image-upload form-control" accept="image/*"/>
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
