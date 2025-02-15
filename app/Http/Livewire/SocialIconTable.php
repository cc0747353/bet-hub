<?php

namespace App\Http\Livewire;

use App\Models\SocialIcon;
use Rappasoft\LaravelLivewireTables\Views\Column;

class SocialIconTable extends LivewireTableComponent
{
    protected $model = SocialIcon::class;
    public $showButtonOnHeader = true;
    public $buttonComponent = 'social_icon.add-button';
    protected $listeners = ['refresh' => '$refresh', 'resetPage'];

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setDefaultSort('social_icons.created_at', 'desc')
            ->setQueryStringStatus(false);
    }

    public function columns(): array
    {
        return [
            Column::make( __('messages.social_icon.title'), "title")
                ->searchable()
                ->view('social_icon.columns.title')
                ->sortable(),
            Column::make( __('messages.social_icon.icon'), "icon")
                ->view('social_icon.columns.icon')
                ->sortable(),
            Column::make( __('messages.social_icon.url'), "url")
                ->searchable()
                ->view('social_icon.columns.url')
                ->sortable(),
            Column::make( __('messages.category.action'), "id")
                ->view('social_icon.columns.action'),

        ];
    }
}
