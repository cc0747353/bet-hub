<?php

namespace App\Repositories;

use App\Models\Partner;
use Exception;
use Illuminate\Support\Facades\DB;
use LaravelIdea\Helper\App\Models\_IH_Partner_C;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;


/**
 * Class CategoryRepository
 */
class PartnerRepository extends BaseRepository
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
        return Partner::class;
    }

    public function store($input): Partner
    {
        try {
            DB::beginTransaction();

            $partner_item = Partner::create($input);
            if (!empty($input['image'])) {
                $partner_item->addMedia($input['image'])->toMediaCollection(Partner::IMAGE,
                    config('app.media_disc'));
            }
            DB::commit();

            return $partner_item;
        } catch (Exception $e) {
            DB::rollBack();

            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    public function update($input, $id): _IH_Partner_C|array|Partner
    {
        try {
            DB::beginTransaction();
            $partner_item = Partner::findOrFail($id);
            $partner_item->update($input);
            if (isset($input['image']) && !empty($input['image'])) {
                $partner_item->clearMediaCollection(Partner::IMAGE);
                $partner_item->addMedia($input['image'])->toMediaCollection(Partner::IMAGE,
                    config('app.media_disc'));
            }

            DB::commit();

            return $partner_item;
        } catch (Exception $e) {
            DB::rollBack();

            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}
