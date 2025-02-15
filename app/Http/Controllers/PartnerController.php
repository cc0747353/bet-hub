<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePartnersRequest;
use App\Http\Requests\UpdatePartnersRequest;
use App\Models\Partner;
use App\Repositories\PartnerRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class PartnerController extends AppBaseController
{

    /**
     * @param PartnerRepository $partnerRepository
     */
    public function __construct(PartnerRepository $partnerRepository)
    {
        $this->partnerRepo = $partnerRepository;
    }

    /**
     *
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('partner.index');
    }

    public function store(CreatePartnersRequest $request): JsonResponse
    {
        $this->partnerRepo->store($request->all());

        return $this->sendSuccess(__('messages.flash.partner_item_created'));
    }

    public function edit(Partner $partner): JsonResponse
    {
        return $this->sendResponse($partner, __('messages.flash.partner_item_retrieved'));
    }

    public function update(UpdatePartnersRequest $request, $id): JsonResponse
    {
        $this->partnerRepo->update($request->all(), $id);

        return $this->sendSuccess(__('messages.flash.partner_item_update'));
    }

    public function destroy(Partner $partner): JsonResponse
    {
        $partner->delete();

        return $this->sendResponse($partner, __('messages.flash.partner_item_deleted'));
    }
}
