<?php

namespace App\Http\Controllers;

use App\Models\Referral;
use App\Repositories\ReferralRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Laracasts\Flash\Flash;

class ReferralController extends AppBaseController
{

    /**
     * @param ReferralRepository $referralRepository
     */
    public function __construct(ReferralRepository $referralRepository)
    {
        $this->referralRepository = $referralRepository;
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $referrals = Referral::with('referralLevel')->get();

        return view('referrals.index', compact('referrals'));
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
        if (empty($input['commission'])){
            Flash::error(__('messages.flash.enter_commission_field'));
            return redirect(route('referrals.index'));
        }

        if ($request->level == 0){
            Flash::error(__('messages.flash.enter_minimum'));
            return redirect(route('referrals.index'));
        }
        $this->referralRepository->store($request->all());

        Flash::success(__('messages.flash.referral_create'));

        return redirect(route('referrals.index'));
    }

    /**
     * @param Referral $referral
     *
     *
     * @return JsonResponse
     */
    public function changeReferralStatus(Referral $referral): JsonResponse
    {
        $referral->update(['status' => !$referral->status]);

        return $this->sendResponse($referral, __('messages.flash.referral_status'));
    }
}
