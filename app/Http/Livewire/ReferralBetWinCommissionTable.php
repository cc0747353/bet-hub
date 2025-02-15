<?php

namespace App\Http\Livewire;

use App\Models\UserReferralsCommission;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;

class ReferralBetWinCommissionTable extends LivewireTableComponent
{
    protected $model = UserReferralsCommission::class;
    public $showButtonOnHeader = true;
    public $buttonComponent = 'referrals_bet_win_commission.column.bet-win-level-count';
    protected $listeners = ['refresh' => '$refresh', 'resetPage'];

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setDefaultSort('user_referrals_commission.created_at', 'desc')
            ->setQueryStringStatus(false);
    }

    public function columns(): array
    {
        return [
            Column::make( __('referral by'), "referral_by_id")
                ->view('referrals_bet_win_commission.column.referral_by')
                ->sortable(),
            Column::make( __('referral to'), "referral_to_id")
                ->view('referrals_bet_win_commission.column.referral_to')
                ->sortable(),
            Column::make("type", "type")
                ->view('referrals_bet_win_commission.column.type')
                ->sortable(),
            Column::make("commission", "deposit_id")
                ->view('referrals_bet_win_commission.column.deposit')
                ->sortable(),
            Column::make("referral date", "created_at")
                ->view('referrals_bet_win_commission.column.created_at')
                ->sortable(),

        ];
    }
    public function builder(): Builder
    {
        return UserReferralsCommission::whereReferralById(getLogInUserId())->whereType(UserReferralsCommission::BET_WIN_COMMISSION);
    }

}
