<?php

namespace App\Http\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Role;

class RoleTable extends LivewireTableComponent
{
    protected $model = Role::class;
    public $showButtonOnHeader = true;
    public $buttonComponent = 'roles.add_button';
    protected $listeners = ['refresh' => '$refresh', 'resetPage'];

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setThAttributes(function(Column $column) {
            if ($column->isField('id')) {
                return [
                    'class' => 'd-flex justify-content-center',
                ];
            }
            return [];
        });
        $this->setTdAttributes(function (Column $column, $row, $columnIndex, $rowIndex) {
            if ($columnIndex == '2') {
                return [
                    'class' => 'text-center',
                    'width' => '10%',
                ];
            }

            return [];
        });
    }

    public function columns(): array
    {
        return [
            Column::make( __('messages.role.name'), "display_name")
                ->sortable(),
            Column::make(__('messages.role.permissions'), "created_at")
                ->view('roles.columns.permission')
                ->sortable(),
            Column::make(__('messages.common.action'), "id")
                ->view('roles.columns.action'),
        ];
    }

    /**
     * @return Builder
     */
    public function builder(): Builder
    {
        $query = Role::with('permissions')->whereNot('name','superAdmin');

        return $query;
    }
}
