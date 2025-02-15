<?php

namespace App\Http\Livewire;

use App\Models\PaymentGateway;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\DepositTransaction;

class TransactionTable extends LivewireTableComponent
{
    protected $model = DepositTransaction::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setDefaultSort('deposit_payment_transactions.created_at', 'desc')
            ->setQueryStringStatus(false);
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.transaction.withdraw_req'), "user.first_name")
                ->view('transaction.column.user')
                ->sortable(function (Builder $query, $direction) {
                    return $query->orderBy(User::select('first_name')->whereColumn('deposit_payment_transactions.user_id',
                        'users.id'), $direction);
                })
                ->searchable(),
            Column::make(__('messages.transaction.withdraw_req'), "user_id")
                ->hideIf('user_id'),
            Column::make( __('messages.transaction.transaction_id'), "transaction_id")
                ->sortable(),
            Column::make( __('messages.transaction.amount'), "deposit_amount")
                ->view('transaction.column.amount')
                ->sortable()
                ->searchable(),
            Column::make( __('messages.transaction.type'), "type")
                ->view('transaction.column.type')
                ->sortable(),
            Column::make( __('messages.transaction.status'), "status")
                ->view('transaction.column.status')
                ->sortable(),
            Column::make(__('messages.common.created_at'), "created_at")
                ->view('transaction.column.created_at')
                ->sortable(),
            Column::make( __('messages.common.action'), "id")
                ->view('transaction.column.action'),
            Column::make( __('messages.common.action'), "currency_id")->hideIf(true),
        ];
    }
    
    public function builder(): Builder
    {
        return DepositTransaction::with('user','currency');
    }
}
