<?php

namespace App\Http\Livewire;

use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\EmailTemplate;

class EmailTemplateTable extends LivewireTableComponent
{
    protected $model = EmailTemplate::class;
    protected $listeners = ['refresh' => '$refresh', 'resetPage'];

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setDefaultSort('email_templates.created_at', 'desc')
            ->setQueryStringStatus(false);
    }

    public function columns(): array
    {
        return [
            Column::make( __('messages.email_template.name'), "name")
                ->view('email_templates.templates.columns.name')
                ->searchable()
                ->sortable(),
            Column::make( __('messages.email_template.subject'), "subject")
                ->view('email_templates.templates.columns.subject')
                ->searchable()
                ->sortable(),
            Column::make(__('messages.email_template.status'), "status")
                ->view('email_templates.templates.columns.status')
                ->sortable(),
            Column::make( __('messages.common.action'), "id")
                ->view('email_templates.templates.columns.action_button'),
        ];
    }
}
