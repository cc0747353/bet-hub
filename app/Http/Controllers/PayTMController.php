<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePaytmDetailRequest;
use App\Mail\ManuallyPaymentRequest;
use App\Models\DepositTransaction;
use App\Models\EmailTemplate;
use App\Models\PaymentGateway;
use App\Models\PaymentGatewaysFields;
use App\Models\Referral;
use App\Models\ReferralLevel;
use App\Models\User;
use App\Models\UserReferralsCommission;
use App\Models\UserReferralsLevel;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Anand\LaravelPaytmWallet\Facades\PaytmWallet;

/**
 * Class PayTMController
 */
class PayTMController extends AppBaseController
{
    public function __construct()
    {
        $gateways = getPaymentCredentials('Paytm');

        config([
            'service.paytm.merchant_id'      => $gateways['paytm_merchant_id'],
            'service.paytm.merchant_key'     => $gateways['paytm_merchant_key'],
            'service.paytm.env'              => config('app.env'),
            'service.paytm.merchant_website' => config('app.url'), 'service.paytm.channel' => 'WEB',
            'service.paytm.industry_type'    => 'Retail',
        ]);
    }

    // display a form for payment
    public function initiate(Request $request)
    {
        $amount = $request['payloadData'];

        return view('payments.paytm.index', compact('amount'));
    }

    /**
     * @param CreatePaytmDetailRequest $request
     *
     * @return mixed
     */
    public function payment(CreatePaytmDetailRequest $request)
    {
        $input = $request->all();
        $payment = PaytmWallet::with('receive');
        $loginUserId = getLogInUser() ? getLogInUserId() : '';

        $payment->prepare([
            'order'         => $input['amount'].'|'.$loginUserId.'|'.time(), // 1 should be your any data id
            'user'          => getLogInUserId(), // any user id
            'mobile_number' => $input['mobile'],
            'email'         => $input['email'], // your user email address
            'amount'        => $input['amount'], // amount will be paid in INR.
            'callback_url'  => route('paytm.callback') // callback URL
        ]);
        Log::info('payment getaway sending');

        return $payment->receive();  // initiate a new payment
    }

    /**
     * Obtain the payment information.
     *
     * @return Object
     */
    public function paymentCallback()
    {
        Log::info('payment getaway started');
        $transaction = PaytmWallet::with('receive');
        $response = $transaction->response();
        $order_id = $transaction->getOrderId(); // return a order id
        $transaction->getTransactionId(); // return a transaction id
        list($amount, $loginUserId) = explode('|', $order_id);

        Log::info('payment getaway');
        // update the db data as per result from api call
        if ($transaction->isSuccessful()) {
            Log::info('payment getaway Success');

            $fixTax = PaymentGatewaysFields::where('key', 'paytm_fixed_charge')->where('type',
                PaymentGatewaysFields::CHARGE)->value('value');
            $percentTax = PaymentGatewaysFields::where('key', 'paytm_percent_charge')->where('type',
                PaymentGatewaysFields::CHARGE)->value('value');

            if (!empty($fixTax)) {
                $depositAmount = $amount - $fixTax;
            } else {
                $totalTax = 100 + $percentTax;
                $taxAmount = $amount * $percentTax / $totalTax;
                $depositAmount = $amount - $taxAmount;
            }

            $depositData = DepositTransaction::whereUserId(getLogInUserId())->whereStatus(1)->count();
            $referralData = Referral::whereName('Deposit Commission')->whereStatus(1)->value('id');
            $levelData = ReferralLevel::whereReferralId($referralData)->latest('created_at')->first();
            if (!empty(getLoginUserData(getLogInUserId())->referral_by) && $depositData < 1 && !empty($referralData) && !empty($levelData)) {
                userReferralsLevel(UserReferralsLevel::DEPOSIT_COMMISSION);

                $referralUsersId = User::whereUserName(getLoginUserData(getLogInUserId())->referral_by)->value('id');
                $level = UserReferralsLevel::whereUserId($referralUsersId)->value('level');
                $referralCommission = ReferralLevel::whereReferralId($referralData)->whereLevel($level)->value('commission');
                $totalUserCommission = $depositAmount * $referralCommission / 100;

                $referralTransaction = DepositTransaction::create([
                    'transaction_id' => $response['TXNID'],
                    'type'           => PaymentGateway::DEPOSIT_COMMISSION,
                    'amount'         => null,
                    'deposit_amount' => $totalUserCommission,
                    'tax'            => null,
                    'user_id'        => $referralUsersId,
                    'currency_id'    => getCurrencyId(),
                    'status'         => DepositTransaction::SUCCESS,
                    'meta'           => json_encode($response),
                    'message'        => 'Deposit commission referred by '.getLogInUser()->referral_by.' to '.getLogInUser()->user_name,
                ]);

                $Transaction = DepositTransaction::create([
                    'transaction_id' => $response['TXNID'],
                    'type'           => PaymentGateway::PAYTM,
                    'amount'         => $amount,
                    'deposit_amount' => $depositAmount - $totalUserCommission,
                    'tax'            => !empty($fixTax) ? $fixTax : $percentTax,
                    'user_id'        => $loginUserId,
                    'currency_id'    => getCurrencyId(),
                    'status'         => DepositTransaction::SUCCESS,
                    'meta'           => json_encode($response),
                ]);

                $type = PaymentGateway::REFERRAL_PAYMENT_METHOD[PaymentGateway::DEPOSIT_COMMISSION];
                $userLevelData = UserReferralsLevel::whereUserId($referralUsersId)->whereType(UserReferralsLevel::DEPOSIT_COMMISSION)->value('level');
                userReferralCommissionMail($referralUsersId, $totalUserCommission, $Transaction, $userLevelData, $type);

                $depositId = DepositTransaction::whereUserId($referralUsersId)->whereTransactionId($tresponse->getTransId(),)->value('id');

                $userCommission = UserReferralsCommission::create([
                    'referral_by_id' => $referralUsersId,
                    'referral_to_id' => getLogInUserId(),
                    'type'           => UserReferralsLevel::DEPOSIT_COMMISSION,
                    'deposit_id'     => $depositId,
                ]);
                
            } else {
                $Transaction = DepositTransaction::create([
                    'transaction_id' => $response['TXNID'],
                    'type'           => PaymentGateway::PAYTM,
                    'amount'         => $amount,
                    'deposit_amount' => $depositAmount,
                    'tax'            => !empty($fixTax) ? $fixTax : $percentTax,
                    'user_id'        => $loginUserId,
                    'currency_id'    => getCurrencyId(),
                    'status'         => DepositTransaction::SUCCESS,
                    'meta'           => json_encode($response),
                ]);
            }

            Flash::success(__('messages.flash.app_payment_successful'));

            Auth::loginUsingId($loginUserId);

            $input['email'] = EmailTemplate::where('name' ,'Deposit')->first();
            $input['name'] = getLogInUser()->full_name;
            $input['amount'] = $depositAmount;
            $input['payment_type'] = PaymentGateway::PAYMENT_METHOD[PaymentGateway::PAYTM];
            $input['transaction_number'] = $Transaction->transaction_id;
            $input['charge'] = $taxAmount;
            $input['currency'] = getCurrencyIcon();

            Mail::to(getAdminEmail())
                ->send(new ManuallyPaymentRequest('emails.manually_payment_request_mail',
                    __($input['email']->subject),
                    $input));

            return redirect(route('user.deposit-transaction.index'));

        } else {
            if ($transaction->isFailed()) {

                Flash::error(__('messages.flash.unable_to_process_payment'));

                return redirect(route('user.deposit-transaction.index'));

            } else {
                if ($transaction->isOpen()) {
                    Log::info('Open');
                }
            }
        }
    }

    /**
     * @return Application|RedirectResponse|Redirector
     */
    public function failed()
    {
        Flash::error(__('messages.flash.unable_to_process_payment'));

        return redirect(route('user.deposit-transaction.index'));
    }
}
