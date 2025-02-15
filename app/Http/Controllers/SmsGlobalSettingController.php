<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateGlobalSettingRequest;
use App\Models\Setting;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Laracasts\Flash\Flash;

class SmsGlobalSettingController extends Controller
{
    /**
     *
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $globalSetting = Setting::pluck('value', 'key');

        return view('sms_templates.global_setting.index', compact('globalSetting'));
    }

    /**
     * @param CreateGlobalSettingRequest $request
     *
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function update(CreateGlobalSettingRequest $request)
    {
        $input = $request->all();
        foreach ($input as $key => $value) {
            $cookieData = Setting::where('key', $key)->first();
            if (!$cookieData) {
                continue;
            }
            $cookieData->update(['value' => $value]);
        }
        Flash::success(__('messages.flash.global_setting_updated'));

        return redirect(route('sms.global.setting'));
    }
}
