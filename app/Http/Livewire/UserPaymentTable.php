<?php

namespace App\Http\Livewire;

use App\Models\DepositTransaction;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;

class UserPaymentTable extends LivewireTableComponent
{
    protected $model = DepositTransaction::class;
    public $showButtonOnHeader = true;
    public $buttonComponent = 'deposit.add_button';
    protected $listeners = ['refresh' => '$refresh', 'resetPage'];

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setDefaultSort('deposit_payment_transactions.created_at', 'desc')
            ->setQueryStringStatus(false);
    }

    public function columns(): array
    {
        return [
           
            Column::make(__('messages.deposit.transaction_id'), "transaction_id")
                ->sortable(),
            Column::make(__('messages.deposit.amount'), "deposit_amount")
                ->view('deposit.column.amount')
                ->sortable(),
            Column::make(__('messages.deposit.type'), "type")
                ->view('deposit.column.type')
                ->sortable(),
            Column::make(__('messages.deposit.status'), "status")
                ->view('deposit.column.status')
                ->sortable(),
            Column::make(__('messages.deposit.created_at'), "created_at")
                ->view('deposit.column.created_at')
                ->sortable(),
         
        ];
    }
    public function builder(): Builder
    {
        return DepositTransaction::whereUserId(getLogInUserId());
    }

}
