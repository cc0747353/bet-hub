<?php

namespace App\Http\Livewire;

use App\Models\SmsTemplate;
use Rappasoft\LaravelLivewireTables\Views\Column;

class SmsTemplateTable extends LivewireTableComponent
{
    protected $model = SmsTemplate::class;
    protected $listeners = ['refresh' => '$refresh', 'resetPage'];

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setDefaultSort('sms_templates.created_at', 'desc')
            ->setQueryStringStatus(false);
        
        $this->setThAttributes(function (Column $column) {
            if($column->isField('name'))
            {
                return [
                    'style' => 'width:50%',
                ];
            }
            if($column->isField('id'))
            {
                return [
                    'style' => 'display: flex; justify-content: center',
                ];
            }
            return [];
        });
        
        $this->setTdAttributes(function (Column $column, $row, $columnIndex, $rowIndex) {
            if ($columnIndex == '2') {
                return [
                    'style' => 'text-align: center'
                ];
            }
            return [];
        });
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.sms_manager.name'), "name")
                ->view('sms_templates.templates.columns.name')
                ->sortable()
                ->searchable(),
            Column::make(__('messages.sms_manager.status'), "status")
                ->view('sms_templates.templates.columns.status')
                ->sortable(),
            Column::make( __('messages.common.action'), "id")
                ->view('sms_templates.templates.columns.action_button'),
        ];
    }
}
