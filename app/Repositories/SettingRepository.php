<?php

namespace App\Repositories;

use App\Models\Setting;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;


/**
 * Class CategoryRepository
 */
class SettingRepository extends BaseRepository
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
        return Setting::class;
    }

    public function update($input,$id): void
    {
        try {
            $inputArr = Arr::except($input, ['_token']);
            foreach ($inputArr as $key => $value){
                $setting = Setting::where('key', $key)->first();
                if (! $setting) {
                    continue;
                }
                $setting->update(['value' => $value]);

                if (in_array($key, ['logo']) && ! empty($value)) {
                    $setting->clearMediaCollection(Setting::LOGO);
                    $media = $setting->addMedia($value)->toMediaCollection(Setting::LOGO, config('app.media_disc'));
                    $setting->update(['value' => $media->getUrl()]);
                }

                if (in_array($key, ['favicon']) && ! empty($value)) {
                    $setting->clearMediaCollection(Setting::FAVICON);
                    $media = $setting->addMedia($value)->toMediaCollection(Setting::FAVICON, config('app.media_disc'));
                    $setting->update(['value' => $media->getUrl()]);
                }
            }
            
            
        } catch (Exception $e) {
            DB::rollBack();

            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}
