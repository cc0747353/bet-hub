<?php

namespace App\Repositories;

use App\Models\FrontSetting;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

/**
 * Class FrontSettingRepository
 */
class FrontSettingRepository extends BaseRepository
{

    /**
     * @var array
     */
    protected $fieldSearchable = [
        'key',
        'value',
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return FrontSetting::class;
    }

    /**
     * @param $input
     *
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function updateFrontSetting($input)
    {
        if (isset($input['home_bg_image']) && !empty($input['home_bg_image'])) {
            /** @var FrontSetting $frontSetting */
            $frontSetting = FrontSetting::where('key', '=', 'home_bg_image')->first();
            $frontSetting->clearMediaCollection(FrontSetting::HOME_BG_IMAGE);
            foreach ($input['home_bg_image'] as $home_bg_image) {
                $homePageImg = $frontSetting->addMedia($home_bg_image)->toMediaCollection(FrontSetting::HOME_BG_IMAGE,
                    config('app.media_disc'));
                $frontSetting->update(['value' => $homePageImg->getFullUrl()]);
            }
        }

        if (isset($input['about_us_image']) && !empty($input['about_us_image'])) {
            /** @var FrontSetting $frontSetting */
            $frontSetting = FrontSetting::where('key', '=', 'about_us_image')->first();
            $frontSetting->clearMediaCollection(FrontSetting::ABOUT_US_IMAGE_PATH);
            $aboutUsImg = $frontSetting->addMedia($input['about_us_image'])->toMediaCollection(FrontSetting::ABOUT_US_IMAGE_PATH,
                config('app.media_disc'));

            $frontSetting->update(['value' => $aboutUsImg->getFullUrl()]);
        }

        if (isset($input['affiliate_image']) && !empty($input['affiliate_image'])) {
            /** @var FrontSetting $frontSetting */
            $frontSetting = FrontSetting::where('key', '=', 'affiliate_image')->first();
            $frontSetting->clearMediaCollection(FrontSetting::AFFILIATE_IAMGE);
            $affiliateImg = $frontSetting->addMedia($input['affiliate_image'])->toMediaCollection(FrontSetting::AFFILIATE_IAMGE,
                config('app.media_disc'));

            $frontSetting->update(['value' => $affiliateImg->getFullUrl()]);
        }

        if (isset($input['contact_us_image']) && !empty($input['contact_us_image'])) {
            /** @var FrontSetting $frontSetting */
            $frontSetting = FrontSetting::where('key', '=', 'contact_us_image')->first();
            $frontSetting->clearMediaCollection(FrontSetting::CONTACT_US_IAMGE);
            $contactUsImg = $frontSetting->addMedia($input['contact_us_image'])->toMediaCollection(FrontSetting::CONTACT_US_IAMGE,
                config('app.media_disc'));
                
            $frontSetting->update(['value' => $contactUsImg->getFullUrl()]);
        }

        $frontSettingInputArray = Arr::only($input, [
            'about_us_title', 'about_us_description', 'home_title', 'home_description', 'affiliate_title',
            'affiliate_description', 'contact_us_title', 'contact_us_description', 'start_title', 'start_description', 'step_1_title', 'step_1_description', 'step_2_title', 'step_2_description', 'step_3_title', 'step_3_description', 'feature_title', 'feature_description', 'feature_1_title', 'feature_1_description', 'feature_2_title', 'feature_2_description', 'feature_3_title', 'feature_3_description',
        ]);

        foreach ($frontSettingInputArray as $key => $value) {
            FrontSetting::where('key', '=', $key)->first()->update(['value' => $value]);
        }

    }

    public function store($input): void
    {
        try {
            $inputArr = Arr::except($input, ['_token']);

            foreach ($inputArr as $key => $value) {
                $frontSetting = FrontSetting::updateOrCreate(['key' => $key], ['value' => $value]);
            }

        } catch (Exception $e) {
            DB::rollBack();

            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}
