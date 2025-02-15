@extends('layouts.app')
@section('title')
    {{ __('messages.blog.add_blog') }}
@endsection
@section('header_toolbar')
    <div class="container-fluid">
        <div class="d-md-flex align-items-center justify-content-between mb-5">
            <h1 class="mb-0">@yield('title')</h1>
            <div class="text-end mt-4 mt-md-0">
                <a href="{{ route('blog.index') }}" class="btn btn-outline-primary">{{ __('messages.common.back') }}</a>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column">
            <div class="row">
                <div class="col-12">
                    @include('flash::message')
                    @include('layouts.errors')
                </div>
                {{ Form::open(['route' => 'blog.store', 'method' => 'post', 'id' => 'addBlogForm', 'files' => 'true']) }}
                <div class="section-body">
                    <div class="card mt-2">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="col-sm-12 mb-5">
                                        {{ Form::label('title',__('messages.blog.title').(':'), ['class' => 'form-label']) }}
                                        <span class="required"></span>
                                        {{ Form::text('title', null, ['id'=>'blogTitle','class' => 'form-control', 'placeholder' => __('messages.blog.title')]) }}
                                    </div>
                                    <div class="col-sm-12 mb-5">
                                        {{ Form::label('slug',__('messages.blog.slug').' :', ['class' => 'form-label required']) }}
                                        {{ Form::text('slug', null, ['class' => 'form-control','required', 'id'=>'blogSlug', 'placeholder' => __('messages.blog.slug')]) }}
                                        <input type="hidden" name="slug" id="slugHidden" value="">
                                    </div>
                                    <div class="col-sm-12 mb-5">
                                        {{ Form::label('tag',__('messages.blog.tag').(':'), ['class' => 'form-label']) }}
                                        <span class="required"></span>
                                        {{ Form::text('tag', null, ['id'=>'blogTag','class' => 'form-control', 'placeholder' => __('messages.blog.tag')]) }}
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <small class="text-info">{{ __('Choose minimum 900 * 500 size image for best view') }}</small>
                                    <div class="mb-3" io-image-input="true">
                                        <label for="exampleInputImage" class="form-label">{{__('messages.blog.image')}}
                                            :</label>
                                        <div class="d-block">
                                            <div class="image-picker">
                                                @php
                                                    $imageCss = 'style="background-image: url('.asset('images/avatar.png').')"';
                                                @endphp
                                                <div class="image previewImage blogImage"
                                                     id="exampleInputImage"{!! $imageCss !!}></div>
                                                <span class="picker-edit rounded-circle text-gray-500 fs-small"
                                                      data-bs-toggle="tooltip"
                                                      data-placement="top"
                                                      data-bs-original-title="{{ __('messages.blog.image') }}">
                                                <label>
                                                    <i class="fa-solid fa-pen" id="profileImageIcon"></i>
                                                    <input type="file" name="image" id="blogImage"
                                                           class="image-upload d-none"
                                                           accept="image/*"/>
                                                </label>
                                            </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 mb-20">
                                    {{ Form::label('description', __('messages.blog.description').(':'),['class' => 'form-label',]) }}
                                    <span class="required"></span>
                                    {{ Form::hidden('description', null, ['id' => 'blogDescription']) }}
                                    <div id="blogQuillData"></div>
                                </div>
                            </div>
                            <div class="mt-10">
                                {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary me-3']) }}
                            </div>
                        </div>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection
