<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateWithdrawRequestRequest;
use App\Mail\UserWithdrawRequest;
use App\Mail\WithdrawRequestApproved;
use App\Mail\WithdrawRequestRejected;
use App\Models\EmailTemplate;
use App\Models\UserPaymentSettings;
use App\Models\WithdrawRequests;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AdminWithdrawRequestController extends AppBaseController
{

    /**
     *
     *
     * @return Application|Factory|View
     */
    public function getWithdrawRequest()
    {
        return view('admin_withdraw_request.index');
    }

    public function updateWithdrawRequest(Request $request): JsonResponse
    {
        $request->validate([
            'attachment' => 'mimes:jpeg,png,jpg,mp4,mov,ogg,doc,docx,eot,xlsx,xlsb,xls,css,csv,wmv,avi',
        ]);
        $input = $request->all();

        $withdrawRequest = WithdrawRequests::find($input['id']);
        $withdrawRequest->update([
            'status' => $input['status'],
            'notes'  => $input['notes'],
        ]);

        if (isset($input['attachment']) && !empty('attachment')) {
            $withdrawRequest->addMedia($input['attachment'])->toMediaCollection(WithdrawRequests::ATTACHMENT,
                config('app.media_disc'));
        }

        if ($withdrawRequest['status'] == WithdrawRequests::APPROVED) {
            $input['email'] = EmailTemplate::where('name', 'Withdraw Request Approved - Admin')->first();
            $input['name'] = getLoginUserData($withdrawRequest['user_id'])->full_name;
            $input['amount'] = $withdrawRequest['amount'];
            $input['currency'] = getCurrencyIcon();
            $input['method_name'] = 'Paypal';

            Mail::to(getLoginUserData($withdrawRequest['user_id'])->email)
                ->send(new WithdrawRequestApproved('emails.withdraw_request_approved_mail',
                    __($input['email']->subject),
                    $input));
        }else
        {
            $input['email'] = EmailTemplate::where('name', 'Withdraw Request Rejected - Admin')->first();
            $input['name'] = getLoginUserData($withdrawRequest['user_id'])->full_name;
            $input['amount'] = $withdrawRequest['amount'];
            $input['currency'] = getCurrencyIcon();
            $input['method_name'] = 'Paypal';

            Mail::to(getLoginUserData($withdrawRequest['user_id'])->email)
                ->send(new WithdrawRequestRejected('emails.withdraw_request_rejected_mail',
                    __($input['email']->subject),
                    $input));
        }
        return $this->sendSuccess(__('messages.flash.request_updated'));
    }

    /**
     * @param $id
     *
     *
     * @return Application|Factory|View
     */
    public function withdrawRequestDetails($id)
    {
        $withdrawRequest = WithdrawRequests::find($id);
        $paymentSettings = UserPaymentSettings::whereUserId($withdrawRequest->user_id)->first();

        return view('admin_withdraw_request.show', compact('withdrawRequest', 'paymentSettings'));
    }
}
