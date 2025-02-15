<?php

namespace App\Http\Livewire;

use App\Models\PaymentGateway;
use Rappasoft\LaravelLivewireTables\Views\Column;

class PaymentGatewaysTable extends LivewireTableComponent
{
    protected $model = PaymentGateway::class;
//    public $showButtonOnHeader = true;
//    public $buttonComponent = false;
    protected $listeners = ['refresh' => '$refresh', 'resetPage'];

    public function configure(): void
    {
        $this->setPrimaryKey('id');
//            ->setDefaultSort('payment_gateway.created_at', 'desc')
//            ->setQueryStringStatus(false);
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.common.name'), "name")
                ->searchable()
                ->view('payment_gateways.columns.name')
                ->sortable(),
            Column::make(__('messages.common.status'), "status")
                ->searchable()
                ->view('payment_gateways.columns.status')
                ->sortable(),
            Column::make(__('messages.matches.action'), "id")
                ->view('payment_gateways.columns.action'),

        ];
    }
}
