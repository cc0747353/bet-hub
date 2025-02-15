<?php

namespace App\Http\Livewire;

use App\Models\AllMatch;
use App\Models\League;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;

class AllMatchesTable extends LivewireTableComponent
{
    protected $model = AllMatch::class;
    public $showButtonOnHeader = true;
    public $buttonComponent = 'manage_matches.all_matches.add-button';
    protected $listeners = ['refresh' => '$refresh', 'resetPage'];

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setDefaultSort('all_matches.created_at', 'desc')
            ->setQueryStringStatus(false);
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.matches.league_match'), 'league_id')
                ->sortable(function (Builder $query, $direction) {
                    return $query->orderBy(League::select('name')->whereColumn('all_matches.league_id',
                        'leagues.id'), $direction);
                })
                ->view('manage_matches.all_matches.columns.league_match')
                ->searchable(),
            Column::make(__('messages.matches.league_match'), 'league.name')
                ->hideIf('league.name')
                ->searchable(),
            Column::make(__('messages.matches.teams'), "team_a")
                ->searchable()
                ->view('manage_matches.all_matches.columns.team'),
            Column::make(__('Team'), "team_b")
                ->searchable()
                ->hideIf('team_b'),
            Column::make(__('messages.matches.match_title'), "match_title")
                ->hideIf('match_title'),
            Column::make(__('messages.matches.match_start'), "match_start")
                ->searchable()
                ->view('manage_matches.all_matches.columns.match_start')
                ->sortable(),
            Column::make(__('messages.matches.status'), "status")
                ->view('manage_matches.all_matches.columns.status'),
            Column::make(__('messages.question.is_locked'), "is_locked")
                ->view('manage_matches.all_matches.columns.is_locked'),
            Column::make(__('messages.matches.action'), "id")
                ->view('manage_matches.all_matches.columns.action'),

        ];
    }
}
