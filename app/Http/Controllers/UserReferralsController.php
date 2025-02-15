<?php

namespace App\Http\Controllers;


use App\Models\UserReferralsLevel;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class UserReferralsController extends Controller
{
    /**
     *
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('users_referral.user_referral_level');
    }

    /**
     *
     *
     * @return Application|Factory|View
     */
    public function referralsDepositCommission()
    {

        return view('referrals_deposit_commission.index');
    }

    /**
     *
     *
     * @return Application|Factory|View
     */
    public function referralsBetPlaceCommission()
    {
        return view('referrals_bet_place_commission.index');
    }

    /**
     *
     *
     * @return Application|Factory|View
     */
    public function referralsBetWinCommission()
    {
        return view('referrals_bet_win_commission.index');
    }
}
