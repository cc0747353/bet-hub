<?php

namespace App\Http\Controllers;

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
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class TransactionController extends Controller
{
    public function changeTransactionStatus(Request $request): JsonResponse
    {
        $input = $request->all();
        $transaction = DepositTransaction::findOrFail($input['id']);

        $paymentAmount = DepositTransaction::whereId($input['id'])->value('amount');

        $fixTax = PaymentGatewaysFields::where('key', 'manually_fixed_charge')->where('type',
            PaymentGatewaysFields::CHARGE)->value('value');
        $percentTax = PaymentGatewaysFields::where('key', 'manually_percent_charge')->where('type',
            PaymentGatewaysFields::CHARGE)->value('value');

        if (!empty($fixTax)) {
            $depositAmount = $paymentAmount - $fixTax;
        } else {
            $totalTax = 100 + $percentTax;
            $taxAmount = $paymentAmount * $percentTax / $totalTax;
            $depositAmount = $paymentAmount - $taxAmount;
        }

        $referralData = Referral::whereName('Deposit Commission')->whereStatus(1)->value('id');
        $userData = User::whereId($transaction->user_id)->value('referral_by');
        $userId = User::whereUserName($userData)->value('id');
        $depositData = DepositTransaction::whereUserId($transaction->user_id)->whereStatus(1)->count();

        $userLevelDataExists = UserReferralsLevel::whereUserId($userId)->whereType(UserReferralsLevel::DEPOSIT_COMMISSION)->exists();
        if ($userLevelDataExists) {
            $level = UserReferralsLevel::whereUserId($userId)->whereType(UserReferralsLevel::DEPOSIT_COMMISSION)->value('level') + 1;
            $levelData = ReferralLevel::whereReferralId($referralData)->whereLevel($level)->first();
        } else {
            $levelData = ReferralLevel::whereReferralId($referralData)->latest('created_at')->first();
            $level = $levelData->level;
        }
        if (!empty($userData) && $depositData < 1 && !empty($referralData) && !empty($levelData)) {

            if ($userLevelDataExists) {
                UserReferralsLevel::whereUserId($userId)->whereType(UserReferralsLevel::DEPOSIT_COMMISSION)->update([
                    'level'      => $level,
                    'commission' => $levelData['commission'],
                    'referral_to_id' => $transaction->user_id
                ]);
            } else {
                UserReferralsLevel::create([
                    'user_id'    => $userId,
                    'level'      => $levelData['level'],
                    'type'       => UserReferralsLevel::DEPOSIT_COMMISSION,
                    'commission' => $levelData['commission'],
                    'referral_to_id' => $transaction->user_id
                ]);
            }
            
            $level = UserReferralsLevel::whereUserId($userId)->value('level');
            $referralCommission = ReferralLevel::whereReferralId($referralData)->whereLevel($level)->value('commission');
            $totalUserCommission = $depositAmount * $referralCommission / 100;

            $referralByTransaction = DepositTransaction::create([
                'transaction_id' => $transaction->transaction_id,
                'type'           => PaymentGateway::DEPOSIT_COMMISSION,
                'amount'         => null,
                'deposit_amount' => $totalUserCommission,
                'tax'            => null,
                'user_id'        => $userId,
                'currency_id'    => getCurrencyId(),
                'status'         => DepositTransaction::SUCCESS,
                'message'        => 'Deposit commission referred by '.getLogInUser()->referral_by.' to '.getLogInUser()->user_name,
            ]);

            $referralToTransaction = DepositTransaction::whereId($input['id'])->update([
                'transaction_id' => $transaction->transaction_id,
                'type'           => PaymentGateway::MANUALLY,
                'amount'         => $paymentAmount,
                'deposit_amount' => $depositAmount - $totalUserCommission,
                'tax'            => !empty($fixTax) ? $fixTax : $percentTax,
                'user_id'        => $transaction->user_id,
                'currency_id'    => getCurrencyId(),
                'status'         => DepositTransaction::SUCCESS,
            ]);
            $type = PaymentGateway::REFERRAL_PAYMENT_METHOD[PaymentGateway::DEPOSIT_COMMISSION];
            $userLevelData = UserReferralsLevel::whereUserId($userId)->whereType(UserReferralsLevel::DEPOSIT_COMMISSION)->value('level');
    
            $input['email'] = EmailTemplate::where('name', 'Referral Commission')->first();
            $input['name'] = getLoginUserData($userId)->full_name;
            $input['referral_to'] = getLoginUserData($transaction->user_id)->full_name;
            $input['amount'] = $totalUserCommission;
            $input['currency'] = getCurrencyIcon();
            $input['transaction_number'] = $transaction->transaction_id;
            $input['method_name'] = $type;
            $input['level'] = $userLevelData;
            
            Mail::to(getLoginUserData($userId)->email)
                ->send(new ReferralCommission('emails.referral_commission_mail',
                    __($input['email']->subject),
                    $input));
            
            $userCommission = UserReferralsCommission::create([
                'referral_by_id' => $userId,
                'referral_to_id' => $transaction['user_id'],
                'type'           => UserReferralsLevel::DEPOSIT_COMMISSION,
                'deposit_id'     => $referralByTransaction->id,
            ]);

        } else {
            DepositTransaction::whereId($input['id'])->update([
                'status' => DepositTransaction::SUCCESS,
            ]);
        }

        return response()->json(['success' => true, 'message' => __('messages.common.status_updated_successfully')]);
    }
}
