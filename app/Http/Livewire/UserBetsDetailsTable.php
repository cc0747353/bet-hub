<?php

namespace App\Http\Livewire;

use App\Models\Bet;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;

class UserBetsDetailsTable extends LivewireTableComponent
{
    protected $model = Bet::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make( __('messages.bets.match'), "match_id")
                ->view('user_bets_details.column.match')
                ->sortable(),
            Column::make( __('messages.bets.question'), "question_id")
                ->view('user_bets_details.column.question')
                ->sortable(),
            Column::make( __('messages.bets.option'), "option_id")
                ->view('user_bets_details.column.option')
                ->sortable(),
            Column::make( __('messages.bets.bet_amount'), "amount")
                ->view('user_bets_details.column.amount')
                ->sortable(),
            Column::make( __('messages.bets.reward_if_won'), "win_amount")
                ->view('user_bets_details.column.win_amount')
                ->sortable(),
            Column::make( __('messages.common.status'), "status")
                ->view('user_bets_details.column.status')
                ->sortable(),
        ];
    }

    public function builder(): Builder
    {
        return Bet::with('match','question','option')->whereUserId(getLogInUserId());
    }
}
