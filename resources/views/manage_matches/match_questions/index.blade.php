@extends('layouts.app')
@section('title')
    {{ __('messages.common.question') }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mb-3">
                <h3>{{ __('messages.matches.questions_for') }} - {{ $match->match_title }}</h3>
            </div>
        </div>
        <livewire:questions-table matchId="{{$match->id}}"/>
        @include('manage_matches.match_questions.create_modal')
        @include('manage_matches.match_questions.edit_modal')
    </div>
@endsection
