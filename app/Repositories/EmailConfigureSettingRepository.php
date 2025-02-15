<?php

namespace App\Repositories;

use App\Models\AppConfiguration;
use App\Models\EmailConfigureSetting;
use Illuminate\Support\Arr;

/**
 * Class EmailConfigureSettingRepository
 */
class EmailConfigureSettingRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'key',
        'value',
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return EmailConfigureSetting::class;
    }

    public function store($input): void
    {
        $inputArr = Arr::except($input, ['_token']);

        foreach ($inputArr as $key => $value) {

            $emailConfigure = EmailConfigureSetting::where('key', $key)->first();

            if (!empty($value)) {
                if (!$emailConfigure) {
                    EmailConfigureSetting::create([
                        'key'   => $key,
                        'value' => $value,
                    ]);
                } else {
                    $emailConfigure->update(['value' => $value]);
                }
            }

        }

    }
}
