<?php

namespace App\Http\Livewire;

use App\Models\FAQs;
use Rappasoft\LaravelLivewireTables\Views\Column;

class FaqsTable extends LivewireTableComponent
{
    protected $model = FAQs::class;
    public $showButtonOnHeader = true;
    public $buttonComponent = 'faqs.add-button';
    protected $listeners = ['refresh' => '$refresh', 'resetPage'];

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setDefaultSort('faqs.created_at', 'desc')
            ->setQueryStringStatus(false);

        $this->setThAttributes(function(Column $column) {
            if ($column->isField('id')) {
                return [
                    'style' => 'width: 120px',
                ];
            }
            return [];
        });
    }

    public function columns(): array
    {
        return [
            Column::make( __('messages.faqs.question'), "question")
                ->searchable()
                ->view('faqs.columns.questions')
                ->sortable(),
            Column::make( __('messages.faqs.answer'), "answer")
                ->searchable()
                ->view('faqs.columns.answers')
                ->sortable(),
            Column::make( __('messages.faqs.status'), "status")
                ->view('faqs.columns.status'),
            Column::make( __('messages.faqs.action'), "id")
                ->view('faqs.columns.action'),

        ];
    }
}
