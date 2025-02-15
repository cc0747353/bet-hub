<?php

namespace App\Http\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\League;

class LeagueTable extends LivewireTableComponent
{
    protected $model = League::class;
    public $showButtonOnHeader = true;
    public $buttonComponent = 'leagues.add-button';
    protected $listeners = ['refresh' => '$refresh', 'resetPage'];

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setDefaultSort('leagues.created_at', 'desc')
            ->setQueryStringStatus(false);
    }

    public function columns(): array
    {
        return [
            Column::make( __('messages.league.name'), "name")
                ->searchable()
                ->view('leagues.columns.name')
                ->sortable(),
            Column::make( __('messages.league.category'), "category_id")
                ->searchable()
                ->view('leagues.columns.category'),
            Column::make( __('messages.league.icon'), "icon")
                ->view('leagues.columns.icon'),
            Column::make( __('messages.league.match_count'), "id")
                ->view('leagues.columns.match_count'),
            Column::make( __('messages.league.status'), "status")
                ->view('leagues.columns.status'),
            Column::make( __('messages.league.action'), "created_at")
                ->view('leagues.columns.action'),

        ];
    }

    /**
     * @return Builder
     */
    public function builder(): Builder
    {
        $query = League::with('category');
        
        return $query;
    }
}
