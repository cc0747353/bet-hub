<?php

namespace App\Http\Controllers;

use App\Mail\ManuallyPaymentRequest;
use App\Mail\ReferralCommission;
use App\Models\DepositTransaction;
use App\Models\EmailTemplate;
use App\Models\PaymentGateway;
use App\Models\PaymentGatewaysFields;
use App\Models\Referral;
use App\Models\ReferralLevel;
use App\Models\User;
use App\Models\UserReferralsCommission;
use App\Models\UserReferralsLevel;
use App\Repositories\AddPaymentRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Laracasts\Flash\Flash;
use Stripe\Checkout\Session;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class StripePaymentController extends AppBaseController
{

    /**
     * @var AddPaymentRepository
     */
    private AddPaymentRepository $addPaymentRepository;

    /**
     * @param AddPaymentRepository $addPaymentRepository
     */
    public function __construct(AddPaymentRepository $addPaymentRepository)
    {
        $this->addPaymentRepository = $addPaymentRepository;

        $gateways = getPaymentCredentials('Stripe');

        config(['services.stripe.key' => $gateways['stripe_key'],'services.stripe.secret_key' => $gateways['stripe_secret']]);
    }


    public function addPayment(Request $request): JsonResponse
    {
        $result = $this->addPaymentRepository->manageStripeData(
            getLogInUserId(),
            [
                'amountToPay' => $request['amount'],
            ]
        );

        return $this->sendResponse($result, 'Session created successfully.');

    }

    /**
     * @param Request $request
     *
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function paymentSuccess(Request $request)
    {
        $sessionId = $request->get('session_id');
        if (empty($sessionId)) {
            throw new UnprocessableEntityHttpException('session_id required');
        }
        try {
            setStripeApiKey();
            $sessionData = Session::retrieve($request->session_id);
            if ($sessionData->currency != null && in_array($sessionData->currency,
                    zeroDecimalCurrencies())) {
                $paymentAmount = $sessionData->amount_total;
            } else {
                $paymentAmount = $sessionData->amount_total / 100;
            }
            $fixTax = PaymentGatewaysFields::where('key', 'stripe_fixed_charge')->where('type', PaymentGatewaysFields::CHARGE)->value('value');
            $percentTax = PaymentGatewaysFields::where('key', 'stripe_percent_charge')->where('type', PaymentGatewaysFields::CHARGE)->value('value');

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
                    'transaction_id' => $sessionData->payment_intent,
                    'type'           => PaymentGateway::DEPOSIT_COMMISSION,
                    'amount'         => null,
                    'deposit_amount' => $totalUserCommission,
                    'tax'            => null,
                    'user_id'        => $referralUsersId,
                    'currency_id'    => getCurrencyId(),
                    'status'         => DepositTransaction::SUCCESS,
                    'meta'           => json_encode($sessionData),
                    'message'        => 'Deposit commission referred by '.getLogInUser()->referral_by.' to '.getLogInUser()->user_name,
                ]);

                $transaction = DepositTransaction::create([
                    'transaction_id' => $sessionData->payment_intent,
                    'type'           => PaymentGateway::STRIPE,
                    'amount'         => $paymentAmount,
                    'deposit_amount' => $depositAmount - $totalUserCommission,
                    'tax'            => !empty($fixTax) ? $fixTax : $percentTax,
                    'user_id'        => getLogInUserId(),
                    'currency_id'    => getCurrencyId(),
                    'status'         => DepositTransaction::SUCCESS,
                    'meta'           => json_encode($sessionData),
                ]);

                $type = PaymentGateway::REFERRAL_PAYMENT_METHOD[PaymentGateway::DEPOSIT_COMMISSION];
                $userLevelData = UserReferralsLevel::whereUserId($referralUsersId)->whereType(UserReferralsLevel::DEPOSIT_COMMISSION)->value('level');
                userReferralCommissionMail($referralUsersId, $totalUserCommission, $transaction, $userLevelData, $type);

                $depositId = DepositTransaction::whereUserId($referralUsersId)->whereTransactionId($sessionData->payment_intent,)->value('id');
                    
                $userCommission = UserReferralsCommission::create([
                    'referral_by_id' => $referralUsersId,
                    'referral_to_id' => getLogInUserId(),
                    'type' => UserReferralsLevel::DEPOSIT_COMMISSION,
                    'deposit_id' => $depositId,
                ]);
                
            } else {
                $transaction = DepositTransaction::create([
                    'transaction_id' => $sessionData->payment_intent,
                    'type'           => PaymentGateway::STRIPE,
                    'amount'         => $paymentAmount,
                    'deposit_amount' => $depositAmount,
                    'tax'            => !empty($fixTax) ? $fixTax : $percentTax,
                    'user_id'        => getLogInUserId(),
                    'currency_id'    => getCurrencyId(),
                    'status'         => DepositTransaction::SUCCESS,
                    'meta'           => json_encode($sessionData),
                ]);
            }

            DB::commit();

            Flash::success(__('messages.flash.app_payment_successful'));

            $input['email'] = EmailTemplate::where('name' ,'Deposit')->first();
            $input['name'] = getLogInUser()->full_name;
            $input['amount'] = $depositAmount;
            $input['payment_type'] = PaymentGateway::PAYMENT_METHOD[PaymentGateway::STRIPE];
            $input['transaction_number'] = $transaction->transaction_id;
            $input['charge'] = $taxAmount;
            $input['currency'] = getCurrencyIcon();

            Mail::to(getAdminEmail())
                ->send(new ManuallyPaymentRequest('emails.manually_payment_request_mail',
                    __($input['email']->subject),
                    $input));

            return redirect(route('user.deposit-transaction.index'));

        } catch (\Exception $e) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    /**
     *
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function handleFailedPayment()
    {

        Flash::error(__('messages.flash.unable_to_process_payment'));

        return redirect(route('user.deposit-transaction.index'));
    }

}
