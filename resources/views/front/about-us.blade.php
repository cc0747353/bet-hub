@extends('front.layout.app')
@section('title')
    {{ __('messages.front.about_us') }}
@endsection
@section('content')
    <div class="about-page bg-dark">
        <section class="about-us-section">
            <div class="container">
                <div class="section-heading pt-40  pb-40 border-bottom">
                    <div class="row justify-content-center">
                        <div class="col-12 text-center">
                            <h2 class="text-primary mb-0">{{ __('messages.front.about_us') }}</h2>
                        </div>
                    </div>
                </div>
                <div class="about-us pt-120 pb-120">
                    <div class="row align-items-center">
                        <div class="col-lg-6 mb-lg-0 mb-5">
                            <div class="about-img">
                                <img src="{{ isset($aboutUsData) ? $aboutUsData['about_us_image'] :     
                                        asset('images/about.png') }}" alt="about" class="object-fit-cover w-100"/>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="about-desc">
                                <h2 class="text-white mb-20">{{ isset($aboutUsData) ? $aboutUsData['about_us_title'] : '' }}</h2>
                                <p class="fs-6 text-gray-100">
                                    {{ isset($aboutUsData) ? $aboutUsData['about_us_description'] : '' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="special-features-section bg-secondary pt-120 pb-120">
            <div class="container">
                <div class="special-features pb-60">
                    <div class="section-heading">
                        <div class="row justify-content-center">
                            <div class="col-lg-8 text-center">
                                <h2 class="text-white mb-20">{{ isset($aboutUsData) ? $aboutUsData['feature_title'] : '' }}</h2>
                                <p class="text-gray-100 mb-0">{{ isset($aboutUsData) ? $aboutUsData['feature_description'] : '' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="features">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 mb-lg-0 mb-4">
                            <div class="feature-card d-flex">
                                <div class="feature-text">
                                    <h4 class="text-white mb-1">{{ isset($aboutUsData) ? $aboutUsData['feature_1_title'] : '' }}</h4>
                                    <p class="text-gray-100 mb-0">{{ isset($aboutUsData) ? $aboutUsData['feature_1_description'] : '' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 mb-lg-0 mb-4">
                            <div class="feature-card d-flex">
                                <div class="feature-text">
                                    <h4 class="text-white mb-1">{{ isset($aboutUsData) ? $aboutUsData['feature_2_title'] : '' }}</h4>
                                    <p class="text-gray-100 mb-0">{{ isset($aboutUsData) ? $aboutUsData['feature_2_description'] : '' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="feature-card d-flex">
                                <div class="feature-text">
                                    <h4 class="text-white mb-1">{{ isset($aboutUsData) ? $aboutUsData['feature_3_title'] : '' }}</h4>
                                    <p class="text-gray-100 mb-0">{{ isset($aboutUsData) ? $aboutUsData['feature_3_description'] : '' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="how-to-start-section pt-60 pb-60">
            <div class="container">
                <div class="how-to-start pb-60">
                    <div class="section-heading">
                        <div class="row justify-content-center">
                            <div class="col-lg-8 text-center">
                                <h2 class="text-white mb-20">{{ isset($aboutUsData) ? $aboutUsData['start_title'] : '' }}</h2>
                                <p class="text-gray-100 mb-0">
                                    {{ isset($aboutUsData) ? $aboutUsData['start_description'] : '' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="start-features pt-4 mt-2">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 mb-lg-0 mb-5">
                            <div class="start-feature-card">
                                <div class="desc">
                                    <h4 class="text-white mb-3">{{ isset($aboutUsData) ? $aboutUsData['step_1_title'] : '' }}</h4>
                                    <p class="text-gray-100 mb-0">
                                        {{ isset($aboutUsData) ? $aboutUsData['step_1_description'] : '' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 mb-lg-0 mb-5">
                            <div class="start-feature-card">
                                <div class="desc">
                                    <h4 class="text-white mb-3">{{ isset($aboutUsData) ? $aboutUsData['step_2_title'] : '' }}</h4>
                                    <p class="text-gray-100 mb-0">
                                        {{ isset($aboutUsData) ? $aboutUsData['step_2_description'] : '' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="start-feature-card">
                                <div class="desc">
                                    <h4 class="text-white mb-3">{{ isset($aboutUsData) ? $aboutUsData['step_3_title'] : '' }}</h4>
                                    <p class="text-gray-100 mb-0">
                                        {{ isset($aboutUsData) ? $aboutUsData['step_3_description'] : '' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- start count-section -->
        <section class="count-section bg-secondary pt-60 pb-60">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-6 text-center mb-lg-0 mb-40">
                        <h2 class="counter text-primary fw-6 mb-1" data-countto="{{ $data['usersCount'] }}"
                            data-duration="3000">0</h2>
                        <p class="text-white mb-0">{{ __('messages.front.total_user') }}</p>
                    </div>
                    <div class="col-lg-3 col-6 text-center mb-lg-0 mb-40">
                        <h2 class="counter text-primary fw-6 mb-1" data-countto="{{ $data['matchesCount'] }}"
                            data-duration="3000"> 0</h2>
                        <p class="text-white mb-0">{{ __('messages.front.total_match') }}</p>
                    </div>
                    <div class="col-lg-3 col-6 text-center">
                        <h2 class="counter text-primary fw-6 mb-1" data-countto="{{ $data['transactionsCount'] }}"
                            data-duration="3000"> 0</h2>
                        <p class="text-white mb-0">{{ __('messages.front.total_transaction') }}</p>
                    </div>
                    <div class="col-lg-3 col-6 text-center">
                        <h2 class="counter text-primary fw-6 mb-1" data-countto="{{ $data['betWins'] }}"
                            data-duration="3000"> 0</h2>
                        <p class="text-white mb-0">{{ __('messages.front.total_win') }}</p>
                    </div>
                </div>
            </div>
        </section>
        <!-- end count-section -->

        <section class="question-section pt-60 pb-60">
            @if(count($faqData))
                <div class="container">
                    <div class="section-heading">
                        <div class="row justify-content-center">
                            <div class="col-lg-8 text-center pb-60">
                                <h2 class="text-white mb-20">{{ __('messages.front.frequently_asked_questions') }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="accordian-section">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <div class="accordion" id="accordionExample">
                                    @foreach($faqData as $faq)
                                        <div class="accordion-item border-bottom border-top">
                                            <h2 class="accordion-header" id="faq-{{$faq->id}}">
                                                <button class="accordion-button collapsed text-white fw-5 fs-18"
                                                        type="button" data-bs-toggle="collapse"
                                                        data-bs-target="#faq-collapse-{{$faq->id}}"
                                                        aria-expanded="false" aria-controls="faq-collapse-{{$faq->id}}">
                                                    {{$faq->question}}
                                                </button>
                                            </h2>
                                            <div id="faq-collapse-{{$faq->id}}" class="accordion-collapse collapse"
                                                 aria-labelledby="{{$faq->id}}" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <p class="text-gray-100 mb-0">
                                                        {{$faq->answer}}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </section>
    </div>
@endsection
