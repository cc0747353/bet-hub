<?php

namespace App\Http\Livewire;

use App\Models\UserReferralsLevel;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;

class UsersReferralLevelTable extends LivewireTableComponent
{
    protected $model = UserReferralsLevel::class;
    public $showButtonOnHeader = false;
    public $buttonComponent = false;
    protected $listeners = ['refresh' => '$refresh', 'resetPage'];

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setDefaultSort('user_referrals_level.created_at', 'desc')
            ->setQueryStringStatus(false);
    }

    public function columns(): array
    {
        return [
            Column::make( __('messages.referral.user'), "referral_to_id")
                ->view('users_referral.column.user')
                ->sortable(),
            Column::make(__('messages.referral.level'), "level")
                ->view('users_referral.column.level')
                ->sortable(),
            Column::make(__('messages.referral.type'), "type")
                ->view('users_referral.column.type')
                ->sortable(),
            Column::make(__('messages.referral.commission').'(%)', "commission")
                ->view('users_referral.column.commission')
                ->sortable(),
            Column::make(__('messages.referral.referral_date'), "created_at")
                ->view('users_referral.column.created_at')
                ->sortable(),
         
        ];
    }
    public function builder(): Builder
    {
        return UserReferralsLevel::whereUserId(getLogInUserId());
    }

}
