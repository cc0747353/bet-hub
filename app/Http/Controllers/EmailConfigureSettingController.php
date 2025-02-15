<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateEmailConfigureSettingRequest;
use App\Mail\TestMail;
use App\Models\EmailConfigureSetting;
use App\Repositories\EmailConfigureSettingRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Mail;
use Laracasts\Flash\Flash;

class EmailConfigureSettingController extends Controller
{
    /**
     * @param EmailConfigureSettingRepository $emailConfigureSettingRepo
     */
    public function __construct(EmailConfigureSettingRepository $emailConfigureSettingRepo)
    {
        $this->emailConfigureSettingRepo = $emailConfigureSettingRepo;
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $emailSendMethod = EmailConfigureSetting::SEND_MAIL_METHOD;
        $emailEncryption = EmailConfigureSetting::ENCRYPTION;
        $emailData = EmailConfigureSetting::pluck('value', 'key')->toArray();

        return view('email_templates.configure.index', compact('emailSendMethod', 'emailEncryption', 'emailData'));
    }

    /**
     * @param UpdateEmailConfigureSettingRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function update(UpdateEmailConfigureSettingRequest $request)
    {
        $input = $request->all();

        $this->emailConfigureSettingRepo->store($input);

        Flash::success(__('messages.flash.email_configuration_saved'));

        return redirect(route('email.configure.index'));
    }
    
    public function sendTestEmail(Request $request){
        $input = $request->all();
        Mail::to($input['email'])
            ->send(new TestMail('emails.test_mail',
                __('Test Mail'),
                $input));

        Flash::success(__('messages.flash.test_email_send'));
        return redirect(route('email.configure.index'));
    }
}
