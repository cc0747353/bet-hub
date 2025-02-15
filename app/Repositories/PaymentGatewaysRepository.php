<?php

namespace App\Repositories;

use App\Models\PaymentGatewaysFields;
use App\Models\Setting;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;


/**
 * Class CategoryRepository
 */
class PaymentGatewaysRepository extends BaseRepository
{
    public $fieldSearchable = [
        '',
    ];

    public function getFieldsSearchable(): mixed
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Setting::class;
    }

    public function store($input): void
    {
        try {
            $paymentId = $input['payment_id'];
            $inputArr = Arr::except($input, ['_token', 'payment_id']);
            foreach ($inputArr as $key => $value) {
                $paymentData = PaymentGatewaysFields::where('key', $key)->first();
                if ($paymentData) {
                    $paymentData->update(['value' => $value]);
                } else {
                    PaymentGatewaysFields::create([
                        'payment_id' => $paymentId,
                        'key'        => $key,
                        'value'      => $value,
                    ]);
                }
            }


        } catch (Exception $e) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}
