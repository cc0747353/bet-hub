<?php

namespace App\Http\Livewire;

use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Currency;

class CurrenciesTable extends LivewireTableComponent
{
    protected $model = Currency::class;
    public $showButtonOnHeader = true;
    public $buttonComponent = 'currencies.add_button';
    protected $listeners = ['refresh' => '$refresh', 'resetPage'];

    public function configure(): void
    {
        $this->setPrimaryKey('id')
        ->setDefaultSort('currency.created_at', 'desc')
        ->setQueryStringStatus(false);
    }

    public function columns(): array
    {
        return [
            Column::make( __('messages.currency.currency_name'), "currency_name")
                ->view('currencies.columns.currency_name')
                ->sortable(),
            Column::make( __('messages.currency.currency_icon'), "currency_icon")
                ->view('currencies.columns.currency_icon')
                ->sortable(),
            Column::make( __('messages.currency.currency_code'), "currency_code")
                ->view('currencies.columns.currency_code')
                ->sortable(),
            Column::make( __('messages.common.action'), "id")
                ->view('currencies.columns.action'),
        ];
    }
    
    
}
