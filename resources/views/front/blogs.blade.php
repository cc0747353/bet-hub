@extends('front.layout.app')
@section('title')
    {{ __('messages.front.blogs') }}
@endsection
@section('content')
    <div class="blog-page bg-dark pb-120">
        <section class="blog-section ">
            <div class="container">
                <div class="section-heading pt-40 pb-40 border-bottom">
                    <div class="row justify-content-center">
                        <div class="col-8 text-center">
                            <h2 class="text-primary mb-0">{{ __('messages.front.blogs') }}</h2>
                        </div>
                    </div>
                </div>
                <div class="blog">
                    @foreach($blogs as $blog)
                        <div class="row d-flex pt-40 pb-40 {{ $loop->last ? '' : 'border-bottom' }} ">
                            <div class="col-xxl-4 col-lg-5 blog-img mb-lg-0 mb-4">
                                <div class="blog-img">
                                    <img src="{{ $blog->blog_image }}" alt="blog" class="w-100 h-100 object-fit-cover">
                                </div>
                            </div>
                            <div class="col-xxl-8 col-lg-7 ps-lg-4">
                                <div class="blog-desc px-lg-3 ">
                                <span class="fs-6 text-white">{{ \Carbon\Carbon::parse($blog->created_at)->format('d M,y') }}<span
                                            class="ms-2"> |</span> <span
                                            class="text-primary ms-2">{{ $blog->tag }}</span></span>
                                    <h4 class="text-white mt-3">{{ $blog->title }}</h4>
                                    <div class="text-gray-100">
                                        {{ Str::limit(strip_tags($blog->description), 200) }}
                                    </div>
                                    <a href="{{ route('blog-details',$blog->slug) }}" type="button"
                                       class="btn btn-transparent mt-xxl-3 mt-2">Read More</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    </div>
@endsection
