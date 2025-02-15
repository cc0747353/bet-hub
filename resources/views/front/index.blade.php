@extends('front.layout.app')
@section('title')
    {{ __('messages.front.home') }}
@endsection
@section('content')
    @php
        $loginUser = getLogInUser();
    @endphp
    <div class="home-page bg-dark">
        <!-- start categories-section -->
        <section class="categories-section pb-40">
            <div class="container-fluid px-60">
                <div class="row">
                    @include('front.left-sidebar')
                    <div class="col-xxl-8 col-lg-6 pt-40">
                        @if($homeBgImages != null)
                            <div id="carouselExampleCaptions" class="carousel slide rounded-10" data-bs-ride="carousel">
                                <div class="carousel-inner rounded-10">
                                    @foreach($homeBgImages as $homeBgImage)
                                        <div class="carousel-item @if($loop->iteration <=1)active @endif">
                                            <div class="position-relative d-block carousel-img">
                                                <img src="{{ $homeBgImage }}"
                                                     class="d-block home-bg-image object-cover" alt="hero">
                                            </div>
                                            <div class="carousel-caption">
                                                <h1 class="text-white">{{ isset($homePageData) ? $homePageData['home_title'] : ''}}</h1>
                                                <p class="text-white fs-18 mx-xxl-5 px-xxl-5 mb-0">
                                                    {{ isset($homePageData) ? $homePageData['home_description'] : '' }}
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <button class="carousel-control-prev" type="button"
                                        data-bs-target="#carouselExampleCaptions"
                                        data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button"
                                        data-bs-target="#carouselExampleCaptions"
                                        data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        @else
                            <!-- start hero-section  -->
                        @php
                            $imageCss = 'style="background-image: url('.isset($homePageData) ? asset($homePageData['home_bg_image']) : asset('images/banner.png').')"';
                        @endphp
                            <section class="hero-section" {{ $imageCss }}>
                                <div class="overlay"></div>
                                <div class="container hero-content">
                                    <div class="row justify-content-center">
                                        <div class="col-xxl-10  col-12 text-center">
                                            <h1 class="text-white">{{ isset($homePageData) ? $homePageData['home_title'] : ''}}</h1>
                                            <p class="text-white fs-18 mx-xxl-5 px-xxl-5 mb-0">
                                                {{ isset($homePageData) ? $homePageData['home_description'] : '' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <!-- end hero-section  -->
                        @endif
                        <div class="tabs-section">
                            <ul class="nav nav-tabs mb-20" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="all-sports-tab" data-bs-toggle="tab"
                                            data-bs-target="#all-sports" type="button" role="tab"
                                            aria-controls="all-sports" aria-selected="true">
                                        <i class="bi bi-list-check fs-14 me-3"></i>
                                        <span class="fs-14">All</span>
                                    </button>
                                </li>
                                @foreach($categoryData as $category)
                                    @if(\App\Models\League::with('match.questions.options')->where('category_id', $category->id)->where('status', 1)->whereHas('match', function ($q){ $q->where('status', 1); })->whereHas('match', function ($q){ $q->whereHas('questions.options'); })->whereHas('match.questions', function ($q){ $q->where('result_declared', false); })->count())
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link me-1" id="{{(\Illuminate\Support\Str::slug($category->name))}}-tab"
                                                    data-bs-toggle="tab"
                                                    data-bs-target="#{{ (\Illuminate\Support\Str::slug($category->name)) }}" type="button" role="tab"
                                                    aria-controls="{{ (\Illuminate\Support\Str::slug($category->name)) }}" aria-selected="true">
                                                <i class="{{ $category->icon }} fs-14 me-3"></i>
                                                <span class="fs-13">{{ $category->name }}</span>
                                            </button>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="all-sports" role="tabpanel"
                                     aria-labelledby="all-sports-tab">
                                    @foreach($categoryData as $category)
                                        @foreach($category->league as $leagues)
                                            @foreach($leagues->match->where('status', 1) as $matchData)
                                                @if($matchData->questions->where('status', 1)->where('result_declared', false)->count() != 0)
                                                    <table class="table text-white w-100 mb-20">
                                                        <thead class="">
                                                        <tr>
                                                            <th class="text-left fw-normal">
                                                                <i class="{{ $leagues->icon }} fs-6 me-3"></i>
                                                                <span>{{ $leagues->name }}</span>
                                                            </th>
                                                            <th class="text-center fw-normal">
                                                                @if(Carbon\Carbon::parse($matchData->match_start)->isToday())
                                                                    <span>
                                                                        {{ Carbon\Carbon::parse($matchData->match_start)->format('h:i A') }}
                                                                    </span>
                                                                @elseif(Carbon\Carbon::parse($matchData->match_start)->isTomorrow())
                                                                    <span>
                                                                        Tomorrow {{ Carbon\Carbon::parse($matchData->match_start)->format('h:i A') }}
                                                                    </span>
                                                                @else
                                                                    <span>
                                                                  {{ Carbon\Carbon::parse($matchData->match_start)->format('jS M,Y h:i A') }}
                                                                    </span>
                                                                @endif
                                                            </th>
                                                            @foreach(\App\Models\Question::with('options')->where('match_id', $matchData->id)->where('status', 1)->whereHas('options')->where('result_declared', false)->take(2)->get() as $questionData)
                                                                <th class="col-2 fw-normal">
                                                                    <div class="d-flex justify-content-evenly">
                                                                        <span>{{ $questionData->question }}</span>
                                                                    </div>
                                                                </th>
                                                            @endforeach
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr>
                                                            <td colspan="2">
                                                                <div class="d-flex justify-content-start">
                                                                <span class="mw-120">
                                                                    <img src="{{ $matchData->team_a_image }}"
                                                                         alt="real-modrid"
                                                                         class="team-img me-1 mb-1 rounded-circle object-cover">
                                                                  {{ $matchData->team_a }}
                                                                </span>
                                                                    <span class="ps-3">
                                                                    <img src="{{ $matchData->team_b_image }}"
                                                                         alt="liverpool"
                                                                         class="team-img me-1 rounded-circle object-cover">
                                                                  {{ $matchData->team_b }}
                                                                </span>
                                                                </div>
                                                            </td>
                                                            @foreach(\App\Models\Question::with('options')->where('match_id', $matchData->id)->where('status',1)->whereHas('options')->where('result_declared', false)->take(2)->get() as $questionData)
                                                                <td>
                                                                    <div class="d-flex justify-content-evenly w-100">
                                                                        @foreach($questionData->options as $optionData)
                                                                            <a href="javascript:void(0)"
                                                                               class="betModal me-2"
                                                                               id="{{ $questionData->is_locked ? 'questionLockedBtn' : 'addBetModalBtn' }}"
                                                                               data-question_id="{{ $questionData->id }}"
                                                                               data-option_id="{{ $optionData->id }}"
                                                                               data-match_id="{{ $matchData->id }}"
                                                                               data-option="{{ $optionData->name }}"
                                                                               data-question="{{ $questionData->question }}"
                                                                               data-title="{{ $matchData->match_title }}"
                                                                               data-divisor="{{ $optionData->divisor }}"
                                                                               data-user-balance="{{ $totalBalance }}"
                                                                               data-auth="{{ $loginUser }}">
                                                                                <button type="button"
                                                                                        class="min-width d-flex justify-content-between mt-1">
                                                                                    <span>{{ $optionData->name }}</span>
                                                                                    <span class="ps-2">{{ $optionData->dividend.' : '.$optionData->divisor }}</span>
                                                                                </button>
                                                                            </a>
                                                                            <input type="hidden"
                                                                                   value="{{ getTotalBalance() }}"
                                                                                   id="userTotalBalance">
                                                                        @endforeach
                                                                    </div>
                                                                </td>
                                                            @endforeach
                                                            <td>
                                                                <div class="d-flex justify-content-evenly pt-1">
                                                                    <a href="{{ route('match-details',$matchData->id) }}">
                                                                        <button type="button" class="disable-btn">
                                                                            More
                                                                        </button>
                                                                    </a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                @endif
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                </div>
                                @foreach($categoryData as $category)
                                    <div class="tab-pane fade show " id="{{ (\Illuminate\Support\Str::slug($category->name)) }}" role="tabpanel"
                                         aria-labelledby="{{ (\Illuminate\Support\Str::slug($category->name)) }}-tab">
                                        @foreach($category->league as $leagues)
                                            @foreach($leagues->match->where('status', 1) as $matchData)
                                                @if($matchData->questions->count() != 0)
                                                    <table class="table text-white w-100 mb-20">
                                                        <thead class="">
                                                        <tr>
                                                            <th class="text-left fw-normal">
                                                                <i class="{{ $leagues->icon }} fs-6 me-3"></i>
                                                                <span>{{ $leagues->name }}</span>
                                                            </th>
                                                            <th class="text-center fw-normal">
                                                                @if(Carbon\Carbon::parse($matchData->match_start)->isToday())
                                                                    <span>
                                                                        {{ Carbon\Carbon::parse($matchData->match_start)->format('h:i A') }}
                                                                    </span>
                                                                @elseif(Carbon\Carbon::parse($matchData->match_start)->isTomorrow())
                                                                    <span>
                                                                        Tomorrow {{ Carbon\Carbon::parse($matchData->match_start)->format('h:i A') }}
                                                                    </span>
                                                                @else
                                                                    <span>
                                                                  {{ Carbon\Carbon::parse($matchData->match_start)->format('jS M,Y h:i A') }}
                                                                    </span>
                                                                @endif
                                                            </th>
                                                            @foreach($matchData->questions->where('result_declared', false)->take(2) as $questionData)
                                                                <th class="col-2 fw-normal">
                                                                    <div class="d-flex justify-content-evenly">
                                                                        <span>{{ $questionData->question }}</span>
                                                                    </div>
                                                                </th>
                                                            @endforeach
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr>
                                                            <td colspan="2">
                                                                <div class="d-flex justify-content-start">
                                                                    <span class="mw-120">
                                                                        <img src="{{ $matchData->team_a_image }}"
                                                                             alt="real-modrid"
                                                                             class="team-img me-1 mb-1 rounded-circle object-cover">
                                                                      {{ $matchData->team_a }}
                                                                    </span>
                                                                    <span class="ps-3">
                                                                        <img src="{{ $matchData->team_b_image }}"
                                                                             alt="liverpool"
                                                                             class="team-img me-1 rounded-circle">
                                                                        {{ $matchData->team_b }}
                                                                    </span>
                                                                </div>
                                                            </td>
                                                            @foreach(\App\Models\Question::with('options')->where('match_id', $matchData->id)->whereHas('options')->where('result_declared', false)->take(2)->get() as $questionData)
                                                                <td>
                                                                    <div class="d-flex justify-content-evenly w-100">
                                                                        @foreach($questionData->options as $optionData)
                                                                            <a href="javascript:void(0)"
                                                                               class="betModal me-2"
                                                                               id="{{ $questionData->is_locked ? 'questionLockedBtn' : 'addBetModalBtn' }}"
                                                                               data-question_id="{{ $questionData->id }}"
                                                                               data-option_id="{{ $optionData->id }}"
                                                                               data-match_id="{{ $matchData->id }}"
                                                                               data-option="{{ $optionData->name }}"
                                                                               data-question="{{ $questionData->question }}"
                                                                               data-title="{{ $matchData->match_title }}"
                                                                               data-divisor="{{ $optionData->divisor }}"
                                                                               data-auth="{{ $loginUser }}">
                                                                                <button type="button"
                                                                                        class="min-width d-flex justify-content-between mt-1">
                                                                                    <span>{{ $optionData->name }}</span>
                                                                                    <span class="ps-2">{{ $optionData->dividend.' : '.$optionData->divisor }}</span>
                                                                                </button>
                                                                            </a>
                                                                        @endforeach
                                                                    </div>
                                                                </td>
                                                            @endforeach
                                                            <td>
                                                                <div class="d-flex justify-content-evenly pt-1">
                                                                    <a href="{{ route('match-details',$matchData->id) }}">
                                                                        <button type="button" class="disable-btn">More
                                                                        </button>
                                                                    </a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                @endif
                                            @endforeach
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @include('front.right-sidebar')
                </div>
            </div>
        </section>
        <!-- end categories-section -->
        <!--start slider section -->
        @if(count($partners))
            <section class="slider-section bg-blue-200 pt-40 pb-40">
                <div class="container">
                    <div class="slick-slider">
                        @foreach($partners as $partner)
                            <div class="element element-1">
                                <img src="{{ $partner->image }}" alt=""/>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
        <!--end slider section -->
    </div>
    @include('front.add_bet_modal')
    @include('front.login_modal')
@endsection
