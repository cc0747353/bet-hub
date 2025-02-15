<header class='d-flex align-items-center justify-content-between flex-grow-1 header px-4 px-lg-7 px-xl-0'>
    <button type="button"
            class="btn px-0 aside-menu-container__aside-menubar text-gray-600 d-block d-xl-none sidebar-btn">
        <i class="fa-solid fa-bars fs-1"></i>
    </button>
    <nav class="navbar navbar-expand-xl navbar-light top-navbar d-xl-flex d-block px-3 px-xl-0 py-4 py-xl-0 "
         id="nav-header">
        <div class="container-fluid pe-0">
            <div class="navbar-collapse">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    @if(Request::is('admin/dashboard*'))
                        <li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0">
                            <a class="nav-link p-0 {{ Request::is('admin/dashboard*') ? 'active' : '' }}"
                               href="{{ route('admin.dashboard') }}">{{ __('messages.common.dashboard') }}</a>
                        </li>
                    @elseif(Request::is('admin/categories*'))
                        <li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0">
                            <a class="nav-link p-0 {{ Request::is('admin/categories*') ? 'active' : '' }}"
                               href="{{ route('categories.index') }}">{{ __('messages.common.categories') }}</a>
                        </li>
                    @elseif(Request::is('admin/leagues*'))
                        <li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0">
                            <a class="nav-link p-0 {{ Request::is('admin/leagues*') ? 'active' : '' }}"
                               href="{{ route('leagues.index') }}">{{ __('messages.common.leagues') }}</a>
                        </li>
                    @elseif(Request::is('admin/all-matches*'))
                        <li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0">
                            <a class="nav-link p-0 {{ Request::is('admin/all-matches*') ? 'active' : '' }}"
                               href="{{ route('all-matches.index') }}">{{ __('messages.matches.all_matches') }}</a>
                        </li>
                    @elseif(Request::is('admin/bets*'))
                        <li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0">    
                            <a class="nav-link p-0 {{ Request::is('admin/bets*') ? 'active' : '' }}"
                               href="{{ route('bets.index') }}">{{ __('messages.bets.bets') }}</a>
                        </li>
                    @elseif(Request::is('admin/questions*'))
                        <li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0">
                            <a class="nav-link p-0 {{ Request::is('admin/questions*') ? 'active' : '' }}"
                               href="#">{{ __('messages.question.questions') }}</a>
                        </li>
                    @elseif(Request::is('admin/options*'))
                        <li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0">
                            <a class="nav-link p-0 {{ Request::is('admin/options*') ? 'active' : '' }}"
                               href="#">{{ __('messages.question.options') }}</a>
                        </li>
                    @elseif(Request::is('admin/seo-tools*'))
                        <li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0">
                            <a class="nav-link p-0 {{ Request::is('admin/seo-tools*') ? 'active' : '' }}"
                               href="{{ route('seo-tools.index') }}">{{__('messages.seo-tool.seo_tool')}}</a>
                        </li>
                    @elseif(Request::is('admin/settings*') || Request::is('admin/currencies*') || Request::is('admin/cookie*'))
                        <li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 me-xl-3">
                            <a class="nav-link p-0 {{ Request::is('admin/settings*') ? 'active' : '' }}"
                               href="{{ route('settings.index') }}">{{__('messages.setting.setting')}}</a>
                        </li>
                        <li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 me-xl-3">
                            <a class="nav-link p-0 {{ Request::is('admin/currencies*') ? 'active' : '' }}"
                               href="{{ route('currencies.index') }}">{{__('messages.currency.currency')}}</a>
                        </li>
                        <li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 me-xl-3">
                            <a class="nav-link p-0 {{ Request::is('admin/cookie*') ? 'active' : '' }}"
                               href="{{ route('cookie-index') }}">{{__('messages.cookie.cookies')}}</a>
                        </li>
                    @elseif(Request::is('admin/email-template*'))
                        <li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 me-xl-3">
                            <a class="nav-link p-0 {{ Request::is('admin/email-template') ? 'active' : '' }}"
                               href="{{ route('email.template.index') }}">{{__('messages.email_template.email_template')}}</a>
                        </li>
                        <li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 me-xl-3">
                            <a class="nav-link p-0 {{ Request::is('admin/email-templates/configure*') ? 'active' : '' }}"
                               href="{{ route('email.configure.index') }}">{{__('messages.email_template.email_configuration')}}</a>
                        </li>
                    @elseif(Request::is('admin/languages*'))
                        <li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0">
                            <a class="nav-link p-0 {{ Request::is('admin/languages*') ? 'active' : '' }}"
                               href="{{ route('languages.index') }}">{{__('messages.languages.language')}}</a>
                        </li>
                    @elseif(Request::is('admin/roles*'))
                        <li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0">
                            <a class="nav-link p-0 {{ Request::is('admin/roles*') ? 'active' : '' }}"
                               href="{{ route('roles.index') }}">{{__('messages.role.role')}}</a>
                        </li>
                    @elseif(Request::is('admin/news-letter*'))
                        <li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0">
                            <a class="nav-link p-0 {{ Request::is('admin/news-letter*') ? 'active' : '' }}"
                               href="{{ route('news-letter.index') }}">{{__('messages.common.news_letters')}}</a>
                        </li>
                    @elseif(Request::is('admin/users*'))
                        <li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0">
                            <a class="nav-link p-0 {{ Request::is('admin/users*') ? 'active' : '' }}"
                               href="{{ route('users.index') }}">{{__('messages.user.users')}}</a>
                        </li>
                    @elseif(Request::is('admin/sms-template*'))
                        <li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 me-xl-3">
                            <a class="nav-link p-0 {{ Request::is('admin/sms-template/sms-gateways*') ? 'active' : '' }}"
                               href="{{ route('sms.gateways.index') }}">{{__('messages.sms_manager.sms_gateway')}}</a>
                        </li>
                        <li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 me-xl-3">
                            <a class="nav-link p-0 {{ Request::is('admin/sms-template*') ? (Request::is('admin/sms-template/sms-gateways*') ? '' : 'active') : '' }}"
                               href="{{ route('sms-template.index') }}">{{__('messages.sms_manager.sms_templates')}}</a>
                        </li>
                    @elseif(Request::is('admin/system-information*'))
                        <li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0">
                            <a class="nav-link p-0 {{ Request::is('admin/system-information*') ? 'active' : '' }}"
                               href="{{ route('system.info.index') }}">{{__('messages.system_information.system_information')}}</a>
                        </li>
                    @elseif(Request::is('admin/custom-css*'))
                        <li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0">
                            <a class="nav-link p-0 {{ Request::is('admin/custom-css*') ? 'active' : '' }}"
                               href="{{ route('system.info.index') }}">{{__('messages.common.custom_css')}}</a>
                        </li>
                    @elseif(Request::is('admin/blog*','admin/faqs*','admin/partner*','admin/social-icon','admin/social-icon*','admin/company-policy*','admin/front-settings*'))
                        <li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 me-xl-3">
                            <a class="nav-link p-0 {{ Request::is('admin/blog*') ? 'active' : '' }}"
                               href="{{ route('blog.index') }}">{{__('messages.common.blog')}}</a>
                        </li>
                        <li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 me-xl-3">
                            <a class="nav-link p-0 {{ Request::is('admin/faqs*') ? 'active' : '' }}"
                               href="{{ route('faqs.index') }}">{{__('messages.faqs.faq')}}</a>
                        </li>
                        <li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 me-xl-3">
                            <a class="nav-link p-0 {{ Request::is('admin/partner*') ? 'active' : '' }}"
                               href="{{ route('partner.index') }}">{{__('messages.common.partner')}}</a>
                        </li>
                        <li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 me-xl-3">
                            <a class="nav-link p-0 {{ Request::is('admin/social-icon*') ? 'active' : '' }}"
                               href="{{ route('social-icon.index') }}">{{__('messages.common.social_icon')}}</a>
                        </li>
                        <li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 me-xl-3">
                            <a class="nav-link p-0 {{ Request::is('admin/company-policy*') ? 'active' : '' }}"
                               href="{{ route('company-policy.index') }}">{{__('messages.common.company_policy')}}</a>
                        </li>
                        <li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 me-xl-3">
                            <a class="nav-link p-0 {{ Request::is('admin/front-settings') ? 'active' : '' }}"
                               href="{{ route('front.settings.index') }}">{{ __('messages.front_settings.cms') }}</a>
                        </li>
                    @elseif(Request::is('admin/transaction*'))
                        <li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0">
                            <a class="nav-link p-0 {{ Request::is('admin/transaction*') ? 'active' : '' }}"
                               href="{{ route('show-all-deposit') }}">{{__('messages.deposit.transaction')}}</a>
                        </li>
                    @elseif(Request::is('admin/withdraw-request*'))
                        <li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0">
                            <a class="nav-link p-0 {{ Request::is('admin/withdraw-request*') ? 'active' : '' }}"
                               href="{{ route('show-all-withdraw-request') }}">{{__('messages.withdraw.withdraw_requests')}}</a>
                        </li>
                    @elseif(Request::is('admin/payment-gateways*'))
                        <li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0">
                            <a class="nav-link p-0 {{ Request::is('admin/payment-gateways*') ? 'active' : '' }}"
                               href="{{ route('payment-gateways.index') }}">{{__('messages.common.payment_gateways')}}</a>
                        </li>
                    @elseif(Request::is('admin/referrals*'))
                        <li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0">
                            <a class="nav-link p-0 {{ Request::is('admin/referrals*') ? 'active' : '' }}"
                               href="{{ route('referrals.index') }}">{{__('messages.referral.referrals')}}</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    <ul class="nav align-items-stretch flex-nowrap">

        <li class="px-xxl-3 px-2 mt-6">

            @if(Auth::user()->theme_mode)
                <a href="javascript:void(0)" title="Switch to Dark mode"><i
                            class="fa-solid fa-moon text-primary fs-2 apply-dark-mode"></i></a>
            @else
                <a href="javascript:void(0)" title="Switch to Light mode"><i
                            class="fa-solid fa-sun text-primary fs-2 apply-dark-mode"></i></a>
            @endif
        </li>
        <li class="px-xxl-3 px-2 d-flex align-items-stretch">
            <div class="dropdown dropdown-transparent d-flex align-items-stretch">
                <button class="btn dropdown-toggle px-0 text-gray-600 d-flex align-items-center" type="button"
                        id="dropdownMenuButton1"
                        data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                    <div class="image image-circle image-mini d-flex align-items-center me-sm-3">
                        <img src="{{ getLogInUser() ? getLogInUser()->profile_image : asset('images/avatar.png')}}"
                             class="img-fluid" alt="profile image">
                    </div>
                    {{ getLogInUser()->full_name }}
                    <i class="fa-solid fa-angle-down ms-2"></i>
                </button>
                <div class="dropdown-menu py-7 pb-4" aria-labelledby="dropdownMenuButton1">
                    <div class="text-center border-bottom pb-5 ">
                        <div class="image image-circle image-tiny mb-5">
                            <img src="{{ getLogInUser() ? getLogInUser()->profile_image : asset('images/avatar.png')}}" class="img-fluid" alt="profile image">
                        </div>
                        <h3 class="text-gray-900"> {{ getLogInUser()->full_name }}</h3>
                        <h4 class="mb-0 fw-400 fs-6"> {{ getLogInUser()->email }}</h4>
                    </div>
                    <ul class="pt-4">
                        <li>
                            <a class="dropdown-item text-gray-900" href="{{route('profile.setting')}}">
                                <span class="dropdown-icon me-4 text-gray-600">
                                    <i class="fa-solid fa-user"></i>
                                </span>
                                {{ __('messages.user.edit_profile') }}
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item text-gray-900" href="javascript:void(0)"
                               data-bs-toggle="modal"
                               data-bs-target="#changePasswordModal">
                                <span class="dropdown-icon me-4 text-gray-600">
                                    <i class="fa-solid fa-lock"></i>
                                </span>
                                {{ __('messages.user.change_password') }}
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item text-gray-900" id="changeLanguage" href="javascript:void(0)">
                               <span class="dropdown-icon me-4 text-gray-600">
                                   <i class="fa-solid fa-globe"></i>
                               </span>
                                {{ __('messages.user.change_language') }}
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item text-gray-900" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); localStorage.clear();  document.getElementById('logout-form').submit();">
                                <span class="dropdown-icon me-4 text-gray-600">
                                    <i class="fa-solid fa-right-from-bracket"></i>
                                </span>
                                {{ __('messages.user.logout') }}
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    {{ csrf_field() }}
                                </form>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </li>

        <li class="d-flex align-items-center">
            <button type="button" class="btn px-0 d-block d-xl-none header-btn pb-2">
                <i class="fa-solid fa-bars fs-1"></i>
            </button>
        </li>
    </ul>
</header>
<div class="bg-overlay" id="nav-overly"></div>
