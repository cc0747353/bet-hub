<?php

namespace App\Http\Controllers;

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
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Laracasts\Flash\Flash;
use Srmklive\PayPal\Services\PayPal;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Throwable;

class PaypalController extends AppBaseController
{
    public function __construct()
    {
        $gateways = getPaymentCredentials('PayPal');

        $payPal_payment_id = PaymentGateway::whereName('PayPal')->value('id');
        $gateways = PaymentGatewaysFields::where('payment_id', $payPal_payment_id)->where('type', '1')->pluck('value',
            'key')->toArray();

        config([
            'paypal.mode'                  => !empty($gateways['paypal_mode']) ? $gateways['paypal_mode'] : 'sandbox',
            'paypal.sandbox.client_id'     => $gateways['paypal_client_id'],
            'paypal.sandbox.client_secret' => $gateways['paypal_secret'],
            'paypal.live.client_id'        => $gateways['paypal_client_id'],
            'paypal.live.client_secret'    => $gateways['paypal_secret'],
        ]);
    }

    /**
     * @throws Throwable
     */
    public function onBoard(Request $request): JsonResponse
    {
        $input = $request->all();
        $provider = new PayPalClient();
        $provider->getAccessToken();

        $data = [
            'intent'              => 'CAPTURE',
            'purchase_units'      => [
                [
                    'amount'       => [
                        'value'         => $input['payloadData'],
                        'currency_code' => getCurrencyCode(),
                    ],
                ],
            ],
            'application_context' => [
                "cancel_url" => route('user.paypal.failed'),
                "return_url" => route('user.paypal.success'),
            ],
        ];

        $order = $provider->createOrder($data);
        if (!empty($order['error'])) {
            return $this->sendError($order['error']['message']);
        }
        return response()->json(['link' => $order['links'][1]['href'], 'status' => 200]);
    }

    public function failed()
    {
        dd('Your payment has been declend. The payment cancelation page goes here!');
    }

    /**
     * @throws Throwable
     */
    public function success(Request $request)
    {
//        $provider = new PayPalClient;
        $provider = new PayPal();      // To use express checkout.

        $provider->getAccessToken();

        $token = $request->get('token');

        $orderInfo = $provider->showOrderDetails($token);
        $response = $provider->capturePaymentOrder($token);

        $fixTax = PaymentGatewaysFields::where('key', 'paypal_fixed_charge')->where('type',
            PaymentGatewaysFields::CHARGE)->value('value');
        $percentTax = PaymentGatewaysFields::where('key', 'paypal_percent_charge')->where('type',
            PaymentGatewaysFields::CHARGE)->value('value');

        if (!empty($fixTax)) {
            $depositAmount = $orderInfo['purchase_units'][0]['amount']['value'] - $fixTax;
        } else {
            $totalTax = 100 + $percentTax;
            $taxAmount = $orderInfo['purchase_units'][0]['amount']['value'] * $percentTax / $totalTax;
            $depositAmount = $orderInfo['purchase_units'][0]['amount']['value'] - $taxAmount;
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
                'transaction_id' => $response['purchase_units'][0]['payments']['captures'][0]['id'],
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

            $transaction = DepositTransaction::create([
                'transaction_id' => $response['purchase_units'][0]['payments']['captures'][0]['id'],
                'type'           => PaymentGateway::PAYPAL,
                'amount'         => $orderInfo['purchase_units'][0]['amount']['value'],
                'deposit_amount' => $depositAmount - $totalUserCommission,
                'tax'            => !empty($fixTax) ? $fixTax : $percentTax,
                'user_id'        => getLogInUserId(),
                'currency_id'    => getCurrencyId(),
                'status'         => DepositTransaction::SUCCESS,
                'meta'           => json_encode($response),
            ]);

            $type = PaymentGateway::REFERRAL_PAYMENT_METHOD[PaymentGateway::DEPOSIT_COMMISSION];
            $userLevelData = UserReferralsLevel::whereUserId($referralUsersId)->whereType(UserReferralsLevel::DEPOSIT_COMMISSION)->value('level');
            userReferralCommissionMail($referralUsersId, $totalUserCommission, $transaction, $userLevelData, $type);

            $depositId = DepositTransaction::whereUserId($referralUsersId)->whereTransactionId($referralTransaction->transaction_id)->value('id');

            UserReferralsCommission::create([
                'referral_by_id' => $referralUsersId,
                'referral_to_id' => getLogInUserId(),
                'type'           => UserReferralsLevel::DEPOSIT_COMMISSION,
                'deposit_id'     => $depositId,
            ]);
            
        } else {
            $transaction = DepositTransaction::create([
                'transaction_id' => $response['purchase_units'][0]['payments']['captures'][0]['id'],
                'type'           => PaymentGateway::PAYPAL,
                'amount'         => $orderInfo['purchase_units'][0]['amount']['value'],
                'deposit_amount' => $depositAmount,
                'tax'            => !empty($fixTax) ? $fixTax : $percentTax,
                'user_id'        => getLogInUserId(),
                'currency_id'    => getCurrencyId(),
                'status'         => DepositTransaction::SUCCESS,
                'meta'           => json_encode($response),
            ]);
        }
        Flash::success(__('messages.flash.app_payment_successful'));

        $input['email'] = EmailTemplate::where('name' ,'Deposit')->first();
        $input['name'] = getLogInUser()->full_name;
        $input['amount'] = $depositAmount;
        $input['payment_type'] = PaymentGateway::PAYMENT_METHOD[PaymentGateway::PAYPAL];
        $input['transaction_number'] = $transaction->transaction_id;
        $input['charge'] = $taxAmount;
        $input['currency'] = getCurrencyIcon();

        Mail::to(getAdminEmail())
            ->send(new ManuallyPaymentRequest('emails.manually_payment_request_mail',
                __($input['email']->subject),
                $input));

        return redirect(route('user.deposit-transaction.index'));


    }
}
