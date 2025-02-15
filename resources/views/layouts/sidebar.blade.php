<div class="aside-menu-container" id="sidebar">
    <div class="aside-menu-container__aside-logo flex-column-auto">
        <a href="/" class="text-decoration-none sidebar-logo d-flex align-items-center" data-turbo="false">
            <div class="image w-40 me-3">
                <img src="{{ asset(getAppLogo()) }}"
                     class="web-logo" alt="profile image">
            </div>
            <span class="text-gray-900 fs-4">{{ getAppName() }}</span>
        </a>
        <button type="button"
                class="btn px-0 text-gray-600 aside-menu-container__aside-menubar d-lg-block d-none sidebar-btn">
            <i class="fa-solid fa-bars fs-1"></i>
        </button>
    </div>
    <form class="d-flex position-relative aside-menu-container__aside-search search-control py-3 mt-1">
        <div class="position-relative w-100">
            <input class="form-control" type="search" placeholder="{{ __('messages.common.search') }}" id="menuSearch"
                   aria-label="Search">
            <span class="aside-menu-container__search-icon position-absolute d-flex align-items-center top-0 bottom-0">
                <i class="fa-solid fa-magnifying-glass"></i>
            </span>
        </div>
    </form>
    <div class="no-record text-center d-none">{{ __('No matching records found') }}</div>
    <div class="sidebar-scrolling">
        <ul class="aside-menu-container__aside-menu nav flex-column">

            <li class="nav-item {{ Request::is('admin/dashboard') ? 'active' : '' }}">
                <a class="nav-link d-flex align-items-center py-3" aria-current="page"
                   href="{{ route('admin.dashboard') }}">
                    <span class="aside-menu-icon pe-3"><i class="fa-solid fa-chart-pie"></i></span>
                    <span class="aside-menu-title">{{ __('messages.common.dashboard') }}</span>
                </a>
            </li>

            @can('manage_users')
                <li class="nav-item {{ Request::is('admin/users*') ? 'active' : '' }}">
                    <a class="nav-link d-flex align-items-center py-3" aria-current="page"
                       href="{{route('users.index')}}">
                        <span class="aside-menu-icon pe-3"><i class="fas fa-users"></i></span>
                        <span class="aside-menu-title">{{__('messages.user.users')}}</span>
                    </a>
                </li>
            @endcan

            @can('manage_categories')
                <li class="nav-item {{ Request::is('admin/categories') ? 'active' : '' }}">
                    <a class="nav-link d-flex align-items-center py-3" aria-current="page"
                       href="{{route('categories.index')}}">
                        <span class="aside-menu-icon pe-3"><i class="fa-solid fa-bars"></i></span>
                        <span class="aside-menu-title">{{ __('messages.common.categories') }}</span>
                    </a>
                </li>
            @endcan

            @can('manage_leagues')
                <li class="nav-item {{ Request::is('admin/leagues') ? 'active' : '' }}">
                    <a class="nav-link d-flex align-items-center py-3" aria-current="page"
                       href="{{route('leagues.index')}}">
                        <span class="aside-menu-icon pe-3"><i class="fa-solid fa-baseball"></i></span>
                        <span class="aside-menu-title">{{ __('messages.common.leagues') }}</span>
                    </a>
                </li>
            @endcan

            @can('manage_matches')
                <li class="nav-item {{ Request::is('admin/all-matches*', 'admin/questions*', 'admin/options*') ? 'active' : '' }}">
                    <a class="nav-link d-flex align-items-center py-3"
                       href="{{ route('all-matches.index') }}">
                        <span class="aside-menu-icon pe-3"><i class="fa-solid fa-gamepad"></i></span>
                        <span class="aside-menu-title">{{ __('messages.common.matches') }}</span>
                    </a>
                </li>
            @endcan

            @can('manage_bets')
                <li class="nav-item {{ Request::is('admin/bets*') ? 'active' : '' }}">
                    <a class="nav-link d-flex align-items-center py-3"
                       href="{{ route('bets.index') }}">    
                        <span class="aside-menu-icon pe-3"><i class="fa-solid fa-chess-board"></i></span>
                        <span class="aside-menu-title">{{ __('messages.bets.bets') }}</span>
                    </a>
                </li>
            @endcan

            @can('manage_referrals')
                <li class="nav-item {{ Request::is('admin/referrals') ? 'active' : '' }}">
                    <a class="nav-link d-flex align-items-center py-3" aria-current="page"
                       href="{{route('referrals.index')}}">
                        <span class="aside-menu-icon pe-3"><i class="fas fa-users-between-lines"></i></span>
                        <span class="aside-menu-title">{{__('messages.referral.referrals')}}</span>
                    </a>
                </li>
            @endcan

            @can('manage_deposit')
                <li class="nav-item {{ Request::is('admin/transaction*') ? 'active' : '' }}">
                    <a class="nav-link d-flex align-items-center py-3"
                       href="{{ route('show-all-deposit') }}">
                        <span class="aside-menu-icon pe-3"><i class="fa-sharp fa-solid fa-money-bill"></i></span>
                        <span class="aside-menu-title">{{__('messages.deposit.manage_transactions')}}</span>
                    </a>
                </li>
            @endcan
            
            @can('manage_withdraw_request')
            <li class="nav-item {{ Request::is('admin/withdraw-request*') ? 'active' : '' }}">
                <a class="nav-link d-flex align-items-center py-3"
                   href="{{ route('show-all-withdraw-request') }}">
                    <span class="aside-menu-icon pe-3"><i class="fa-solid fa-money-bill-transfer"></i></span>
                    <span class="aside-menu-title">{{__('messages.withdraw.withdraw_requests')}}</span>
                </a>
            </li>
            @endcan
            
            @can('manage_payment_gateways')
                <li class="nav-item {{ Request::is('admin/payment-gateways*') ? 'active' : '' }}">
                    <a class="nav-link d-flex align-items-center py-3" aria-current="page"
                       href="{{route('payment-gateways.index')}}">
                        <span class="aside-menu-icon pe-3"><i class="fa-solid fa-credit-card"></i></span>
                        <span class="aside-menu-title">{{__('messages.common.payment_gateways')}}</span>
                    </a>
                </li>
            @endcan

            @can('manage_email_template')
                <li class="nav-item {{ Request::is('admin/email-template*') ? 'active' : '' }}">
                    <a class="nav-link d-flex align-items-center py-3"
                       href="{{ route('email.template.index') }}">
                        <span class="aside-menu-icon pe-3"><i class="fa-solid fa-envelope"></i></span>
                        <span class="aside-menu-title">{{__('messages.email_template.email_manager')}}</span>
                    </a>
                </li>
            @endcan

            @can('manage_sms_template')
                <li class="nav-item {{ Request::is('admin/sms-template*') ? 'active' : '' }}">
                    <a class="nav-link d-flex align-items-center py-3"
                       href="{{ route('sms.gateways.index') }}">
                        <span class="aside-menu-icon pe-3"><i class="fa-solid fa-sms"></i></span>
                        <span class="aside-menu-title">{{ __('messages.sms_manager.sms_manager') }}</span>
                    </a>
                </li>
            @endcan

            @can('manage_languages')
                <li class="nav-item {{ Request::is('admin/languages*') ? 'active' : '' }}">
                    <a class="nav-link d-flex align-items-center py-3" aria-current="page"
                       href="{{route('languages.index')}}">
                        <span class="aside-menu-icon pe-3"><i class="fa fa-language"></i></span>
                        <span class="aside-menu-title">{{__('messages.languages.language')}}</span>
                    </a>
                </li>
            @endcan

            @can('manage_cms')
                <li class="nav-item {{ Request::is('admin/blog*','admin/faqs*','admin/partner*','admin/social-icon','admin/company-policy*','admin/front-settings*') ? 'active' : '' }}">
                    <a class="nav-link d-flex align-items-center py-3"
                       href="{{ route('blog.index') }}">
                        <span class="aside-menu-icon pe-3"><i class="fa-solid fa-mobile"></i></span>
                        <span class="aside-menu-title">{{ __('messages.common.cms') }}</span>
                    </a>
                </li>
            @endcan

            @can('manage_custom_css')
                <li class="nav-item {{ Request::is('admin/custom-css') ? 'active' : '' }}">
                    <a class="nav-link d-flex align-items-center py-3" aria-current="page"
                       href="{{route('custom-css.index')}}">
                        <span class="aside-menu-icon pe-3"><i class="fa-solid fa-border-style"></i></span>
                        <span class="aside-menu-title">{{__('messages.common.custom_css')}}</span>
                    </a>
                </li>
            @endcan

            @can('manage_seo_tools')
                <li class="nav-item {{ Request::is('admin/seo-tools') ? 'active' : '' }}">
                    <a class="nav-link d-flex align-items-center py-3" aria-current="page"
                       href="{{route('seo-tools.index')}}">
                        <span class="aside-menu-icon pe-3"><i class="fas fa-wrench fs-4"></i></span>
                        <span class="aside-menu-title">{{__('messages.seo-tool.seo_tool')}}</span>
                    </a>
                </li>
            @endcan

            @can('manage_roles')
                <li class="nav-item {{ Request::is('admin/roles*') ? 'active' : '' }}">
                    <a class="nav-link d-flex align-items-center py-3" aria-current="page"
                       href="{{route('roles.index')}}">
                        <span class="aside-menu-icon pe-3"><i class="fa fa-user"></i></span>
                        <span class="aside-menu-title">{{__('messages.role.role')}}</span>
                    </a>
                </li>
            @endcan

            @can('manage_news_letter')
                <li class="nav-item {{ Request::is('admin/news-letter*') ? 'active' : '' }}">
                    <a class="nav-link d-flex align-items-center py-3" aria-current="page"
                       href="{{route('news-letter.index')}}">
                        <span class="aside-menu-icon pe-3"><i class="fa fa-envelope-open"></i></span>
                        <span class="aside-menu-title">{{__('messages.common.news_letters')}}</span>
                    </a>
                </li>
            @endcan

            @can('manage_settings')
                <li class="nav-item {{ Request::is('admin/settings', 'admin/currencies', 'admin/cookie', 'admin/payment-method') ? 'active' : '' }}">
                    <a class="nav-link d-flex align-items-center py-3" aria-current="page"
                       href="{{route('settings.index')}}">
                        <span class="aside-menu-icon pe-3"><i class="fas fa-cog fs-4"></i></span>
                        <span class="aside-menu-title">{{__('messages.setting.setting')}}</span>
                    </a>
                </li>
            @endcan

            @can('manage_system_information')
                <li class="nav-item {{ Request::is('admin/system-information') ? 'active' : '' }}">
                    <a class="nav-link d-flex align-items-center py-3" aria-current="page"
                       href="{{route('system.info.index')}}">
                        <span class="aside-menu-icon pe-3"><i class="fa-sharp fa-solid fa-robot"></i></span>
                        <span class="aside-menu-title">{{__('messages.system_information.system_information')}}</span>
                    </a>
                </li>
            @endcan

        </ul>
    </div>
</div>
<div class="bg-overlay" id="sidebar-overly"></div>
