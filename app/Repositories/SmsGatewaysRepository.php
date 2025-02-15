<?php

namespace App\Repositories;

use App\Models\SmsGateways;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;


/**
 * Class CategoryRepository
 */
class SmsGatewaysRepository extends BaseRepository
{
    public $fieldSearchable = [

    ];

    public function getFieldsSearchable(): mixed
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return SmsGateways::class;
    }
    
    public function update($input, $id): void
    {
        try {
            $inputArr = Arr::except($input, ['_token']);
            foreach ($inputArr as $key => $value) {
                $gatewaysData = SmsGateways::where('key', $key)->first();
                if (!$gatewaysData) {
                    continue;
                }
                $gatewaysData->update(['value' => $value]);
            }

            DB::commit();

        } catch (Exception $e) {
            DB::rollBack();

            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}
