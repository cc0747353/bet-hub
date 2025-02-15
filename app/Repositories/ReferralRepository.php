<?php

namespace App\Repositories;

use App\Models\Referral;
use App\Models\ReferralLevel;
use Exception;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;


/**
 * Class ReferralRepository
 */
class ReferralRepository extends BaseRepository
{
    public $fieldSearchable = [
        'name',
        'status'
    ];

    public function getFieldsSearchable(): mixed
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Referral::class;
    }

    public function store($input): bool
    {
        try {
            $referral = Referral::whereName($input['name'])->first();
            
            $referral->update([
                'status' => isset($input['status'])
            ]);
                
            ReferralLevel::whereReferralId($referral->id)->delete();
            $levelCount = count($input['level']);

            for ($i = 0; $i < $levelCount; $i++)
            {
                ReferralLevel::create([
                    'referral_id' => $referral->id,
                    'level'       => $input['level'][$i],
                    'commission'  => $input['commission'][$i]
                ]);
            }
            
            return true;
        } catch (Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}
