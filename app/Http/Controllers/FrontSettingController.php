<?php

namespace App\Http\Controllers;

use App\Http\Requests\FrontSettingRequest;
use App\Models\FrontSetting;
use App\Repositories\FrontSettingRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;
use Laracasts\Flash\Flash;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

/**
 * Class FrontSettingController
 */
class FrontSettingController extends AppBaseController
{

    /** @var FrontSettingRepository */
    private FrontSettingRepository $frontSettingRepository;

    public function __construct(FrontSettingRepository $frontSettingRepository)
    {
        $this->frontSettingRepository = $frontSettingRepository;
    }

    /**
     * @param Request $request
     *
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $frontSettings = FrontSetting::pluck('value', 'key')->toArray();
        $sectionName = $request->section === null ? 'home' : $request->section;

        return view("front_settings.$sectionName", compact('frontSettings', 'sectionName'));
    }

    /**
     * @param FrontSettingRequest $request
     *
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function update(FrontSettingRequest $request)
    {
        $sectionName = $request->sectionName;
        $this->frontSettingRepository->updateFrontSetting($request->all());

        if ($sectionName == 'home') {
            Flash::success(__('messages.flash.home_settings_updated'));
        } elseif ($sectionName == 'about-us') {
            Flash::success(__('messages.flash.about_us_settings_updated'));
        } elseif ($sectionName == 'affiliate') {
            Flash::success(__('messages.flash.affiliate_settings_updated'));
        } elseif ($sectionName == 'contact-us') {
            Flash::success(__('messages.flash.contact_us_settings_updated'));
        }

        return redirect(route('front.settings.index', ['section' => $sectionName]));
    }
}
