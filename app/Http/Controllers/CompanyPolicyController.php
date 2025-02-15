<?php

namespace App\Http\Controllers;

use App\Models\FrontSetting;
use App\Repositories\FrontSettingRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Laracasts\Flash\Flash;

class CompanyPolicyController extends Controller
{
    /**
     * @param FrontSettingRepository $frontSettingRepository
     */
    public function __construct(FrontSettingRepository $frontSettingRepository)
    {
        $this->frontSettingRepo = $frontSettingRepository;
    }

    /**
     *
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $companyPolicyData = FrontSetting::all()->pluck('value', 'key')->toArray();

        return view('company_policy.index', compact('companyPolicyData'));
    }

    /**
     * @param Request $request
     *
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $this->frontSettingRepo->store($input);
        Flash::success(__('messages.flash.company_policy_updated'));

        return redirect(route('company-policy.index'));
    }
}
