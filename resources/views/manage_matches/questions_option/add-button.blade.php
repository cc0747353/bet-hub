@php
	$question = \App\Models\Question::whereId($component->questionId);
@endphp
@if($question->value('result_declared') == true)
    <div class="d-flex align-items-center ">
        <h1 class="me-2 mt-2 text-black">Result is already declared</h1>
        <a class="btn btn-outline-primary float-end"
           href="{{ route('matches.questions',$question->first()->match_id) }}">{{ __('messages.common.back') }}</a>
    </div>
@else
    <div class="d-flex align-items-center">
        <a class="btn btn-outline-primary float-end"
           href="{{ route('matches.questions',$question->first()->match_id) }}">{{ __('messages.common.back') }}</a>
    </div>
    <div class="d-flex align-items-center mx-2">
        <a class="btn btn-warning make-loser-btn"
           href="javascript:void(0)"
           data-id="{{ $component->questionId }}">{{ __('messages.common.set_everyone_as_loser') }}</a>
    </div>
    <div class="d-flex align-items-center">
        <a class="btn btn-danger give-refund-btn"
           href="javascript:void(0)" data-id="{{ $component->questionId }}">{{ __('messages.common.refund') }}</a>
    </div>
    <div class="d-flex align-items-center mx-2">
        <a href="javascript:void(0)" id="addOptionModalBtn"
           class="btn btn-primary">{{ __('messages.question.add_option') }}</a>
    </div>
@endif
