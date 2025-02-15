<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOptionRequest;
use App\Http\Requests\UpdateOptionRequest;
use App\Mail\BetLoseMail;
use App\Mail\BetPlaceMail;
use App\Mail\BetRefundMail;
use App\Mail\BetWinMail;
use App\Mail\ReferralCommission;
use App\Models\AllMatch;
use App\Models\Bet;
use App\Models\BetLost;
use App\Models\BetWin;
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
use App\Repositories\OptionsRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class OptionController extends AppBaseController
{

    /**
     * @param OptionsRepository $optionsRepository
     */
    public function __construct(OptionsRepository $optionsRepository)
    {
        $this->optionsRepo = $optionsRepository;
    }


    /**
     * @param $id
     *
     *
     * @return Application|Factory|View
     */
    public function index($id)
    {
        $question = Question::findOrFail($id);

        return view('manage_matches.questions_option.index', compact('question'));
    }

    public function store(CreateOptionRequest $request): JsonResponse
    {
        $input = $request->all();
        $input['status'] = isset($input['status']) ?: 0;
        $this->optionsRepo->create($input);

        return $this->sendSuccess(__('messages.flash.option_created'));
    }

    public function edit(Option $option): JsonResponse
    {
        return $this->sendResponse($option, __('messages.flash.option_retrieved'));
    }

    public function update(UpdateOptionRequest $request, Option $option): JsonResponse
    {
        $input = $request->all();
        $input['status'] = isset($input['status']) ?: 0;
        $this->optionsRepo->update($input, $option->id);

        return $this->sendSuccess(__('messages.flash.option_update'));
    }

    public function changeStatus(Request $request): JsonResponse
    {
        $option = Option::findOrFail($request->id);
        $option->update(['status' => !$option->status]);

        return $this->sendResponse($option, __('messages.flash.option_status'));
    }

    /**
     * @param Request $request
     *
     *
     * @return JsonResponse
     */
    public function makeWin(Request $request): JsonResponse
    {
        $betId = $request->recordId;
        $betsWinner = Bet::whereOptionId($betId)->get();
        if ($betsWinner->count() <= 0) {
            return $this->sendError(__('messages.flash.no_bets_found'));
        }
        $questionId = Bet::whereOptionId($betId)->value('question_id');
        $betsLoser = Bet::whereQuestionId($questionId)->whereNot('option_id', $betId)->get();

        foreach ($betsWinner as $bet) {
            $betData = Bet::whereUserId($bet->user_id)->whereStatus(Bet::WINNER)->count();
            $referralData = Referral::whereName('Bet Win Commission')->whereStatus(1)->value('id');
            $userData = User::whereId($bet->user_id)->value('referral_by');
            $userId = User::whereUserName($userData)->value('id');
            $userName = User::whereReferralBy($userData)->value('user_name');
            $userLevelDataExists = UserReferralsLevel::whereUserId($userId)->whereType(UserReferralsLevel::BET_WIN_COMMISSION)->exists();
            if ($userLevelDataExists) {
                $level = UserReferralsLevel::whereUserId($userId)->whereType(UserReferralsLevel::BET_WIN_COMMISSION)->value('level') + 1;
                $levelData = ReferralLevel::whereReferralId($referralData)->whereLevel($level)->first();
            } else {
                $levelData = ReferralLevel::whereReferralId($referralData)->latest('created_at')->first();
                if (!empty($levelData))
                {
                    $level = $levelData->level;
                }
            }

            if (!empty($userData) && $betData < 1 && !empty($referralData) && !empty($levelData)) {

                if ($userLevelDataExists) {
                    UserReferralsLevel::whereUserId($userId)->whereType(UserReferralsLevel::BET_WIN_COMMISSION)->update([
                        'referral_to_id' => $bet->user_id,
                        'level'          => $level,
                        'commission'     => $levelData['commission'],
                    ]);
                } else {
                    UserReferralsLevel::create([
                        'user_id'        => $userId,
                        'referral_to_id' => $bet->user_id,
                        'level'          => $levelData['level'],
                        'type'           => UserReferralsLevel::BET_WIN_COMMISSION,
                        'commission'     => $levelData['commission'],
                    ]);
                }

                $level = UserReferralsLevel::whereUserId($userId)->whereType(UserReferralsLevel::BET_WIN_COMMISSION)->value('level') ?? 1;
                $referralCommission = ReferralLevel::whereReferralId($referralData)->whereLevel($level)->value('commission');
                $totalUserCommission = $bet->amount * $referralCommission / 100;

                $referralTransaction = DepositTransaction::create([
                    'transaction_id' => Str::random(30),
                    'type'           => PaymentGateway::BET_WIN_COMMISSION,
                    'amount'         => null,
                    'deposit_amount' => $totalUserCommission,
                    'tax'            => null,
                    'user_id'        => $userId,
                    'currency_id'    => getCurrencyId(),
                    'status'         => DepositTransaction::SUCCESS,
                    'message'        => 'Bet Win commission referred by '.$userData.' to '.$userName,
                ]);

                $type = PaymentGateway::REFERRAL_PAYMENT_METHOD[PaymentGateway::BET_WIN_COMMISSION];
                $userLevelData = UserReferralsLevel::whereUserId($userId)->whereType(UserReferralsLevel::BET_WIN_COMMISSION)->value('level');

                $input['email'] = EmailTemplate::where('name', 'Referral Commission')->first();
                $input['name'] = getLoginUserData($userId)->full_name;
                $input['referral_to'] = getLoginUserData($bet->user_id)->full_name;
                $input['amount'] = $totalUserCommission;
                $input['currency'] = getCurrencyIcon();
                $input['transaction_number'] = $referralTransaction->transaction_id;
                $input['method_name'] = $type;
                $input['level'] = $userLevelData;

                $depositId = DepositTransaction::whereUserId($userId)->whereTransactionId($referralTransaction->transaction_id)->value('id');

                UserReferralsCommission::create([
                    'referral_by_id' => $userId,
                    'referral_to_id' => $bet->user_id,
                    'type'           => UserReferralsLevel::BET_WIN_COMMISSION,
                    'deposit_id'     => $depositId,
                ]);

                Mail::to(getLoginUserData($userId)->email)
                    ->send(new ReferralCommission('emails.referral_commission_mail',
                        __($input['email']->subject),
                        $input));
            }
            $bet->update(['status' => Bet::WINNER]);
            BetWin::create([
                'bet_id' => $bet->id,
                'amount' => $bet->win_amount,
            ]);

            $input['email'] = EmailTemplate::where('name', 'Bet Win')->first();
            $input['invest_amount'] = $bet->amount;
            $input['currency'] = getCurrencyIcon();
            $input['winner_amount'] = $bet->win_amount;
            $input['option'] = Option::whereId($bet['option_id'])->value('name');
            $input['match'] = AllMatch::whereId($bet['match_id'])->value('match_title');
            $input['question'] = Question::whereId($bet['question_id'])->value('question');
            $input['name'] = getLoginUserData($bet->user_id)->full_name;

            Mail::to(getLoginUserData($bet->user_id)->email)->send(new BetWinMail('emails.bet_win_mail',
                __($input['email']->subject), $input));

        }

        foreach ($betsLoser as $bet) {
            $bet->update(['status' => Bet::LOSER]);
            BetLost::create([
                'bet_id' => $bet->id,
                'amount' => $bet->amount,
            ]);

            $input['email'] = EmailTemplate::where('name', 'Bet Lose')->first();
            $input['lose_amount'] = $bet->amount;
            $input['name'] = getLoginUserData($bet->user_id)->full_name;
            $input['currency'] = getCurrencyIcon();
            $input['option'] = Option::whereId($bet['option_id'])->value('name');
            $input['match'] = AllMatch::whereId($bet['match_id'])->value('match_title');
            $input['question'] = Question::whereId($bet['question_id'])->value('question');

            Mail::to(getLoginUserData($bet->user_id)->email)->send(new BetLoseMail('emails.bet_lose_mail',
                __($input['email']->subject), $input));
        }

        Question::whereId($questionId)->update(['result_declared' => true]);

        return $this->sendSuccess(__('messages.flash.winner_make'));
    }


    /**
     * @param Request $request
     *
     *
     * @return JsonResponse
     */
    public function makeLoser(Request $request): JsonResponse
    {
        $questionId = $request->questionId;
        $bets = Bet::whereQuestionId($questionId)->get();
        if ($bets->count() <= 0) {
            return $this->sendError(__('messages.flash.no_bets_found'));
        }

        foreach ($bets as $bet) {
            $bet->update(['status' => Bet::LOSER]);
            BetLost::create([
                'bet_id' => $bet->id,
                'amount' => $bet->amount,
            ]);

            $input['email'] = EmailTemplate::where('name', 'Bet Lose')->first();
            $input['lose_amount'] = $bet->amount;
            $input['name'] = getLoginUserData($bet->user_id)->full_name;
            $input['currency'] = getCurrencyIcon();
            $input['option'] = Option::whereId($bet['option_id'])->value('name');
            $input['match'] = AllMatch::whereId($bet['match_id'])->value('match_title');
            $input['question'] = Question::whereId($bet['question_id'])->value('question');

            Mail::to(getLoginUserData($bet->user_id)->email)->send(new BetLoseMail('emails.bet_lose_mail',
                __($input['email']->subject), $input));
        }

        Question::whereId($questionId)->update(['result_declared' => true]);

        return $this->sendSuccess(__('messages.flash.make_everyone_loser'));
    }

    public function giveRefund(Request $request): JsonResponse
    {
        $questionId = $request->questionId;
        $bets = Bet::whereQuestionId($questionId)->get();
        if ($bets->count() <= 0) {
            return $this->sendError(__('messages.flash.no_bets_found'));
        }
        foreach ($bets as $bet) {
            $bet->update(['status' => Bet::REFUND]);

            $input['email'] = EmailTemplate::where('name', 'Bet Refund')->first();
            $input['refund_amount'] = $bet->amount;
            $input['name'] = getLoginUserData($bet->user_id)->full_name;
            $input['currency'] = getCurrencyIcon();
            $input['option'] = Option::whereId($bet['option_id'])->value('name');
            $input['match'] = AllMatch::whereId($bet['match_id'])->value('match_title');
            $input['question'] = Question::whereId($bet['question_id'])->value('question');

            Mail::to(getLoginUserData($bet->user_id)->email)->send(new BetRefundMail('emails.bet_refund_mail',
                __($input['email']->subject), $input));
        }

        Question::whereId($questionId)->update(['result_declared' => true]);

        return $this->sendSuccess(__('messages.flash.give_refund'));
    }
}
