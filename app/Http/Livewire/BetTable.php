<?php

namespace App\Http\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Bet;

class BetTable extends LivewireTableComponent
{
    protected $model = Bet::class;
    protected $listeners = ['refresh' => '$refresh', 'resetPage'];

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setDefaultSort('bets.created_at', 'desc')
            ->setQueryStringStatus(false);
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.referral.user'), "user.first_name")
                ->view('bets.columns.user_name')
                ->searchable()
                ->sortable(),
            Column::make(__('messages.bets.match'), "match_id")
                ->view('bets.columns.matches')
                ->searchable()
                ->sortable(),
            Column::make(__('messages.bets.question'), "question_id")
                ->view('bets.columns.question'),
            Column::make(__('messages.bets.option'), "option_id")
                ->view('bets.columns.option-name'),
            Column::make(__('messages.bets.rate'), "option_id")
                ->view('bets.columns.option-rate')
                ->sortable(),
            Column::make('currency', "currency_id")->hideIf(true),
            Column::make(__('messages.bets.invest'), "amount")
                ->view('bets.columns.invest-amount')
                ->searchable()
                ->sortable(),
            Column::make(__('messages.bets.return'), "win_amount")
                ->view('bets.columns.return-amount'),
            Column::make(__('messages.bets.status'), "status")
                ->view('bets.columns.status'),
            Column::make( __('messages.referral.user'), "user_id")
                ->hideIf('user_id'),
        ];
    }

}
