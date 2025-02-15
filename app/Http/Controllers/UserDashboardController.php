<?php

namespace App\Http\Controllers;

use App\Models\Bet;
use App\Models\DepositTransaction;
use App\Models\WithdrawRequests;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class UserDashboardController extends Controller
{
    public function index(): Factory|View|Application
    {
        $user_available_balance = getTotalBalance();
        $deposit = DepositTransaction::whereUserId(getLogInUserId())->where('status',
            DepositTransaction::SUCCESS)->sum('deposit_amount');
        $withdraw = WithdrawRequests::whereUserId(getLogInUserId())->where('status',
            WithdrawRequests::APPROVED)->sum('amount');
        $bet = Bet::whereUserId(getLogInUserId())->count();
        $bet_win = Bet::whereUserId(getLogInUserId())->whereStatus(Bet::WINNER)->count();
        $bet_lose = Bet::whereUserId(getLogInUserId())->whereStatus(Bet::LOSER)->count();
        $bet_amount = Bet::whereUserId(getLogInUserId())->sum('amount');
        $bet_win_amount = Bet::whereUserId(getLogInUserId())->whereStatus(Bet::WINNER)->sum('win_amount');
        $bet_lost_amount = Bet::whereUserId(getLogInUserId())->whereStatus(Bet::LOSER)->sum('amount');

        return view('dashboard.user_dashboard', compact('user_available_balance', 'withdraw', 'bet', 'bet_amount', 'bet_win', 'bet_lose', 'bet_win_amount', 'deposit', 'bet_lost_amount'));
    }
}
