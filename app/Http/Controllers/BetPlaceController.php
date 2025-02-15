<?php

namespace App\Http\Controllers;

use App\Mail\BetPlaceMail;
use App\Mail\ReferralCommission;
use App\Models\AllMatch;
use App\Models\Bet;
use App\Models\DepositTransaction;
use App\Models\EmailTemplate;
use App\Models\Option;
use App\Models\PaymentGateway;
use App\Models\Question;
use App\Models\Referral;
use App\Models\ReferralLevel;
use App\Models\User;
use App\Models\UserReferralsCommission;
use App\Models\UserReferralsLevel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class BetPlaceController extends AppBaseController
{
    public function index(Request $request): JsonResponse
    {
        $input = $request->all();
        $exists = Bet::whereMatchId($input['match_id'])->where('question_id', $input['question_id'])
            ->where('user_id', getLogInUserId())->exists();

        $user_available_balance = getTotalBalance();

        if ($exists) {
            return $this->sendError(__('messages.flash.bet_already_placed'));
        }

        if ($user_available_balance < $input['amount']) {
            return $this->sendError(__('messages.flash.you_do_not_have'));
        }

        $betData = Bet::whereUserId(getLogInUserId())->count();
        $referralData = Referral::whereName('Bet Place Commission')->whereStatus(1)->value('id');
        $referralByUseId = User::whereUserName(getLoginUserData(getLogInUserId())->referral_by)->value('id');
        $userLevelDataExists = UserReferralsLevel::whereUserId($referralByUseId)->whereType(UserReferralsLevel::BET_PLACE_COMMISSION)->exists();
        if ($userLevelDataExists) {
            $level = UserReferralsLevel::whereUserId($referralByUseId)->whereType(UserReferralsLevel::BET_PLACE_COMMISSION)->value('level') + 1;
            $levelData = ReferralLevel::whereReferralId($referralData)->whereLevel($level)->first();
        } else {
            $levelData = ReferralLevel::whereReferralId($referralData)->latest('created_at')->first();
        }
        if (!empty(getLoginUserData(getLogInUserId())->referral_by) && $betData < 1 && !empty($referralData) && !empty($levelData)) {
            userReferralsLevel(UserReferralsLevel::BET_PLACE_COMMISSION);

            $referralUsersId = User::whereUserName(getLoginUserData(getLogInUserId())->referral_by)->value('id');
            $level = UserReferralsLevel::whereUserId($referralUsersId)->whereType(UserReferralsLevel::BET_PLACE_COMMISSION)->value('level') ?? 1;
            $referralCommission = ReferralLevel::whereReferralId($referralData)->whereLevel($level)->value('commission');
            $totalUserCommission = $input['amount'] * $referralCommission / 100;

            $referralTransaction = DepositTransaction::create([
                'transaction_id' => Str::random(30),
                'type'           => PaymentGateway::BET_PLACE_COMMISSION,
                'amount'         => null,
                'deposit_amount' => $totalUserCommission,
                'tax'            => null,
                'user_id'        => $referralUsersId,
                'currency_id'    => getCurrencyId(),
                'status'         => DepositTransaction::SUCCESS,
                'meta'           => null,
                'message'        => 'Bet Place commission referred by '.getLogInUser()->referral_by.' to '.getLogInUser()->user_name,
            ]);

            $type = PaymentGateway::REFERRAL_PAYMENT_METHOD[PaymentGateway::BET_PLACE_COMMISSION];
            $userLevelData = UserReferralsLevel::whereUserId($referralUsersId)->whereType(UserReferralsLevel::BET_PLACE_COMMISSION)->value('level');
            userReferralCommissionMail($referralUsersId, $totalUserCommission, $referralTransaction, $userLevelData, $type);
            
            $depositId = DepositTransaction::whereUserId($referralUsersId)->whereTransactionId($referralTransaction->transaction_id)->value('id');

            UserReferralsCommission::create([
                'referral_by_id' => $referralUsersId,
                'referral_to_id' => getLogInUserId(),
                'type'           => UserReferralsLevel::BET_PLACE_COMMISSION,
                'deposit_id'     => $depositId,
            ]);
        }

        $betPlace = Bet::create([
            'amount'      => $input['amount'],
            'user_id'     => getLogInUserId(),
            'currency_id' => getCurrencyId(),
            'match_id'    => $input['match_id'],
            'question_id' => $input['question_id'],
            'option_id'   => $input['option_id'],
            'win_amount'  => $input['win_amount'],
        ]);
        
        $input['email'] = EmailTemplate::where('name', 'Bet Placed')->first();
        $input['currency'] = getCurrencyIcon();
        $input['amount'] = $betPlace->amount;
        $input['name'] = getLoginUserData(getLogInUserId())->full_name;
        $input['option'] = Option::whereId($betPlace['option_id'])->value('name');
        $input['match'] = AllMatch::whereId($betPlace['match_id'])->value('match_title');
        $input['question'] = Question::whereId($betPlace['question_id'])->value('question');
        $input['return_amount'] = $betPlace->win_amount;
        $input['post_balance'] = $user_available_balance - $betPlace->amount;

        Mail::to(getLoginUserData(getLogInUserId())->email)
            ->send(new BetPlaceMail('emails.bet_place_mail',
                __($input['email']->subject),
                $input));
        
        return $this->sendSuccess(__('messages.flash.bet_placed'));
    }
}
