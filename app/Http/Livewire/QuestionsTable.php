<?php

namespace App\Http\Livewire;

use App\Models\Question;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;

class QuestionsTable extends LivewireTableComponent
{
    protected $model = Question::class;
    public $showButtonOnHeader = true;
    public $buttonComponent = 'manage_matches.match_questions.add-button';
    protected $listeners = ['refresh' => '$refresh', 'resetPage'];

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setDefaultSort('questions.created_at', 'desc')
            ->setQueryStringStatus(false);
    }

    public function mount($matchId)
    {
        $this->matchId = $matchId;
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.question.question'), "question")
                ->searchable()
                ->view('manage_matches.match_questions.columns.question')
                ->sortable(),
            Column::make(__('messages.question.status'), "status")
                ->view('manage_matches.match_questions.columns.status')
                ->sortable(),
            Column::make(__('messages.question.is_locked'), "is_locked")
                ->view('manage_matches.match_questions.columns.is_locked')
                ->sortable(),
            Column::make(__('messages.question.action'), "id")
                ->view('manage_matches.match_questions.columns.action'),
            Column::make(__('messages.question.action'), "match_id")
                ->hideIf('match_id'),
        ];
    }

    public function builder(): Builder
    {
        return Question::whereMatchId($this->matchId);
    }

}
