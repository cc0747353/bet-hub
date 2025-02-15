<?php

namespace App\Repositories;

use App\Models\Option;


/**
 * Class LeagueRepository
 */
class OptionsRepository extends BaseRepository
{
    public $fieldSearchable = [
        'name',
    ];

    public function getFieldsSearchable(): mixed
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Option::class;
    }
    
}
