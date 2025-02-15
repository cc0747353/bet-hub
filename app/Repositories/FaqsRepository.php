<?php

namespace App\Repositories;

use App\Models\FAQs;


/**
 * Class LeagueRepository
 */
class FaqsRepository extends BaseRepository
{
    public $fieldSearchable = [
        'questions',
        'answers',
    ];

    /**
     * @inheritDoc
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return FAQs::class;
    }

}
