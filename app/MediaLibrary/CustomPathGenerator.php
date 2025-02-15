<?php

namespace App\MediaLibrary;

use App\Models\AllMatch;
use App\Models\Blog;
use App\Models\DepositTransaction;
use App\Models\FrontSetting;
use App\Models\Partner;
use App\Models\Setting;
use App\Models\User;
use App\Models\WithdrawRequests;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;

/**
 * Class CustomPathGenerator
 */
class CustomPathGenerator implements PathGenerator
{
    public function getPath(Media $media): string
    {
        $path = '{PARENT_DIR}'.DIRECTORY_SEPARATOR.$media->id.DIRECTORY_SEPARATOR;

        switch ($media->collection_name) {
            case AllMatch::TEAM_A_IMAGE;
                return str_replace('{PARENT_DIR}', AllMatch::TEAM_A_IMAGE, $path);
            case AllMatch::TEAM_B_IMAGE;
                return str_replace('{PARENT_DIR}', AllMatch::TEAM_B_IMAGE, $path);
            case Blog::IMAGE;
                return str_replace('{PARENT_DIR}', Blog::IMAGE, $path);
            case DepositTransaction::ATTACHMENT;
                return str_replace('{PARENT_DIR}', DepositTransaction::ATTACHMENT, $path);
            case Partner::IMAGE;
                return str_replace('{PARENT_DIR}', Partner::IMAGE, $path);
            case Setting::LOGO;
                return str_replace('{PARENT_DIR}', Setting::LOGO, $path);
            case Setting::FAVICON;
                return str_replace('{PARENT_DIR}', Setting::FAVICON, $path);
            case User::PROFILE;
                return str_replace('{PARENT_DIR}', User::PROFILE, $path);
            case WithdrawRequests::ATTACHMENT;
                return str_replace('{PARENT_DIR}', WithdrawRequests::ATTACHMENT, $path);
            case FrontSetting::ABOUT_US_IMAGE_PATH;
                return str_replace('{PARENT_DIR}', FrontSetting::ABOUT_US_IMAGE_PATH, $path);
            case FrontSetting::HOME_BG_IMAGE;
                return str_replace('{PARENT_DIR}', FrontSetting::HOME_BG_IMAGE, $path);
            case FrontSetting::AFFILIATE_IAMGE;
                return str_replace('{PARENT_DIR}', FrontSetting::AFFILIATE_IAMGE, $path);
            case FrontSetting::CONTACT_US_IAMGE;
                return str_replace('{PARENT_DIR}', FrontSetting::CONTACT_US_IAMGE, $path);
            case 'default';
                return '';
        }
    }

    /**
     * @param  Media  $media
     *
     * @return string
     */
    public function getPathForConversions(Media $media): string
    {
        return $this->getPath($media).'thumbnails/';
    }

    public function getPathForResponsiveImages(Media $media): string
    {
        return $this->getPath($media).'rs-images/';
    }
}

