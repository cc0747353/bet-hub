<?php

namespace App\Repositories;

use App\Models\Question;


/**
 * Class LeagueRepository
 */
class QuestionsRepository extends BaseRepository
{
    public $fieldSearchable = [
        'question',
    ];

    public function getFieldsSearchable(): mixed
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Question::class;
    }
    
}
