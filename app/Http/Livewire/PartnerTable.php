<?php

namespace App\Http\Livewire;

use App\Models\Partner;
use Rappasoft\LaravelLivewireTables\Views\Column;

class PartnerTable extends LivewireTableComponent
{
    protected $model = Partner::class;
    public $showButtonOnHeader = true;
    public $buttonComponent = 'partner.add-button';
    protected $listeners = ['refresh' => '$refresh', 'resetPage'];

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setDefaultSort('partners.created_at', 'desc')
            ->setQueryStringStatus(false);
    }

    public function columns(): array
    {
        return [
            Column::make( __('messages.partner.image'), "id")
                ->view('partner.columns.image'),
            Column::make( __('messages.partner.name'), "name")
                ->searchable()
                ->view('partner.columns.name')
                ->sortable(),
            Column::make( __('messages.partner.action'), "created_at")
                ->view('partner.columns.action'),
        ];
    }
}
