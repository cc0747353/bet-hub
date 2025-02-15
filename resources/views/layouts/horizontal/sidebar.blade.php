<div class="ps-xl-7 px-2 pe-xl-0 d-flex align-items-stretch">
    <ul class="horizontal-menu nav flex-row d-block d-xl-flex">
        <li class="nav-item {{ Request::is('user/dashboard') ? 'active' : '' }}">
            <a class="nav-link d-flex align-items-center py-3" aria-current="page"
               href="{{ route('user.dashboard') }}">
                <span class="aside-menu-icon pe-3"><i class="fa-solid fa-chart-pie"></i></span>
                <span class="aside-menu-title">{{ __('messages.common.dashboard') }}</span>
            </a>
        </li>
        <li class="nav-item {{ Request::is('user/deposit-transaction*','user/deposit-amount*') ? 'active' : '' }}">
            <a class="nav-link d-flex align-items-center py-3" aria-current="page"
               href="{{route('user.deposit-transaction.index')}}">
                <span class="aside-menu-icon pe-3"><i class="fa-sharp fa-solid fa-money-bill"></i></span>
                <span class="aside-menu-title">{{__('messages.deposit.deposit')}}</span>
            </a>
        </li>
        <li class="nav-item {{ Request::is('user/withdraw*') ? 'active' : '' }}">
            <a class="nav-link d-flex align-items-center py-3" aria-current="page"
               href="{{route('user.withdraw-transaction.index')}}">
                <span class="aside-menu-icon pe-3"><i class="fa-solid fa-money-bill-transfer"></i></span>
                <span class="aside-menu-title">{{__('messages.common.withdraw')}}</span>
            </a>
        </li>
        <li class="nav-item {{ Request::is('user/users-referrals-level', 'user/referrals-deposit-commission', 'user/referrals-bet-place-commission', 'user/referrals-bet-win-commission') ? 'active' : '' }}">
            <a class="nav-link d-flex align-items-center py-3" aria-current="page"
               href="{{route('user.referrals_deposit_commission')}}">
                <span class="aside-menu-icon pe-3"><i class="fa-solid fa-user-plus"></i></span>
                <span class="aside-menu-title">{{__('messages.common.referrals')}}</span>
            </a>
        </li>
        <li class="nav-item {{ Request::is('user/bets-details') ? 'active' : '' }}">
            <a class="nav-link d-flex align-items-center py-3" aria-current="page"
               href="{{route('user.bets-details')}}">
                <span class="aside-menu-icon pe-3"><i class="fa-sharp fa-solid fa-users-between-lines"></i></span>
                <span class="aside-menu-title">{{__('messages.common.bets')}}</span>
            </a>
        </li>
    </ul>
</div>
