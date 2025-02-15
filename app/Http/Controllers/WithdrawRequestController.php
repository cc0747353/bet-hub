<?php

namespace App\Http\Controllers;

use App\Mail\UserWithdrawRequest;
use App\Models\DepositTransaction;
use App\Models\EmailTemplate;
use App\Models\UserPaymentSettings;
use App\Models\WithdrawRequests;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class WithdrawRequestController extends AppBaseController
{
    /**
     *
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $setting = UserPaymentSettings::where('user_id', getLogInUserId())->first();

        return view('withdraw_request.index', compact('setting'));
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'user_notes' => 'required',
        ]);
        $input = $request->all();

        $bankDetails = UserPaymentSettings::where('user_id', getLogInUserId())->first();
        $availableDeposit = getTotalBalance();
        $withdrawRequestCount = WithdrawRequests::whereUserId(getLogInUserId())->whereStatus(WithdrawRequests::PENDING)->first();

        if ($withdrawRequestCount){
            return $this->sendError('Your Last Withdraw Request is pending, you can not add another request.');
        }
        
        if ($availableDeposit >= $input['amount']) {
            if ($input['withdraw_method'] == WithdrawRequests::BANK) {
                if ($bankDetails !== null) {
                    WithdrawRequests::create([
                        'user_id'     => getLogInUserId(),
                        'amount'      => $input['amount'],
                        'method'      => $input['withdraw_method'],
                        'currency_id' => getCurrencyId(),
                        'status'      => WithdrawRequests::PENDING,
                        'user_notes'  => $input['user_notes'],
                    ]);

                    $input['email'] = EmailTemplate::where('name' ,'Withdraw Request - User')->first();
                    $input['name'] = getLogInUser()->full_name;
                    $input['currency'] = getCurrencyIcon();
                    $input['method_name'] = 'Bank';
                    $input['post_balance'] = $availableDeposit;
                    
                    Mail::to(getAdminEmail())
                        ->send(new UserWithdrawRequest('emails.user_withdraw_request_mail',
                            __($input['email']->subject),
                            $input));
                    
                    return $this->sendSuccess(__('messages.withdraw.withdraw_request_sent'));
                }

                return $this->sendError(__('messages.withdraw.bank_details_not_exists'));
            }

            if ($input['withdraw_method'] == WithdrawRequests::PAYPAL) {
                if (!empty($bankDetails['email']) && $input['confirm_email'] == $bankDetails['email']) {

                    WithdrawRequests::create([
                        'user_id'     => getLogInUserId(),
                        'amount'      => $input['amount'],
                        'method'      => $input['withdraw_method'],
                        'currency_id' => getCurrencyId(),
                        'status'      => WithdrawRequests::PENDING,
                        'user_notes'  => $input['user_notes'],
                    ]);

                    $input['email'] = EmailTemplate::where('name' ,'Withdraw Request - User')->first();
                    $input['name'] = getLogInUser()->full_name;
                    $input['currency'] = getCurrencyIcon();
                    $input['method_name'] = 'Paypal';
                    $input['post_balance'] = $availableDeposit;

                    Mail::to(getAdminEmail())
                        ->send(new UserWithdrawRequest('emails.user_withdraw_request_mail',
                            __($input['email']->subject),
                            $input));

                    return $this->sendSuccess(__('messages.withdraw.withdraw_request_sent'));
                }

                return $this->sendError(__('messages.withdraw.paypal_email_mismatch'));
            }
            
        }

        return $this->sendError(__('messages.flash.you_do_not_have'));
    }
}
