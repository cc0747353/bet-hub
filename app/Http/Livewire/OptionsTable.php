<?php

namespace App\Http\Livewire;

use App\Models\Option;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;

class OptionsTable extends LivewireTableComponent
{
    protected $model = Option::class;
    public $showButtonOnHeader = true;
    public $buttonComponent = 'manage_matches.questions_option.add-button';
    protected $listeners = ['refresh' => '$refresh', 'resetPage'];
    public $questionId = '';

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setDefaultSort('options.created_at', 'desc')
            ->setQueryStringStatus(false);
    }

    public function mount($questionId)
    {
        $this->questionId = $questionId;
    }
    
    public function columns(): array
    {
        return [
            Column::make(__('messages.question.name'), "name")
                ->searchable()
                ->view('manage_matches.questions_option.columns.name')
                ->sortable(),
            Column::make(__('messages.question.ratio'), "dividend")
                ->searchable()
                ->view('manage_matches.questions_option.columns.ratio')
                ->sortable(),
            Column::make(__('messages.question.ratio'), "divisor")
                ->hideIf('end_at'),
            Column::make(__('messages.question.bet_count'), "question_id")
                ->view('manage_matches.questions_option.columns.bet_count')
                ->sortable(),
            Column::make(__('messages.question.status'), "status")
                ->view('manage_matches.questions_option.columns.status')
                ->sortable(),
            Column::make(__('messages.question.action'), "id")
                ->view('manage_matches.questions_option.columns.action'),
        ];
    }
    
    public function builder(): Builder
    {
        return Option::with('bets')->where('question_id',$this->questionId);
    }
}
