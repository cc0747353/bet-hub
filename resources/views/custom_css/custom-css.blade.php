@extends('layouts.app')
@section('title')
    {{__('messages.common.custom_css')}}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 mb-5">
                <div class="card bl-5-primary">
                    <div class="card-body p-5">
                        <p class="font-weight-bold text-primary">{{ __('messages.custom_css.from_this_page') }}</p>
                        <p class="font-weight-bold text-warning">{{ __('messages.custom_css.please_do_not_change') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-12 ">
                @include('layouts.errors')
                @include('flash::message')
            </div>
            <div class="col-md-12 mt-5">
                <div class="card">
                    <div class="card-header border-bottom border-secondary">
                        <h2>{{ __('messages.custom_css.write_custom_css') }}</h2>
                    </div>
                    <form action="{{ route('custom-css.update') }}" method="post" id="customCssForm">
                        @csrf
                        <div class="card-body">
                            <div class="form-group custom-css">
                                <textarea id="editor"
                                          name="css_content">{{ \file_get_contents(asset("assets/css/custom.css")) }}</textarea>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary btn-block">{{ __('messages.submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
