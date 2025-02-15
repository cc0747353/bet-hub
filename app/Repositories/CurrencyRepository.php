<?php

namespace App\Repositories;

use App\Models\Currency;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;


/**
 * Class CategoryRepository
 */
class CurrencyRepository extends BaseRepository
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
        return Currency::class;
    }

    public function store($input): array
    {
        try {
            DB::beginTransaction();
            $inputArr = Arr::except($input, ['_token', '_method']);

            Currency::create($inputArr);

            DB::commit();

            return $inputArr;
        } catch (Exception $e) {
            DB::rollBack();

            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    public function update($input, $id): void
    {
        try {
            $input['currency_code'] = strtoupper($input['currency_code']);

            $currency = Currency::whereId($id);
            $currency->update([
                'currency_code' => $input['currency_code'],
                'currency_icon' => $input['currency_icon'],
                'currency_name' => $input['currency_name'],
            ]);

            DB::commit();

        } catch (Exception $e) {
            DB::rollBack();

            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}
