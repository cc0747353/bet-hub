<?php

namespace App\Http\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;

/**
 * Class LivewireTableComponent
 */
class LivewireTableComponent extends DataTableComponent
{
    protected bool $columnSelectStatus = false;
    public $showFilterOnHeader = false;
    public $paginationIsEnabled = false;
    public bool $paginationStatus = true;
    public bool $sortingPillsStatus = false;
    protected $listeners = ['refresh' => '$refresh'];

    public string $emptyMessage = 'messages.common.no_data_available';

    // for table header button
    public $showButtonOnHeader = false;
    public $buttonComponent = '';
    public $backButtonComponent = '';
    public $perPageAll = false;

    public function configure(): void
    {
        // TODO: Implement configure() method.
    }

    public function columns(): array
    {
        // TODO: Implement columns() method.
    }

    public function setupPagination(): void
    {
        if ($this->perPageAll) {
            $this->perPageAccepted[] = -1;
        }

        if (in_array(session($this->getPerPagePaginationSessionKey(), $this->perPage), $this->perPageAccepted, true)) {
            session()->put($this->getPerPagePaginationSessionKey(), (int) $this->perPage);
        } else {
            $this->perPage = $this->perPageAccepted[0] ?? 10;
        }
    }

    public function getPerPagePaginationSessionKey(): string
    {
        return $this->tableName.'-perPage';
    }
    
    public function resetPage($pageName = 'page')
    {
        $rowsPropertyData = $this->getRows()->toArray();
        if($rowsPropertyData['current_page'] > count($rowsPropertyData['links']) - 2)
        {
            $this->setPage($rowsPropertyData['last_page'], $pageName);
        }
        else
        {
            $rowsPropertyData = $this->getRows()->toArray();
            $prevPageNum = $rowsPropertyData['current_page'] - 1;
            $prevPageNum = $prevPageNum > 0 ? $prevPageNum : 1;
            $pageNum = count($rowsPropertyData['data']) > 0 ? $rowsPropertyData['current_page'] : $prevPageNum;
            $this->setPage($pageNum, $pageName);
        }
    }

    public function query()
    {
        // TODO: Implement query() method.
    }
}
