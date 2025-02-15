<div class="d-flex flex-column">
    <div class="row mb-5">
        <div class="col-lg-12">
            @include('flash::message')
            @include('layouts.errors')
        </div>
        <div class="col-md-10 mb-2">
            <div class="card-toolbar ms-auto">
                <div class="d-flex">
                    <input type="text" readonly title="{{route('referral_url', getLogInUser()->user_name)}}"
                           class="form-control d-flex align-items-end me-2 url"
                           value="{{route('referral_url', getLogInUser()->user_name)}}">
                </div>
            </div>
        </div>
        <div class="col-sm-2">
            <a type="button" href="javascript:void(0)"
               class="btn btn-primary copy-referral-url minw-120">{{ __('messages.referral.copy_url') }}</a>
        </div>
    </div>
    <ul class="horizontal-menu nav flex-row d-block d-xl-flex mb-5">
{{--        <li class="nav-item {{ Request::is('user/users-referrals-level') ? 'bg-primary rounded' : '' }}">--}}
{{--            <a class="nav-link d-flex align-items-center py-3 {{ Request::is('user/users-referrals-level') ? 'text-white' : '' }}" aria-current="page"--}}
{{--               href="{{ route('user.users_referrals_level') }}">--}}
{{--                <span class="aside-menu-icon pe-3"><i class="fa-solid fa-database"></i></span>--}}
{{--                <span class="aside-menu-title">{{ __('messages.referral.referral_level') }}</span>--}}
{{--            </a>--}}
{{--        </li>--}}
        <li class="nav-item {{ Request::is('user/referrals-deposit-commission') ? 'bg-primary rounded' : '' }}">
            <a class="nav-link d-flex align-items-center py-3 {{ Request::is('user/referrals-deposit-commission') ? 'text-white' : '' }}" aria-current="page"
               href="{{ route('user.referrals_deposit_commission') }}">
                <span class="aside-menu-icon pe-3"><i class="fa-solid fa-comments-dollar"></i></span>
                <span class="aside-menu-title">{{ __('messages.referral.deposit_commission') }}</span>
            </a>
        </li>
        <li class="nav-item {{ Request::is('user/referrals-bet-place-commission') ? 'bg-primary rounded' : '' }}">
            <a class="nav-link d-flex align-items-center py-3 {{ Request::is('user/referrals-bet-place-commission') ? 'text-white' : '' }}" aria-current="page"
               href="{{ route('user.referrals_bet_place_commission') }}">
                <span class="aside-menu-icon pe-3"><i class="fa-solid fa-comments-dollar"></i></span>
                <span class="aside-menu-title">{{ __('messages.referral.bet_place_commission') }}</span>
            </a>
        </li>
        <li class="nav-item {{ Request::is('user/referrals-bet-win-commission') ? 'bg-primary rounded' : '' }}">
            <a class="nav-link d-flex align-items-center py-3 {{ Request::is('user/referrals-bet-win-commission') ? 'text-white' : '' }}" aria-current="page"
               href="{{ route('user.referrals_bet_win_commission') }}">
                <span class="aside-menu-icon pe-3"><i class="fa-solid fa-comments-dollar"></i></span>
                <span class="aside-menu-title">{{ __('messages.referral.bet_win_commission') }}</span>
            </a>
        </li>

    </ul>
</div>


