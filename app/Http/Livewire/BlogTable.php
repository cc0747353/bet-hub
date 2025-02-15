<?php

namespace App\Http\Livewire;

use App\Models\Blog;
use Rappasoft\LaravelLivewireTables\Views\Column;

class BlogTable extends LivewireTableComponent
{
    protected $model = Blog::class;
    public $showButtonOnHeader = true;
    public $buttonComponent = 'cms.blog.add-button';
    protected $listeners = ['refresh' => '$refresh', 'resetPage'];

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setDefaultSort('blogs.created_at', 'desc')
            ->setQueryStringStatus(false);

        $this->setThAttributes(function (Column $column) {
            if ($column->isField('created_at')) {
                return [
                    'style' => 'width:150px',
                ];
            }

            return [];
        });
    }

    public function columns(): array
    {
        return [
            Column::make( __('messages.blog.image'), "id")
                ->view('cms.blog.columns.image'),
            Column::make( __('messages.blog.title'), "title")
                ->view('cms.blog.columns.title')
                ->sortable(),
            Column::make( __('messages.league.action'), "created_at")
                ->view('cms.blog.columns.action_button'),

        ];
    }
}
