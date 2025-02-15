@extends('layouts.app')
@section('title')
    {{__('messages.seo-tool.seo_tool')}}
@endsection
@section('header_toolbar')
    <div class="container-fluid mb-5">
        <h1> {{__('messages.seo-tool.seo_tool')}}</h1>
    </div>
@endsection
@section('content')
    <div class="container-fluid">
        @include('layouts.errors')
        @include('flash::message')
        <div class="card">
            {{ Form::open(['route' => 'seo-tools.update', 'files' => true, 'id'=>'SEOToolsForm','class'=>'form']) }}
            <div class="card-body">
                <div class="row">
                    <div class="row mb-6">
                        {{ Form::label('meta_keyword',__('messages.seo-tool.meta_keyword').':',['class'=>'col-lg-4 col-form-label required']) }}
                        <div class="col-lg-8">
                            {{ Form::text('meta_keyword',isset($seo->meta_keyword) ? $seo->meta_keyword : null, ['class' => 'form-control','placeholder'=>__('messages.seo-tool.meta_keyword'),'required']) }}
                        </div>
                    </div>
                    <div class="row mb-6">
                        {{ Form::label('meta_description',__('messages.seo-tool.meta_description').':',['class'=>'col-lg-4 col-form-label required']) }}
                        <div class="col-lg-8">
                            {{ Form::textarea('meta_description',isset($seo->meta_description) ? $seo->meta_description : null, ['class' => 'form-control','placeholder'=>__('messages.seo-tool.meta_description'),'required','rows'=>'4']) }}
                        </div>
                    </div>
                    <div class="row mb-6">
                        {{ Form::label('social_title',__('messages.seo-tool.social_title').':',['class'=>'col-lg-4 col-form-label required']) }}
                        <div class="col-lg-8">
                            {{ Form::text('social_title',isset($seo->social_title) ? $seo->social_title : null, ['class' => 'form-control','placeholder'=>__('messages.seo-tool.social_title'),'required']) }}
                        </div>
                    </div>
                    <div class="row mb-6">
                        {{ Form::label('social_description',__('messages.seo-tool.social_description').':',['class'=>'col-lg-4 col-form-label required']) }}
                        <div class="col-lg-8">
                            {{ Form::textarea('social_description',isset($seo->social_description) ? $seo->social_description : null, ['class' => 'form-control','placeholder'=>__('messages.seo-tool.social_description'),'required','rows'=>'4']) }}
                        </div>
                    </div>
                </div>
                {{ Form::submit(__('messages.common.save'),['class' => 'btn btn-primary']) }}
            </div>
            {{Form::close()}}
        </div>
    </div>
@endsection
