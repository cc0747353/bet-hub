@extends('layouts.app')
@section('title')
    {{__('messages.setting.cookies')}}
@endsection
@section('content')
    <div class="container-fluid">
        @include('layouts.errors')
        @include('flash::message')
        <div class="card">
            {{ Form::open(['route' => 'cookie-update', 'files' => true, 'id'=>'cookieForm','class'=>'form']) }}
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="mb-5">
                            <label for="description" class="form-label">{{ __('messages.setting.description') }}:</label>
                            <textarea class="form-control" placeholder="{{ __('messages.common.description') }}"
                                      id="cookieDescription" rows="5" name="cookie_description"
                                      cols="50" maxlength="800"
                                      style="height: 256px;">{{ $settingData['cookie_description'] }}</textarea>
                        </div>
                    </div>
                    <div class="col-lg-8 mb-3">
                        {{ Form::label('policy_link',__('messages.setting.policy_link').(':'), ['class' => 'form-label']) }}
                        <span class="required"></span>
                        {{ Form::text('policy_link', $settingData['policy_link'], ['id'=>'policyLink','class' => 'form-control','required','placeholder' => __('messages.setting.policy_link')]) }}
                    </div>
                    <div class="col-lg-4">
                        {{ Form::label('status', __('messages.setting.status').(':'),['class' => 'form-label']) }}
                        <div class="form-check form-switch">
                            <input class="form-check-input h-20px w-30px" type="checkbox"
                                   id="cookieIs"
                                   name="cookie_is" {{ ( $settingData['cookie_is'] == 1) ? 'checked' : '' }}>
                        </div>
                    </div>
                </div>
                <div class="d-flex pt-0 justify-content-start mt-5">
                    {{ Form::submit(__('messages.common.save'),['class' => 'btn btn-primary']) }}
                </div>
            </div>
            {{Form::close()}}
        </div>
    </div>
@endsection

