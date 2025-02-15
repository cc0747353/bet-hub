<?php

namespace App\Http\Livewire;

use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Language;

class LanguageTable extends LivewireTableComponent
{
    protected $model = Language::class;
    public $showButtonOnHeader = true;
    public $buttonComponent = 'languages.add-button';
    protected $listeners = ['refresh' => '$refresh', 'resetPage'];

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setDefaultSort('language.created_at', 'desc');
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.languages.name'), "name")
                ->view('languages.columns.name')
                ->sortable()
                ->searchable(),
            Column::make(__('messages.languages.iso_code'), "iso_code")
                ->view('languages.columns.iso_code')
                ->sortable()
                ->searchable(),
            Column::make(__('messages.languages.translation'), "id")
                ->view('languages.columns.translation')
                ->sortable(),
            Column::make(__('messages.common.action'), "updated_at")
                ->view('languages.columns.action'),
        ];
    }
}
