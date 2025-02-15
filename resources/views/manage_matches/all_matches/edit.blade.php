@extends('layouts.app')
@section('title')
    {{ __('messages.matches.edit_match') }}
@endsection
@section('header_toolbar')
    <div class="container-fluid">
        <div class="d-md-flex align-items-center justify-content-between mb-5">
            <h1 class="mb-0">@yield('title')</h1>
            <div class="text-end mt-4 mt-md-0">
                <a href="{{ route('all-matches.index') }}"
                   class="btn btn-outline-primary">{{ __('messages.common.back') }}</a>
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
                {{ Form::model($allMatch, ['route' => ['all-matches.update', $allMatch->id], 'method' => 'put', 'id' => 'editBlogForm', 'files' => 'true']) }}
                <div class="section-body">
                    <div class="card mt-2">
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-6 mb-4">
                                    {{ Form::label('league_id', __('messages.matches.league').(':'), ['class' => 'form-label']) }}
                                    <span class="required"></span>
                                    {{ Form::select('league_id', $league, isset($allMatch) ? $allMatch->league_id : '', [
                                       'class' => 'form-select', 'aria-label'=> __('messages.matches.select_league'),
                                       'data-control'=>'select2', 'placeholder' => __('messages.matches.select_league')]) }}
                                </div>
                                <div class="form-group col-md-6 mb-5">
                                    {{ Form::label('match_title', __('messages.matches.match_title').(':'), ['class' => 'form-label']) }}
                                    <span class="required"></span>
                                    {{ Form::text('match_title', isset($allMatch) ? $allMatch->match_title : null, ['id'=>'matchTitle','class' => 'form-control','required' ,'placeholder' => __('messages.matches.match_title')]) }}
                                </div>
                                <div class="form-group col-md-4 mb-4">
                                    {{ Form::label('team_a', __('messages.matches.team_a').(':'), ['class' => 'form-label']) }}
                                    <span class="required"></span>
                                    {{ Form::text('team_a', isset($allMatch) ? $allMatch->team_a : null, ['id'=>'team_a','class' => 'form-control','required' ,'placeholder' => __('messages.matches.team_a')]) }}
                                </div>
                                <div class="mb-5 form-group col-md-2 text-center" io-image-input="true">
                                    <label for="exampleInputImage" class="form-label">{{ __('messages.matches.team_a_image') }}</label>
                                    <div class="d-block">
                                        <div class="image-picker">
	                                            @php $imageCss = 'style' @endphp
                                            <div class="image previewImage" id="exampleInputImage" {{ $imageCss }}="background-image: url('{{ (!empty($allMatch['team_a_image']) ? $allMatch['team_a_image'] : asset('images/avatar.png')) }}')"></div>
                                            <span class="picker-edit rounded-circle text-gray-500 fs-small"
                                                  title="edit">
                                                <label>
                                                    <i class="fa-solid fa-pen" id="profileImageIcon"></i>
                                                    <input type="file" id="image" name="team_a_image"
                                                           class="image-upload d-none" accept="image/*"/>
                                               </label>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-4 mb-4">
                                    {{ Form::label('team_b', __('messages.matches.team_b').(':'), ['class' => 'form-label']) }}
                                    <span class="required"></span>
                                    {{ Form::text('team_b', isset($allMatch) ? $allMatch->team_b : null, ['id'=>'team_b','class' => 'form-control','required' ,'placeholder' => __('messages.matches.team_b')]) }}
                                </div>
                                <div class="mb-5 form-group col-md-2 text-center" io-image-input="true">
                                    <label for="exampleInputImage" class="form-label">{{ __('messages.matches.team_b_image') }}</label>
                                    <div class="d-block">
                                        <div class="image-picker">
	                                        @php $imageCss = 'style' @endphp
	                                        <div class="image previewImage" id="exampleInputImage" {{ $imageCss }}="background-image: url('{{ (!empty($allMatch['team_b_image']) ? $allMatch['team_b_image'] : asset('images/avatar.png')) }}')"></div>
                                            <span class="picker-edit rounded-circle text-gray-500 fs-small"
                                                  title="edit">
                                                <label>
                                                <i class="fa-solid fa-pen" id="profileImageIcon"></i>
                                                    <input type="file" id="image" name="team_b_image"
                                                           class="image-upload d-none" accept="image/*"/>
                                                </label>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-4 mb-4">
                                    {{ Form::label('match_start', __('messages.matches.match_start_time').':', ['class' => 'form-label required']) }}
                                    {{ Form::text('match_start', isset($allMatch) ? $allMatch->match_start : null, ['class' => 'form-control match-start bg-white', 'id' => 'matchStart','placeholder' => __('messages.matches.match_start_time')]) }}
                                </div>
                                <div class="form-group col-md-4 mb-4">
                                    {{ Form::label('start_from', __('messages.matches.betting_start_from').':', ['class' => 'form-label required']) }}
                                    {{ Form::text('start_from', isset($allMatch) ? $allMatch->start_from : null, ['class' => 'form-control start-from bg-white', 'id' => 'startFrom','placeholder' => __('messages.matches.betting_start_from')]) }}
                                </div>
                                <div class="form-group col-md-4 mb-4">
                                    {{ Form::label('end_at', __('messages.matches.betting_end_at').':', ['class' => 'form-label required']) }}
                                    {{ Form::text('end_at', isset($allMatch) ? $allMatch->end_at : null, ['class' => 'form-control end-at bg-white', 'id' => 'endAt','placeholder' => __('messages.matches.betting_end_at')]) }}
                                </div>
                                <div class="form-group col-md-6">
                                    {{ Form::label('is_locked', __('messages.question.is_locked').(':'),['class' => 'form-label']) }}
                                    <div class="form-check form-switch">
                                        <input class="form-check-input h-20px w-30px" type="checkbox"
                                               id="lockedStatus" name="is_locked" value="1" {{  isset($allMatch) && $allMatch->is_locked ? 'checked' : '' }}>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-5">
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
