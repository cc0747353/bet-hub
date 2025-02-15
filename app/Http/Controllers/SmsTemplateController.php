<?php

namespace App\Http\Controllers;

use App\Models\SmsTemplate;
use App\Repositories\SmsTemplateRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Laracasts\Flash\Flash;

class SmsTemplateController extends AppBaseController
{
    /**
     * @param SmsTemplateRepository $smsTemplateRepository
     */
    public function __construct(SmsTemplateRepository $smsTemplateRepository)
    {
        $this->smsTemplateRepo = $smsTemplateRepository;
    }

    public function index(): View|Factory|Application
    {
        return view('sms_templates.templates.index');
    }

    public function edit(SmsTemplate $smsTemplate): Factory|View|Application
    {
        return view('sms_templates.templates.edit', compact('smsTemplate'));
    }

    /**
     * @param Request $request
     * @param $id
     *
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function update(Request $request, $id)
    {
        $this->smsTemplateRepo->update($request->all(), $id);
        Flash::success(__('messages.flash.SMS_template_update'));

        return redirect(route('sms-template.index'));
    }

    public function smsTemplateStatus(Request $request): JsonResponse
    {
        $templateStatus = SmsTemplate::findOrFail($request->id);
        $templateStatus->update(['status' => !$templateStatus->status]);

        return $this->sendResponse($templateStatus, __('messages.flash.Sms_template_status'));
    }
}
