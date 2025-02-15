<?php

namespace App\Repositories;

use App\Models\League;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use LaravelIdea\Helper\App\Models\_IH_League_C;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;


/**
 * Class LeagueRepository
 */
class LeagueRepository extends BaseRepository
{
    public $fieldSearchable = [
        'name',
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
        return League::class;
    }

    public function store($input): mixed
    {
        try {
            DB::beginTransaction();

            $input['status'] = isset($input['status']) ? 1 : 0;
            $league = League::create($input);

            DB::commit();

            return $league;
        } catch (Exception $e) {
            DB::rollBack();

            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    public function update($input, $id): Model|Collection|_IH_League_C|League
    {
        try {
            DB::beginTransaction();
            $input['status'] = isset($input['status']) ? 1 : 0;
            $league = League::findOrFail($id);
            $league->update($input);


            DB::commit();

            return $league;
        } catch (Exception $e) {
            DB::rollBack();

            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}
