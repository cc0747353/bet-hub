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
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Laracasts\Flash\Flash;
use Unicodeveloper\Paystack\Facades\Paystack;

class PaystackController extends Controller
{

    public function __construct()
    {
        $gateways = getPaymentCredentials('Paystack');

        config(['paystack.publicKey'  => $gateways['paystack_key'],
                'paystack.secretKey'  => $gateways['paystack_secret'],
                'paystack.paymentUrl' => 'https://api.paystack.co',
        ]);
    }

    /**
     * @param Request $request
     *
     *
     * @return mixed
     */
    public function redirectToGateway(Request $request)
    {

        $user = getLogInUser();
        $amount = $request['payloadData'];
        $order = $request['payloadData'].'|'.$user->id.'|'.time();

        if (!in_array(getCurrencyCode(), ['ZAR'])) {
            Flash::error(__('messages.flash.paystack_currency_error'));

            return redirect(route('user.deposit-transaction.index'));
        }

        request()->merge([
            "email"     => $user->email, // email of recipients
            "orderID"   => $order, // anything 
            "amount"    => $amount * 100,
            "quantity"  => 1, // always 1   
            "currency"  => 'ZAR',
            "reference" => Paystack::genTranxRef(),
            "metadata"  => json_encode(['order' => $order]), // this should be related data
        ]);

        return Paystack::getAuthorizationUrl()->redirectNow();

    }

    /**
     * @param Request $request
     *
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function handleGatewayCallback(Request $request)
    {
        $paymentDetails = Paystack::getPaymentData();
        $oderId = $paymentDetails['data']['metadata']['order'];

        list($amount, $loginUserId) = explode('|', $oderId);

        $fixTax = PaymentGatewaysFields::where('key', 'paystack_fixed_charge')->where('type',
            PaymentGatewaysFields::CHARGE)->value('value');
        $percentTax = PaymentGatewaysFields::where('key', 'paystack_percent_charge')->where('type',
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
                'transaction_id' => $paymentDetails['data']['reference'],
                'type'           => PaymentGateway::DEPOSIT_COMMISSION,
                'amount'         => null,
                'deposit_amount' => $totalUserCommission,
                'tax'            => null,
                'user_id'        => $referralUsersId,
                'currency_id'    => getCurrencyId(),
                'status'         => DepositTransaction::SUCCESS,
                'meta'           => json_encode($paymentDetails['data']),
                'message'        => 'Deposit commission referred by '.getLogInUser()->referral_by.' to '.getLogInUser()->user_name,
            ]);

            $transaction = DepositTransaction::create([
                'transaction_id' => $paymentDetails['data']['reference'],
                'type'           => PaymentGateway::PAYSTACK,
                'amount'         => $amount,
                'deposit_amount' => $depositAmount - $totalUserCommission,
                'tax'            => !empty($fixTax) ? $fixTax : $percentTax,
                'user_id'        => $loginUserId,
                'currency_id'    => getCurrencyId(),
                'status'         => DepositTransaction::SUCCESS,
                'meta'           => json_encode($paymentDetails['data']),
            ]);

            $type = PaymentGateway::REFERRAL_PAYMENT_METHOD[PaymentGateway::DEPOSIT_COMMISSION];
            $userLevelData = UserReferralsLevel::whereUserId($referralUsersId)->whereType(UserReferralsLevel::DEPOSIT_COMMISSION)->value('level');
            userReferralCommissionMail($referralUsersId, $totalUserCommission, $transaction, $userLevelData, $type);

            $depositId = DepositTransaction::whereUserId($referralUsersId)->whereTransactionId($tresponse->getTransId(),)->value('id');

            $userCommission = UserReferralsCommission::create([
                'referral_by_id' => $referralUsersId,
                'referral_to_id' => getLogInUserId(),
                'type'           => UserReferralsLevel::DEPOSIT_COMMISSION,
                'deposit_id'     => $depositId,
            ]);
            
        } else {
            $transaction = DepositTransaction::create([
                'transaction_id' => $paymentDetails['data']['reference'],
                'type'           => PaymentGateway::PAYSTACK,
                'amount'         => $amount,
                'deposit_amount' => $depositAmount,
                'tax'            => !empty($fixTax) ? $fixTax : $percentTax,
                'user_id'        => $loginUserId,
                'currency_id'    => getCurrencyId(),
                'status'         => DepositTransaction::SUCCESS,
                'meta'           => json_encode($paymentDetails['data']),
            ]);
        }
        DB::commit();

        Flash::success(__('messages.flash.app_payment_successful'));

        $input['email'] = EmailTemplate::where('name' ,'Deposit')->first();
        $input['name'] = getLogInUser()->full_name;
        $input['amount'] = $depositAmount;
        $input['payment_type'] = PaymentGateway::PAYMENT_METHOD[PaymentGateway::PAYSTACK];
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
