@extends('front.layout.app')
@section('title')
    {{ __('messages.front.affiliate') }}
@endsection
@section('content')
<div class="affiliate-page bg-dark">
        <section class="affiliate-section">
            <div class="container">
                <div class="section-heading border-bottom pt-40 pb-40">
                    <div class="row justify-content-center">
                        <div class="col-12 text-center">
                            <h2 class="text-primary mb-0">{{ __('messages.front.affiliate') }}</h2>
                        </div>
                    </div>
                </div>
                <div class="affiliate pt-120 pb-120">
                    <div class="row align-items-center">
                        <div class="col-lg-6 mb-lg-0 mb-40">
                            <div class="affiliate-desc">
                                <h2 class="text-white mb-20">{{ isset($affiliate) ? $affiliate['affiliate_title'] : '' }}</h2>
                                <p class="fs-6 text-gray-100">{{ isset($affiliate) ? $affiliate['affiliate_description'] : '' }}</p>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="affiliate-img">
                                <img src="{{ isset($affiliate) ? $affiliate['affiliate_image'] : asset('images/affiliate.png') }}" alt="affiliate" class="object-fit-cover w-100" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="level-section">
            <div class="container">
                <div class="level bg-secondary">
                    <div class="row">
                        @foreach($referralLevels as $referralLevel)
                            <div class="col-lg-4 col-md-6 mb-lg-0 mb-4">
                                <div class="level-card d-flex pe-xxl-5 pe-md-3">
                                    <div class="level-text me-3">
                                        <p class="fs-18 text-white mb-0">{{ $referralLevel->commission }} %</p>
                                    </div>
                                    <div class="level-desc">
                                        <h4 class="text-white">Level {{ $referralLevel->level }}</h4>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <section class="latest-blog-section pt-120 pb-120">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8 text-center">
                        <div class="section-heading pb-60">
                            <h2 class="text-white">Our Latest Blog</h2>
                        </div>
                    </div>
                </div>
                <div class="recent-post">
                    <div class="row">
                        @foreach($latestBlogs as $latestBlog)
                            <div class="col-lg-4 col-md-6 mb-lg-0 mb-40">
                                <a href="{{ route('blog-details',$latestBlog->slug) }}">
                                    <div class="card h-100 bg-transparent border-0">
                                        <div class="card-img-top br-10">
                                            <img class="w-100 object-fit-cover blogMaxHeight"
                                                 src="{{ $latestBlog->blog_image }}" alt="recent-post"/>
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title fs-14 text-primary">
                                                {{ $latestBlog->created_at }}
                                            </h5>
                                            <p class="card-text fs-18 fw-5 text-white">
                                                {{ $latestBlog->title }}
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
        <section class="how-to-start-section pb-120">
            <div class="container">
                <div class="how-to-start pb-60">
                    <div class="section-heading">
                        <div class="row justify-content-center">
                            <div class="col-lg-8 text-center">
                                <h2 class="text-white mb-20">{{ isset($affiliate) ? $affiliate['start_title'] : '' }}</h2>
                                <p class="text-gray-100 mb-0">
                                    {{ isset($affiliate) ? $affiliate['start_description'] : '' }}
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
                                    <h4 class="text-white mb-3">{{ isset($affiliate) ? $affiliate['step_1_title'] : '' }}</h4>
                                    <p class="text-gray-100 mb-0">
                                        {{ isset($affiliate) ? $affiliate['step_1_description'] : '' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 mb-lg-0 mb-5">
                            <div class="start-feature-card">
                                <div class="desc">
                                    <h4 class="text-white mb-3">{{ isset($affiliate) ? $affiliate['step_2_title'] : '' }}</h4>
                                    <p class="text-gray-100 mb-0">
                                        {{ isset($affiliate) ? $affiliate['step_2_description'] : '' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="start-feature-card">
                                <div class="desc">
                                    <h4 class="text-white mb-3">{{ isset($affiliate) ? $affiliate['step_3_title'] : '' }}</h4>
                                    <p class="text-gray-100 mb-0">
                                        {{ isset($affiliate) ? $affiliate['step_3_description'] : '' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
