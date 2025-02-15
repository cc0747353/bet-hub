<?php

namespace App\Http\Livewire;

use App\Models\WithdrawRequests;
use App\Models\AdminWithdrawRequest;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;

class UserWithdrawRequestTable extends LivewireTableComponent
{
    protected $model = WithdrawRequests::class;
    public $showButtonOnHeader = true;
    public $buttonComponent = 'withdraw_request.add_button';
    protected $listeners = ['refresh' => '$refresh', 'resetPage'];

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setDefaultSort('withdraw_requests.created_at', 'desc')
            ->setQueryStringStatus(false);
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.withdraw.amount'), "amount")
                ->view('withdraw_request.column.amount')
                ->sortable()
            ->searchable(),
            Column::make(__('messages.deposit.notes'), "user_notes")
                ->view('withdraw_request.column.user_notes')
                ->sortable()
            ->searchable(),
            Column::make(__('messages.email_template.message'), "notes")
                ->view('withdraw_request.column.notes')
                ->sortable(),
            Column::make(__('messages.deposit.attachment'), "id")
                ->view('withdraw_request.column.attachment'),
            Column::make(__('messages.withdraw.method'), "method")
                ->view('withdraw_request.column.method')
                ->sortable(),
            Column::make(__('messages.withdraw.status'), "status")
                ->view('withdraw_request.column.status')
                ->sortable(),
            Column::make(__('messages.withdraw.created_at'), "created_at")
                ->view('withdraw_request.column.created_at')
                ->sortable()
                ->searchable(),
        ];
    }
    public function builder(): Builder
    {
        return WithdrawRequests::with('media')->whereUserId(getLogInUserId());
    }

}
