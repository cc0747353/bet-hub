<?php

namespace App\Http\Livewire;

use App\Models\AllMatch;
use App\Models\MatchScore;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;

class MatchScoreTable extends LivewireTableComponent
{
    protected $model = MatchScore::class;
    protected $listeners = ['refresh' => '$refresh', 'resetPage'];

    public function configure(): void
    {
        $this->setPrimaryKey('id');

        $this->setThAttributes(function (Column $column){
            if ($column->isField('team_a_score')) {
                return [
                    'style' => 'text-align: center',
                ];
            }
            if ($column->isField('team_b_score')) {
                return [
                    'style' => 'text-align: center',
                ];
            }
            if ($column->isField('created_at')) {
                return [
                    'style' => 'text-align: center',
                ];
            }
            return [];
        });
    }

    public function mount($matchId): void
    {
        $this->matchId = $matchId;
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.matches.team_a_score'), "team_a_score")
                ->view('manage_matches.all_matches.score_columns.team_a_score')->searchable()->sortable(),
            Column::make(__('messages.matches.team_b_score'), "team_b_score")
                ->view('manage_matches.all_matches.score_columns.team_b_score')->searchable()->sortable(),
            Column::make(__('messages.common.created_at'), "created_at")
                ->view('manage_matches.all_matches.score_columns.created_at'),
        ];
    }

    public function builder(): Builder
    {
        return MatchScore::whereMatchId($this->matchId);
    }

}
