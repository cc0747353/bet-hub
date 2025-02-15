@extends('front.layout.app')
@section('title')
    {{ __('messages.front.rules_for_bet') }}
@endsection
@section('content')
    <div class="affiliate-page bg-dark">
        <section class="licences-info-section pb-120">
            <div class="container">
                <div class="section-heading pt-60 pb-60 border-bottom">
                    <div class="row justify-content-center">
                        <div class="col-12 text-center">
                            <h2 class="text-primary mb-0">{{ __('messages.front.rules_for_bet') }}</h2>
                        </div>
                    </div>
                </div>
                <div class="m-4">
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <div class="accordion" id="accordionExample">
                                <div class="text-white">
                                    {!! !empty($ruleForBet['rules_for_bet']) ? $ruleForBet['rules_for_bet'] : '' !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
@endsection
