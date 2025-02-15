<?php

namespace App\Http\Livewire;

use Rappasoft\LaravelLivewireTables\Views\Column;
use Illuminate\Database\Eloquent\Builder;
use App\Models\User;

class UserTable extends LivewireTableComponent
{
    protected $model = User::class;
    public $showButtonOnHeader = true;
    public $statusFilter = '';
    public $buttonComponent = 'users.add_button';
    protected $listeners = [
        'refresh' => '$refresh', 'changeStatusFilter', 'resetPage',
    ];
    
    public function changeStatusFilter($value): void
    {
        $this->statusFilter = $value;
        $this->setBuilder($this->builder());
    }
    
    public function configure(): void
    {
        $this->setPrimaryKey('id')->setDefaultSort('users.created_at', 'desc');
    }
    public function columns(): array
    {
        return [
            Column::make( __('messages.user.name'), "first_name")
                ->view('users.columns.full_name')
                ->searchable()
                ->sortable(),
            Column::make( __('messages.user.first_name'), "id")
                ->hideIf('id'),
            Column::make( __('messages.user.last_name'), "last_name")
                ->hideIf('last_name'),
            Column::make( __('messages.user.email'), "email")
                ->hideIf('email'),
            Column::make( __('messages.user.role'), "created_at")
                ->view('users.columns.role'),
            Column::make( __('messages.user.email_verified'), "email_verified_at")
                ->view('users.columns.email_verified_at'),  
            Column::make( __('messages.user.impersonate'), "contact")
                ->view('users.columns.inpersonate'), 
            Column::make( __('messages.user.status'), "status")
                ->view('users.columns.status')
                ->sortable(),
            Column::make( __('messages.user.action'), "region_code")
                ->view('users.columns.action'),
        ];
    }

    public function builder(): Builder
    {
        $query = User::whereNot('id', getLogInUserId())->whereHas('roles', function (Builder $q) {
            $q->where('name', '!=', 'superAdmin');
        });

        $query->when($this->statusFilter != '' && $this->statusFilter != User::ALL,
            function (Builder $query) {
                return $query->where('status', $this->statusFilter);
            });
        return $query;
    }
}
