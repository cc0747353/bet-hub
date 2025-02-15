<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateEmailTemplateRequest;
use App\Models\EmailTemplate;
use App\Repositories\EmailTemplateRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;
use Laracasts\Flash\Flash;

class EmailTemplateController extends AppBaseController
{

    /**
     * @param EmailTemplateRepository $emailTemplateRepository
     */
    public function __construct(EmailTemplateRepository $emailTemplateRepository)
    {
        $this->emailTemplateRepository = $emailTemplateRepository;
    }

    /**
     *
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('email_templates.templates.index');
    }

    /**
     * @param EmailTemplate $emailTemplate
     *
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function edit(EmailTemplate $emailTemplate)
    {
        return view('email_templates.templates.edit', compact('emailTemplate'));
    }

    /**
     * @param UpdateEmailTemplateRequest $request
     * @param EmailTemplate $emailTemplate
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function update(UpdateEmailTemplateRequest $request, EmailTemplate $emailTemplate)
    {
        $input = $request->all();
        $input['status'] = isset($request->status);

        $this->emailTemplateRepository->update($input, $emailTemplate->id);

        Flash::success(__('messages.flash.email_template_updated'));


        return redirect(route('email.template.index'));
    }


    public function emailTemplateStatus(EmailTemplate $emailTemplate): JsonResponse
    {
        $emailTemplate->update(['status' => $emailTemplate->status == 0 ? 1 : 0]);

        return $this->sendResponse($emailTemplate, __('messages.flash.email_template_status_update'));
    }
}
