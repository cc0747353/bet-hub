<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateFaqsRequest;
use App\Http\Requests\UpdateFaqsRequest;
use App\Models\FAQs;
use App\Repositories\FaqsRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class FaqsController extends AppBaseController
{

    /**
     * @param FaqsRepository $faqsRepository
     */
    public function __construct(FaqsRepository $faqsRepository)
    {
        $this->faqsRepo = $faqsRepository;
    }

    public function index(): Factory|View|Application
    {
        return view('faqs.index');
    }

    public function store(CreateFaqsRequest $request): JsonResponse
    {
        $input = $request->all();
        $input['status'] = $input['status'] ?? 0;
        $this->faqsRepo->create($input);

        return $this->sendSuccess(__('messages.flash.faqs_create'));
    }


    public function edit($id): JsonResponse
    {
        $faq = FAQs::findOrFail($id);

        return $this->sendResponse($faq, __('messages.flash.faqs_retrieved'));

    }


    public function update(UpdateFaqsRequest $request, $id): JsonResponse
    {
        $input = $request->all();
        $input['status'] = $input['status'] ?? 0;
        $this->faqsRepo->update($input, $id);

        return $this->sendSuccess(__('messages.flash.faqs_updated'));
    }

    public function destroy(FAQs $Faq): JsonResponse
    {
        $Faq->delete();

        return $this->sendSuccess(__('messages.flash.faqs_deleted'));
    }


    public function changeStatus($id): JsonResponse
    {
        $faq = FAQs::findOrFail($id);
        $faq->update(['status' => $faq->status == 0 ? 1 : 0]);

        return $this->sendResponse($faq, __('messages.flash.faqs_status'));
    }
}
