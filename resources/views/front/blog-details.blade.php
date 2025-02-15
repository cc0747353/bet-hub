@extends('front.layout.app')
@section('title')
    {{ __('messages.front.blog_details') }}
@endsection
@section('content')
    <div class="blog-details-page bg-dark pb-120">
        <section class="blog-details-section">
            <div class="container">
                <div class="section-heading border-bottom pt-40 pb-40">
                    <div class="row justify-content-center">
                        <div class="col-8 text-center">
                            <h2 class="text-primary mb-0">{{ __('messages.front.blog_details') }}</h2>
                        </div>
                    </div>
                </div>
                <div class="blog-details border-bottom">
                    <div class="row justify-content-center pt-60 pb-60 ">
                        <div class="col-lg-8 mb-lg-0 ">
                            <h4 class="text-white mb-20 fs-30">{{ $blog->title }}</h4>
                            <div class="blog-details-img mb-40">
                                <img src="{{ $blog->blog_image }}" alt="blog" class="blog_details_image">
                            </div>
                            <div class="blog-desc">
                                <div class="text-gray-100">
                                    {!! $blog->description !!}
                                </div>
                            </div>
                            <div class="share d-flex align-items-center flex-wrap pt-md-3">
                                <h3 class="text-white mb-sm-0 me-4">{{ __('messages.front.share_now') }} :</h3>
                                <div class="icon d-flex flex-wrap">
                                    <div class="social-icon">
                                        <a target="_blank"
                                           href="https://www.facebook.com/sharer.php?u={{ Request::url() }}">
                                            <i class="fab fa-facebook-f fs-5"></i>
                                        </a>
                                    </div>
                                    <div class="social-icon">
                                        <a target="_blank"
                                           href="https://www.twitter.com/share?url={{ Request::url() }}">
                                            <i class="fab fa-twitter fs-5"></i>
                                        </a>
                                    </div>
                                    <div class="social-icon">
                                        <a target="_blank"
                                           href="https://www.linkedin.com/shareArticle?mini=true&url={{ Request::url() }}">
                                            <i class="fab fa-linkedin fs-5"></i>
                                        </a>
                                    </div>
                                    <div class="social-icon">
                                        <a target="_blank"
                                           href="https://reddit.com/submit?url={{ Request::url() }}">
                                            <i class="fab fa-reddit fs-5"></i>
                                        </a>
                                    </div>
                                    <div class="social-icon">
                                        <a target="_blank" href="https://wa.me/?text={{ Request::url() }}">
                                            <i class="fab fa-whatsapp fs-5"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="recent-post-section ">
                    <div class="row justify-content-center">
                        <div class="col-12 text-center">
                            <div class="section-heading pt-60 pb-60">
                                <h2 class="text-white d-inline me-4">{{ __('messages.front.recent_post') }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="recent-post">
                        <div class="row">
                            @foreach($recentBlogs as $recentBlog)
                                <div class="col-lg-4 col-md-6 mb-lg-0 mb-4 ">
                                    <div class="card h-100 bg-transparent">
                                        <div class="card-img-top br-10">
                                            <img class="w-100 object-fit-cover blogMaxHeight"
                                                 src="{{ $recentBlog->blog_image }}"
                                                 alt="recent-post">
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title fs-14 text-primary">{{ \Carbon\Carbon::parse($recentBlog->created_at)->format('d M,y') }}</h5>
                                            <p class="card-text fs-18 fw-5 text-white">
                                                {{ $recentBlog->title }}
                                            </p>
                                            <a href="{{ route('blog-details',$recentBlog->slug) }}" type="button"
                                               class="btn btn-transparent mt-xxl-3 mt-2">Read More</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
