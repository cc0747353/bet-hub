@extends('layouts.app')
@section('title')
    {{ __('messages.common.option') }}
@endsection
@section('content')
   
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mb-3">
                <h3>{{ __('messages.question.options_for') }} - {{ $question->question }}</h3>
            </div>
        </div>
        <livewire:options-table questionId="{{ $question->id }}"/>
        @include('manage_matches.questions_option.create_modal')
        @include('manage_matches.questions_option.edit_modal')
    </div>
@endsection
