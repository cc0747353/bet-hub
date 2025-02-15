<?php

namespace App\Http\Livewire;

use App\Models\UserReferralsCommission;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;

class ReferralDepositCommissionTable extends LivewireTableComponent
{
    protected $model = UserReferralsCommission::class;
    public $showButtonOnHeader = true;
    public $buttonComponent = 'referrals_deposit_commission.column.level-count';
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
            Column::make( __('messages.referral.referral_by'), "referral_by_id")
                ->view('referrals_deposit_commission.column.referral_by')
                ->sortable(),
            Column::make( __('messages.referral.referral_to'), "referral_to_id")
                ->view('referrals_deposit_commission.column.referral_to')
                ->sortable(),
            Column::make(__('messages.referral.type'), "type")
                ->view('referrals_deposit_commission.column.type')
                ->sortable(),
            Column::make(__('messages.referral.commission'), "deposit_id")
                ->view('referrals_deposit_commission.column.deposit')
                ->sortable(),
            Column::make(__('messages.referral.referral_date'), "created_at")
                ->view('referrals_deposit_commission.column.created_at')
                ->sortable(),

        ];
    }
    public function builder(): Builder
    {
        return UserReferralsCommission::whereReferralById(getLogInUserId())->whereType(UserReferralsCommission::DEPOSIT_COMMISSION);
    }

}
