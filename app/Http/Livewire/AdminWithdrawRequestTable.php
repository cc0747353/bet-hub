<?php

namespace App\Http\Livewire;

use App\Models\AdminWithdrawRequest;
use App\Models\WithdrawRequests;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;

class AdminWithdrawRequestTable extends LivewireTableComponent
{
    protected $model = WithdrawRequests::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setDefaultSort('withdraw_requests.created_at', 'desc')
            ->setQueryStringStatus(false);
    }

    public function columns(): array
    {
        return [
            Column::make( __('messages.transaction.withdraw_req'), "user.first_name")
                ->view('admin_withdraw_request.column.user')
                ->sortable()
                ->searchable(),
            Column::make( __('messages.transaction.withdraw_req'), "user_id")
            ->hideIf('user_id'),
            Column::make( __('messages.transaction.amount'), "amount")
                ->view('admin_withdraw_request.column.amount')
                ->sortable()
                ->searchable(),
            Column::make( __('messages.transaction.method'), "method")
                ->view('admin_withdraw_request.column.method')
                ->sortable(),
            Column::make( __('messages.transaction.status'), "status")
                ->view('admin_withdraw_request.column.status'),
            Column::make(__('messages.common.created_at'), "created_at")
                ->view('admin_withdraw_request.column.created_at')
                ->searchable()
                ->sortable(),
            Column::make( __('messages.common.action'), "id")
                ->view('admin_withdraw_request.column.action'),
            
        ];
    }
    public function builder(): Builder
    {
        return WithdrawRequests::with('user');
    }
}
