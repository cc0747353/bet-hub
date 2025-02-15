<?php

namespace App\Repositories;

use App\Models\SocialIcon;


/**
 * Class LeagueRepository
 */
class SocialIconRepository extends BaseRepository
{
    public $fieldSearchable = [
        'title',
        'url',
    ];

    public function getFieldsSearchable(): mixed
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return SocialIcon::class;
    }
    
}
