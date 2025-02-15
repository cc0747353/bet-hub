@extends('front.layout.app')
@section('title')
    {{ __('messages.front.contact_us') }}
@endsection
@section('content')
    <div class="contact-page bg-dark">
        <section class="contact-section">
            <div class="container">
                <div class="section-heading pt-40 pb-40 border-bottom">
                    <div class="row justify-content-center">
                        <div class="col-12 text-center">
                            <h2 class="text-primary mb-0">{{ __('messages.front.contact') }}</h2>
                        </div>
                    </div>
                </div>
                <div class="get-in-touch pt-40 pb-60">
                    @include('flash::message')
                    @include('layouts.errors')
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="contact-desc pb-40">
                                <h2 class="text-white mb-20">{{ isset($contactUsData) ? $contactUsData['contact_us_title'] : '' }}</h2>
                                <p class="fs-6 text-gray-100 mb-0">
                                    {{ isset($contactUsData) ? $contactUsData['contact_us_description'] : '' }}
                                </p>
                            </div>
                            <div class="contact-img px-sm-5 mb-lg-0 mb-5">
                                <img src="{{ isset($contactUsData) ? $contactUsData['contact_us_image'] : asset('images/contact.png') }}" alt="about" class="object-fit-contain w-100">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <form method="POST" action="{{ route('contact-us.store') }}" id="contactUsForm">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group mb-20">
                                            <label for="exampleInput" class="text-white fs-20 mb-10 required">{{ __('messages.front.first_name').' :' }}</label>
                                            <input type="text" class="form-control" id="exampleInputName" required="" placeholder="{{ __('messages.front.first_name') }}" name="first_name">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group mb-20">
                                            <label for="exampleInput" class="text-white fs-20 mb-10 required">{{ __('messages.front.last_name').' :' }}</label>
                                            <input type="text" class="form-control" id="exampleInputName" required="" placeholder="{{ __('messages.front.last_name') }}" name="last_name">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group mb-20">
                                            <label for="exampleInputEmail" class="text-white fs-20 mb-10 required">{{ __('messages.front.email_address').' :' }}</label>
                                            <input type="email" class="form-control" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="{{ __('messages.front.enter_email') }}" required="" name="email">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group mb-20">
                                            <label for="exampleInput" class="text-white fs-20 mb-10 required">{{ __('messages.front.subject').' :' }}</label>
                                            <input type="text" class="form-control" id="exampleInput" placeholder="{{ __('messages.front.subject') }}" required="" name="subject">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group mb-20">
                                            <label for="exampleFormControlTextarea" class="text-white fs-20 mb-10 required">{{ __('messages.front.message').' :' }}</label>
                                            <textarea class="form-control" id="exampleFormControlTextarea" required="" rows="5" name="message"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-12 text-end">
                                            <button type="submit" class="btn btn-primary" id="contactUsFormSaveBtn" required="" >{{ __('messages.front.send_message') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="how-to-start-section pb-120">
            <div class="container">
                <div class="start-features pt-4 mt-2">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 mb-lg-0 mb-5">
                            <div class="start-feature-card min-height-160">
                                <div class="icon">
                                    <i class="fa-solid fa-envelope-open-text"></i>
                                </div>
                                <div class="desc pt-4">
                                    <h4 class="text-white mb-1">{{ __('messages.front.email_address') }}</h4>
                                    <a href="mailto:sports@bet.com" class="text-gray-100 mb-0">
                                        {{ getSettingValue()['email'] }}
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 mb-lg-0 mb-5">
                            <div class="start-feature-card min-height-160">
                                <div class="icon">
                                    <i class="fa-solid fa-building-user"></i>
                                </div>
                                <div class="desc pt-4">
                                    <h4 class="text-white mb-1">{{ __('messages.front.office_address') }}</h4>
                                    <a href="#!" class="text-gray-100 mb-0">
                                        {{ getSettingValue()['address'] }}
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 ">
                            <div class="start-feature-card min-height-160">
                                <div class="icon">
                                    <i class="fa-solid fa-phone"></i>
                                </div>
                                <div class="desc pt-4">
                                    <h4 class="text-white mb-1">{{ __('messages.front.phone_number') }}</h4>
                                    <a href="tel:+834 3838 838 8383" class="text-gray-100 mb-0">
                                        {{ getSettingValue()['contact_no'] }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
