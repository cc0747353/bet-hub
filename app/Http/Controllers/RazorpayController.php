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
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Mail;
use Laracasts\Flash\Flash;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Razorpay\Api\Api;

class RazorpayController extends AppBaseController
{
    public function onBoard(Request $request): JsonResponse
    {

        $amount = $request['payloadData'];
        $gateways = getPaymentCredentials('Razorpay');

        $api = new Api($gateways['razorpay_key'], $gateways['razorpay_secret']);
        $orderData = [
            'receipt'  => 1,
            'amount'   => $amount * 100, // 100 = 1 rupees
            'currency' => getCurrencyCode(),
        ];

        $razorpayOrder = $api->order->create($orderData);
        $data['id'] = $razorpayOrder->id;
        $data['amount'] = $amount;

        return $this->sendResponse($data, __('messages.flash.order_create'));
    }

    /**
     * @param Request $request
     *
     *
     * @return false|Application|RedirectResponse|Redirector
     */
    public function paymentSuccess(Request $request)
    {

        $input = $request->all();

        Log::info('RazorPay Payment Successfully');
        $gateways = getPaymentCredentials('Razorpay');
        $api = new Api($gateways['razorpay_key'], $gateways['razorpay_secret']);
        if (count($input) && !empty($input['razorpay_payment_id'])) {
            try {
                $payment = $api->payment->fetch($input['razorpay_payment_id']);
                $generatedSignature = hash_hmac('sha256', $payment['order_id']."|".$input['razorpay_payment_id'],
                    $gateways['razorpay_secret']);
                if ($generatedSignature != $input['razorpay_signature']) {
                    Flash::error(__('messages.flash.unable_to_process_payment'));

                    return redirect()->back();
                }
                // Create Transaction Here
                $paymentAmount = $payment->amount / 100;
                $fixTax = PaymentGatewaysFields::where('key', 'razorpay_fixed_charge')->where('type',
                    PaymentGatewaysFields::CHARGE)->value('value');
                $percentTax = PaymentGatewaysFields::where('key', 'razorpay_percent_charge')->where('type',
                    PaymentGatewaysFields::CHARGE)->value('value');

                if (!empty($fixTax)) {
                    $depositAmount = $paymentAmount - $fixTax;
                } else {
                    $totalTax = 100 + $percentTax;
                    $taxAmount = $paymentAmount * $percentTax / $totalTax;
                    $depositAmount = $paymentAmount - $taxAmount;
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
                        'transaction_id' => $payment->id,
                        'type'           => PaymentGateway::DEPOSIT_COMMISSION,
                        'amount'         => null,
                        'deposit_amount' => $totalUserCommission,
                        'tax'            => null,
                        'user_id'        => $referralUsersId,
                        'currency_id'    => getCurrencyId(),
                        'status'         => DepositTransaction::SUCCESS,
                        'meta'           => json_encode($payment->toArray()),
                        'message'        => 'Deposit commission referred by '.getLogInUser()->referral_by.' to '.getLogInUser()->user_name,
                    ]);

                    $Transaction = DepositTransaction::create([
                        'transaction_id' => $payment->id,
                        'type'           => PaymentGateway::RAZORPAY,
                        'amount'         => $payment->amount / 100,
                        'deposit_amount' => $depositAmount - $totalUserCommission,
                        'tax'            => !empty($fixTax) ? $fixTax : $percentTax,
                        'user_id'        => getLogInUserId(),
                        'currency_id'    => getCurrencyId(),
                        'status'         => DepositTransaction::SUCCESS,
                        'meta'           => json_encode($payment->toArray()),
                    ]);

                    $depositId = DepositTransaction::whereUserId($referralUsersId)->whereTransactionId($referralTransaction->transaction_id)->value('id');
                    
                    UserReferralsCommission::create([
                        'referral_by_id' => $referralUsersId,
                        'referral_to_id' => getLogInUserId(),
                        'type'           => UserReferralsLevel::DEPOSIT_COMMISSION,
                        'deposit_id'     => $depositId,
                    ]);
                    
                    $type = PaymentGateway::REFERRAL_PAYMENT_METHOD[PaymentGateway::DEPOSIT_COMMISSION];
                    $userLevelData = UserReferralsLevel::whereUserId($referralUsersId)->whereType(UserReferralsLevel::DEPOSIT_COMMISSION)->value('level');
                    userReferralCommissionMail($referralUsersId, $totalUserCommission, $Transaction, $userLevelData, $type);
                } else {
                    $Transaction = DepositTransaction::create([
                        'transaction_id' => $payment->id,
                        'type'           => PaymentGateway::RAZORPAY,
                        'amount'         => $payment->amount / 100,
                        'deposit_amount' => $depositAmount,
                        'tax'            => !empty($fixTax) ? $fixTax : $percentTax,
                        'user_id'        => getLogInUserId(),
                        'currency_id'    => getCurrencyId(),
                        'status'         => DepositTransaction::SUCCESS,
                        'meta'           => json_encode($payment->toArray()),
                    ]);
                }

                $input['email'] = EmailTemplate::where('name' ,'Deposit')->first();
                $input['name'] = getLogInUser()->full_name;
                $input['amount'] = $depositAmount;
                $input['payment_type'] = PaymentGateway::PAYMENT_METHOD[PaymentGateway::RAZORPAY];
                $input['transaction_number'] = $Transaction->transaction_id;
                $input['charge'] = $taxAmount;
                $input['currency'] = getCurrencyIcon();

                Mail::to(getAdminEmail())
                    ->send(new ManuallyPaymentRequest('emails.manually_payment_request_mail',
                        __($input['email']->subject),
                        $input));

                Flash::success(__('messages.flash.app_payment_successful'));
                return redirect(route('user.deposit-transaction.index'));

            } catch (Exception $e) {

                return false;
            }
        }

        Flash::error(__('messages.flash.unable_to_process_payment'));

        return redirect()->back();
    }

    public function paymentFailed(Request $request): Application|RedirectResponse|Redirector
    {
        Flash::error(__('messages.flash.unable_to_process_payment'));

        return redirect(route('user.deposit-transaction.index'));
    }

    /**
     * @param Request $request
     *
     *
     * @return false|Application|RedirectResponse|Redirector
     */
    public function paymentSuccessWebHook(Request $request)
    {
        $input = $request->all();
        Log::info('webHook Razorpay');
        Log::info($input);
        if (isset($input['event']) && $input['event'] == 'payment.captured' && isset($input['payload']['payment']['entity'])) {
            $payment = $input['payload']['payment']['entity'];

            Flash::success(__('messages.flash.app_payment_successful'));

            return redirect(route('user.deposit-transaction.index'));
        }

        return false;
    }
}
