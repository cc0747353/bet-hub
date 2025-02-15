@extends('layouts.app')
@section('title')
    {{ __('messages.matches.match_details') }}
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
                <div class="col-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="pb-2 fs-4 text-gray-600">{{ __('messages.matches.match_title') }}</label>
                                        <span class="mb-2 d-block">{{ $allMatch->match_title }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="pb-2 fs-4 text-gray-600">{{ __('messages.matches.league') }}</label>
                                        <span class="fs-4 text-gray-800 mb-2 d-block">{{ $allMatch->league->name }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div>
                                            <label class="pb-2 fs-4 text-gray-600">{{ __('messages.matches.teams') }}</label>
                                        </div>
                                        <div class="d-xl-flex align-items-center">
                                            <div class="d-flex flex-column me-3">
                                                <span class="mb-1 text-decoration-none fs-6">
                                                    {{$allMatch->team_a}}
                                                </span>
                                            </div>
                                            <div class="image image-circle image-mini me-2">
                                                <img src="{{$allMatch->team_a_image}}" alt="user" class="team_a-img">
                                            </div>
                                            <div class="d-flex flex-column me-3">
                                                <span class="mb-1 text-decoration-none fs-6">
                                                    {{$allMatch->team_b}}
                                                </span>
                                            </div>
                                            <div class="image image-circle image-mini">
                                                <img src="{{$allMatch->team_b_image}}" alt="user" class="team_a-img">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="pb-2 fs-4 text-gray-600">{{ __('messages.matches.match_start') }}</label>
                                        <span class="fs-4 text-gray-800 d-block">{{ Carbon\Carbon::parse($allMatch->match_start)->format('d M, h:i A') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="pb-2 fs-4 text-gray-600">{{ __('messages.matches.betting_start') }}</label>
                                        <span class="fs-4 text-gray-800 d-block">{{ Carbon\Carbon::parse($allMatch->start_from)->format('d M, h:i A') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="pb-2 fs-4 text-gray-600">{{ __('messages.matches.betting_end') }}</label>
                                        <span class="fs-4 text-gray-800 d-block">{{ Carbon\Carbon::parse($allMatch->end_at)->format('d M, h:i A') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                {{ Form::open(['method' => 'post','id' => 'teamScore', 'files' => 'true']) }}
                                <div class="col-md-12 mb-3">
                                    {{ Form::hidden('match_id', $allMatch->id, ['id' => 'matchId']) }}
                                    <label class="pb-2 fs-4 text-gray-600">{{ __('messages.matches.team_a_score') }}</label>
                                    <div class="d-flex">
                                        {{ Form::text('team_a', null, ['id'=> $allMatch->id,'class' => 'form-control me-2 team_a_score','onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")','placeholder' => __('messages.matches.team_a_score')]) }}
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="pb-2 fs-4 text-gray-600">{{ __('messages.matches.team_b_score') }}</label>
                                    <div class="d-flex">
                                        {{ Form::text('team_b', null, ['id'=> $allMatch->id,'class' => 'form-control me-2 team_b_score','onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")','placeholder' => __('messages.matches.team_b_score')]) }}
                                    </div>
                                </div>
                                <div>
                                    {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary', 'id' => 'team_score']) }}
                                </div>
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row my-5">
                <div class="d-md-flex align-items-center justify-content-between mb-5">
                    <h1 class="mb-0">{{ __('messages.matches.history') }}</h1>
                </div>
                <div class="col-12">
                    <livewire:match-score-table match-id="{{ $allMatch->id }}"/>
                </div>
            </div>
        </div>
    </div>
@endsection
