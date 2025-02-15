<footer class="bg-secondary">
    <div class="container">
        <div class="top-footer pt-60 pb-60">
            <div class="row justify-content-between">
                <div class="col-lg-4 col-md-6 mb-lg-0 mb-4 pe-lg-5">
                    <div class="footer-logo mb-20">
                        <a href="#!">
                            <img src="{{ $settings['logo'] }}" alt="InfyBetting" class="web-logo" />
                        </a>
                    </div>
                    <p class="text-gray-100">
                        {{ Str::limit(strip_tags( $frontSettings['about_us_description']), 100) }}
                    </p>
                    <form action="" id="subscriberForm">
                        <div class="email position-relative mb-lg-0 mb-3">
                            <input type="email" class="w-100 fs-14 text-gray-100 bg-transparent br-10 front-input subscriber-email" placeholder="{{ __('messages.front.your_email_address') }}" required/>
                            <button type="submit" class="btn btn-primary position-absolute fs-14"> {{__('messages.common.subscribe')}} </button>
                        </div>
                    </form>
                </div>
                <div class="col-lg-2 col-sm-6 mb-lg-0 mb-4 ps-xl-5 ps-lg-4 ps-md-5">
                    <div class="quick-links ms-lg-0 ms-md-5">
                        <h3 class="text-white mb-20">{{__('messages.front.quick_links')}}</h3>
                        <div class="desc">
                            <a href="/">{{__('messages.front.home')}}</a>
                            <a href="{{ route('about-us') }}">{{__('messages.front.about')}}</a>
                            <a href="{{ route('affiliate') }}">{{__('messages.front.affiliate')}}</a>
                            <a href="{{ route('contact-us') }}">{{__('messages.front.contact')}}</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 ps-lg-5 ps-md-0 ps-sm-5 mb-md-0 mb-4">
                    <div class="company-policy ms-md-0 ms-sm-5">
                        <h3 class="text-white mb-20">{{__('messages.front.company_policy')}}</h3>
                        <div class="desc">
                            <a href="{{ route('licences-info') }}">{{__('messages.front.licences_info')}}</a>
                            <a href="{{ route('rules-for-bet') }}">{{__('messages.front.rules_for_bet')}}</a>
                            <a href="{{ route('terms-of-service') }}">{{__('messages.front.terms_of_service')}}</a>
                            <a href="{{ route('privacy-policy') }}">{{__('messages.front.privacy_policy')}}</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 ps-md-5">
                    <div class="contact-us ms-lg-0 ms-md-5">
                        <h3 class="text-white mb-20">{{__('messages.front.contact_us')}}</h3>
                        <div class="desc">
                            <a href="mailto:{{$settings['email']}}" class="fs-6 d-flex align-items-center">
                                <img src="{{ asset('images/envalop.png') }}" class="img-icon me-3"/>{{ $settings['email'] }}</a>
                            <a href="tel:{{$settings['contact_no']}}" class="fs-6 d-flex align-items-center">
                                <img src="{{ asset('images/phone.png') }}" class="img-icon me-3"/>{{ $settings['region_code'] }}{{ $settings['contact_no'] }}</a>
                        </div>
                        <div class="social-icons d-flex pt-3">
                            @foreach($socialIcons as $socialIcon)
                                <a href="{{ $socialIcon->url }}" target="_blank"><i class="{{ $socialIcon->icon }}"></i></a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="last-line-footer">
            <div class="row justify-content-center">
                <div class="col-sm-6 text-center">
                    <p class="fs-14 text-gray-100 mb-0">
                        {{ $settings['copy_right_text'] }} <a href="#">{{ \Carbon\Carbon::now()->year }} {{ $settings['app_name'] }}</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>
