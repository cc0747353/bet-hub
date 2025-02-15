@extends('front.layout.app')
@section('title')
    {{ __('messages.front.match_details') }}
@endsection
@section('content')
    <div class="match-details-page bg-dark ">
        <section class="categories-section pt-40 pb-60">
            <div class="container-fluid px-60">
                <div class="row">
                    @include('front.left-sidebar')
                    <input type="hidden" value="{{getTotalBalance()}}" id="userTotalBalance">
                    <div class="col-xxl-8 col-lg-6 pt-40">
                        <div class="categories-slider-section position-relative br-10 mb-40">
                            <div class="categories-box">
                                <div class="heading mb-3 d-flex">
                                    <h4 class="text-white mb-0">{{ $matchDetails->league->category->name }}</h4>
                                    <h4 class="text-white mb-0 ms-3">{{ $matchDetails->league->name }}</h4>
                                </div>
                                <div class="categoires-details p-xl-4 p-3 mb-40">
                                    <div class="row mx-sm-0 mx-2">
                                        <div class="col-sm-4 border-right pb-sm-0 pb-3">
                                            <div class="row justify-content-between align-items-center">
                                                <div class="col-xxl-4 col-sm-7 col-6 text-center">
                                                    <div class="flag mx-auto mb-2">
                                                        <img src="{{ $matchDetails->team_a_image }}" class="w-100">
                                                    </div>
                                                    <h3 class="fs-20 fw-5 text-white mb-0">{{ $matchDetails->team_a }}</h3>
                                                </div>
                                                <div class="col-xxl-4 col-sm-5 col-6 text-center">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 border-right pb-sm-0 pb-3">
                                            <div class="row justify-content-center align-items-center">
                                                <div class="col-xxl-12 col-sm-5 col-6 text-center">
                                                    <p class="fs-18 text-gray-100 mb-0">Match Start</p>
                                                    @if(Carbon\Carbon::parse($matchDetails->match_start)->isToday())
                                                        <p class="fs-20 text-white mb-0 fw-5"> {{ Carbon\Carbon::parse($matchDetails->match_start)->format('h:i A') }}</p>
                                                    @elseif(Carbon\Carbon::parse($matchDetails->match_start)->isTomorrow())
                                                        <p class="fs-20 text-white mb-0 fw-5">Tomorrow {{ Carbon\Carbon::parse($matchDetails->match_start)->format('h:i A') }}</p>
                                                    @else
                                                        <p class="fs-20 text-white mb-0 fw-5">{{ Carbon\Carbon::parse($matchDetails->match_start)->format('jS M,Y h:i A') }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 pt-sm-0 pt-3">
                                            <div class="row justify-content-between align-items-center">
                                                <div class="col-xxl-4 col-sm-5 col-6 text-center">
                                                </div>
                                                <div class="col-xxl-4 col-sm-7 col-6 text-center">
                                                    <div class="flag mx-auto mb-2">
                                                        <img src="{{ $matchDetails->team_b_image }}" class="w-100">
                                                    </div>
                                                    <h3 class="fs-20 fw-5 text-white mb-0">{{ $matchDetails->team_b }}</h3>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @foreach($matchDetails->questions->where('status',1)->where('result_declared', false) as $question)
                                @if($question->options->where('status',1)->count())
                                        <div class="categoires-details categoires-info mx-4 p-3 mb-20">
                                            <p class="mb-1 text-white">{{ $question->question }}</p>
                                            <div class="row">
                                                @foreach($question->options->where('status',1) as $option)
                                                    <div class="col-md-6 mt-2">
                                                        <a href="javascript:void(0)"
                                                           class="d-flex justify-content-between bg-dark p-3 br-5 betModal"
                                                           id="{{ $question->is_locked ? 'questionLockedBtn' : 'addBetModalBtn' }}"
                                                           data-question_id="{{ $question->id }}"
                                                           data-option_id="{{ $option->id }}"
                                                           data-match_id="{{ $matchDetails->id }}"
                                                           data-option="{{ $option->name }}"
                                                           data-question="{{ $question->question }}"
                                                           data-title="{{ $matchDetails->match_title }}"
                                                           data-divisor="{{ $option->divisor }}"
                                                           data-user-balance="{{ getTotalBalance() }}"
                                                           data-auth="{{ getLogInUser() }}">
                                                            <span class="text-white">{{ $option->name }}</span>
                                                            <span class="text-white">{{ $option->dividend }} : {{ $option->divisor }}</span>
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @include('front.right-sidebar')
                </div>
            </div>
        </section>
    </div>
    @include('front.add_bet_modal')
    @include('front.login_modal')
@endsection
