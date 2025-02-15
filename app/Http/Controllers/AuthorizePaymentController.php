<?php

namespace App\Http\Controllers;


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
use Illuminate\Support\Facades\Mail;
use Laracasts\Flash\Flash;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;
use PayPalHttp\HttpException;

/**
 * Class AuthorizePaymentController
 */
class AuthorizePaymentController extends AppBaseController
{
    public function onboard(Request $request)
    {
        $input = $request->all();
        $user = getLogInUser();

        $months = getMonth();

        return view('payments.authorize.index', compact('input', 'user', 'months'));
    }

    public function pay(Request $request)
    {
        $input = $request->input();
        $gateways = getPaymentCredentials('Authorize');
    
        /* Create a merchantAuthenticationType object with authentication details
          retrieved from the constants file */
        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName($gateways['authorize_key']);
        $merchantAuthentication->setTransactionKey($gateways['authorize_secret']);

        // Set the transaction's refId
        $refId = 'ref'.time();
        $cardNumber = preg_replace('/\s+/', '', $input['cardNumber']);

        // Create the payment data for a credit card
        $creditCard = new AnetAPI\CreditCardType();
        $creditCard->setCardNumber($cardNumber);
        $creditCard->setExpirationDate($input['expiration-year']."-".$input['expiration-month']);
        $creditCard->setCardCode($input['cvv']);

        // Add the payment data to a paymentType object
        $paymentOne = new AnetAPI\PaymentType();
        $paymentOne->setCreditCard($creditCard);

        // Create a TransactionRequestType object and add the previous objects to it
        $transactionRequestType = new AnetAPI\TransactionRequestType();
        $transactionRequestType->setTransactionType("authCaptureTransaction");
        $transactionRequestType->setAmount($input['amount']);
        $transactionRequestType->setPayment($paymentOne);

        // Assemble the complete transaction request
        $requests = new AnetAPI\CreateTransactionRequest();
        $requests->setMerchantAuthentication($merchantAuthentication);
        $requests->setRefId($refId);
        $requests->setTransactionRequest($transactionRequestType);

        // Create the controller and get the response
        $controller = new AnetController\CreateTransactionController($requests);
        $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);

        if ($response != null) {
            // Check to see if the API request was successfully received and acted upon
            if ($response->getMessages()->getResultCode() == "Ok") {
                // Since the API request was successful, look for a transaction response
                // and parse it to display the results of authorizing the card
                $tresponse = $response->getTransactionResponse();
                $paymentAmount = $input['amount'];
                if ($tresponse != null && $tresponse->getMessages() != null) {
                    $message_text = $tresponse->getMessages()[0]->getDescription().", Transaction ID: ".$tresponse->getTransId();
                    $msg_type = "success_msg";

                    try {

                        $fixTax = PaymentGatewaysFields::where('key', 'authorize_fixed_charge')->where('type', PaymentGatewaysFields::CHARGE)->value('value');
                        $percentTax = PaymentGatewaysFields::where('key', 'authorize_percent_charge')->where('type', PaymentGatewaysFields::CHARGE)->value('value');

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
                                'transaction_id' => $tresponse->getTransId(),
                                'type'           => PaymentGateway::DEPOSIT_COMMISSION,
                                'amount'         => null,
                                'deposit_amount' => $totalUserCommission,
                                'tax'            => null,
                                'user_id'        => $referralUsersId,
                                'currency_id'    => getCurrencyId(),
                                'status'         => DepositTransaction::SUCCESS,
                                'meta'           => json_encode($tresponse),
                                'message'        => 'Deposit commission referred by '.getLogInUser()->referral_by.' to '.getLogInUser()->user_name,
                            ]);

                            $transaction = DepositTransaction::create([
                                'transaction_id' => $tresponse->getTransId(),
                                'type'           => PaymentGateway::AUTHORIZE,
                                'amount'         => $paymentAmount,
                                'deposit_amount' => $depositAmount - $totalUserCommission,
                                'tax'            => !empty($fixTax) ? $fixTax : $percentTax,
                                'user_id'        => getLogInUserId(),
                                'currency_id'    => getCurrencyId(),
                                'status'         => DepositTransaction::SUCCESS,
                                'meta'           => json_encode($tresponse),
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
                            
                        }else {
                            DepositTransaction::create([
                                'transaction_id' => $tresponse->getTransId(),
                                'type'           => PaymentGateway::AUTHORIZE,
                                'amount'         => $paymentAmount,
                                'deposit_amount' => $depositAmount,
                                'tax'            => !empty($fixTax) ? $fixTax : $percentTax,
                                'user_id'        => getLogInUserId(),
                                'currency_id'    => getCurrencyId(),
                                'status'         => DepositTransaction::SUCCESS,
                                'meta'           => json_encode($tresponse),
                            ]);
                        }

                        Flash::success(__('messages.flash.app_payment_successful'));
                        return redirect(route('user.deposit-transaction.index'));


                    } catch (HttpException $ex) {
                        echo $ex->statusCode;
                        print_r($ex->getMessage());
                    }

                } else {
                    $message_text = __('messages.flash.there_were');
                    $msg_type = "error_msg";

                    if ($tresponse->getErrors() != null) {
                        $message_text = $tresponse->getErrors()[0]->getErrorText();
                        $msg_type = "error_msg";
                    }
                }
                // Or, print errors if the API request wasn't successful
            } else {
                $message_text = __('messages.flash.there_were');
                $msg_type = "error_msg";

                $tresponse = $response->getTransactionResponse();

                if ($tresponse != null && $tresponse->getErrors() != null) {
                    $message_text = $tresponse->getErrors()[0]->getErrorText();
                    $msg_type = "error_msg";
                } else {
                    $message_text = $response->getMessages()->getMessage()[0]->getText();
                    $msg_type = "error_msg";
                }
            }
        } else {
            $message_text = "No response returned";
            $msg_type = "error_msg";
        }

        return back()->with($msg_type, $message_text);
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
