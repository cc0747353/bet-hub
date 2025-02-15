<?php

namespace App\Http\Livewire;

use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Subscriber;

class NewsLetterTable extends LivewireTableComponent
{
    protected $model = Subscriber::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.user.email'), "email")
                ->searchable()
                ->view('news_letter.columns.email')
                ->sortable(),
            Column::make(__('messages.common.action'), "id")
                ->view('news_letter.columns.action'),
            ];
    }
}
