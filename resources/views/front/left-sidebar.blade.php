@php
    $categories = getCategoriesFront();
@endphp
<div class="col-xxl-2 col-lg-3 pt-40">
    <div class="categories-box bg-secondary br-10 py-20 mb-40">
        <div class="heading-text px-20 mb-3">
            <h3 class="text-white d-inline me-3">Categories</h3>
        </div>
        <div class="">
            <ul class="nav nav-tabs mb-20" id="myTab" role="tablist">
                <li class="nav-item w-50" role="presentation">
                    <button class="nav-link {{ isset($type) ? ($type == 'live' ? 'active' : '') : 'active' }} w-100 fs-14 fw-5" id="live-tab"
                            data-bs-toggle="tab"
                            data-bs-target="#live" type="button" role="tab" aria-controls="live"
                            aria-selected="true">Live
                    </button>
                </li>
                <li class="nav-item w-50" role="presentation">
                    <button class="nav-link {{ isset($type) ? ($type == 'upcoming' ? 'active' : '') : '' }} w-100 fs-14 fw-5" id="upcoming-tab" data-bs-toggle="tab"
                            data-bs-target="#upcoming" type="button" role="tab"
                            aria-controls="upcoming"
                            aria-selected="false">Upcoming
                    </button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show {{ isset($type) ? ($type == 'live' ? 'active' : '') : 'active' }}" id="live" role="tabpanel"
                     aria-labelledby="live-tab">
                    <ul class="ps-0 mb-0">
                        <li class="has-ul">
                            <a href="javascript:void(0)" class="d-flex ">
                                <i class="bi bi-list-check fs-14 me-3"></i>
                                <span class="fs-14">All Categories</span>
                                <i class="arrow fa-solid fa-caret-down"></i>
                            </a>
                            <ul class="sub-ul">
                                @foreach($categories['live'] as $category)
                                    @if(\App\Models\League::with('match.questions.options')->where('category_id', $category->id)->where('status', 1)->whereHas('match', function ($q){ $q->where('status', 1); })->whereHas('match', function ($q){ $q->whereHas('questions.options'); })->whereHas('match.questions', function ($q){ $q->where('result_declared', false); })->count())
                                    <li>
                                        <a href="{{ route('match-list-category',[$category->id, 'type' =>'live']) }}" class="d-flex {{ isset($category_id) && $category_id == $category->id ? 'active' : '' }}">
                                            <div class="">
                                                <i class="{{ $category->icon }} fs-14 me-2"></i>
                                                <span class="fs-14">{{ $category->name }}</span>
                                            </div>
                                        </a>
                                    </li>
                                    @endif
                                @endforeach
                            </ul>
                        </li>
                        @foreach($categories['live'] as $category)
                            @if(\App\Models\League::with('match.questions.options')->where('category_id', $category->id)->where('status', 1)->whereHas('match', function ($q){ $q->where('status', 1); })->whereHas('match', function ($q){ $q->whereHas('questions.options'); })->whereHas('match.questions', function ($q){ $q->where('result_declared', false); })->count())
                            <li class="has-ul">
                                <a href="javascript:void(0)" class="d-flex  {{ isset($category_id) && $category_id == $category->id ? 'active' : '' }}">
                                    <div class="">
                                        <i class="{{ $category->icon }} fs-14 me-2"></i>
                                        <span class="fs-14">{{ $category->name }}</span>
                                    </div>
                                    <i class="arrow fa-solid fa-caret-down"></i>
                                </a>
                                <ul class="sub-ul">
                                    @foreach($category->league as $league)
                                        @if($league->match()->whereDate('match_start', \Carbon\Carbon::today())->count() != 0)
                                            <li>
                                                <a href="{{ route('match-list-league', [$league->id, 'type' =>'live']) }}" class="d-flex {{ isset($league_id) && $league_id == $league->id ? 'active' : '' }}">
                                                    <div class="">
                                                        <i class="{{ $league->icon }} fs-5 me-3"></i>
                                                        <span class="fs-14">{{ $league->name }}</span>
                                                    </div>
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
                <div class="tab-pane fade {{ isset($type) ? ($type == 'upcoming' ? 'active show' : '') : '' }}" id="upcoming" role="tabpanel"
                     aria-labelledby="upcoming-tab">
                    <ul class="ps-0 mb-0">
                        <li class="has-ul">
                            <a href="javascript:void(0)" class="d-flex ">
                                <i class="bi bi-list-check fs-14 me-3"></i>
                                <span class="fs-14">All Categories</span>
                                <i class="arrow fa-solid fa-caret-down"></i>
                            </a>
                            <ul class="sub-ul">
                                @foreach($categories['upcoming'] as $category)
                                    @if(\App\Models\League::with('match.questions.options')->where('category_id', $category->id)->whereHas('match', function ($q){ $q->whereHas('questions.options'); })->whereHas('match.questions', function ($q){ $q->where('result_declared', false); })->count())
                                    <li>
                                        <a href="{{ route('match-list-category', [$category->id, 'type' =>'upcoming']) }}" class="d-flex {{ isset($category_id) && $category_id == $category->id ? 'active' : '' }}">
                                            <div class="">
                                                <i class="{{ $category->icon }} fs-14 me-2"></i>
                                                <span class="fs-14">{{ $category->name }}</span>
                                            </div>
                                        </a>
                                    </li>
                                    @endif
                                @endforeach
                            </ul>
                        </li>
                        @foreach($categories['upcoming'] as $category)
                            @if(\App\Models\League::with('match.questions.options')->where('category_id', $category->id)->whereHas('match', function ($q){ $q->whereHas('questions.options'); })->whereHas('match.questions', function ($q){ $q->where('result_declared', false); })->count())
                            <li class="has-ul">
                                <a href="javascript:void(0)" class="d-flex  {{ isset($category_id) && $category_id == $category->id ? 'active' : '' }}">
                                    <div class="">
                                        <i class="{{ $category->icon }} fs-14 me-2"></i>
                                        <span class="fs-14">{{ $category->name }}</span>
                                    </div>
                                    <i class="arrow fa-solid fa-caret-down"></i>
                                </a>
                                <ul class="sub-ul">
                                    @foreach($category->league as $league)
                                        @if($league->match()->whereDate('match_start', '>=', \Carbon\Carbon::tomorrow())->count() != 0)
                                            <li>
                                                <a href="{{ route('match-list-league', [$league->id, 'type' =>'upcoming']) }}" class="d-flex {{ isset($league_id) && $league_id == $league->id ? 'active' : '' }}">
                                                    <div class="">
                                                        <i class="{{ $league->icon }} fs-14 me-3"></i>
                                                        <span class="fs-14">{{ $league->name }}</span>
                                                    </div>
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
