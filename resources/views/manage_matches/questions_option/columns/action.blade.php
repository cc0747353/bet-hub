@if(\App\Models\Bet::whereQuestionId($row->question_id)->whereStatus(\App\Models\Bet::WINNER)->count() > 0 || \App\Models\Bet::whereQuestionId($row->question_id)->whereStatus(\App\Models\Bet::LOSER)->count() > 0 || \App\Models\Bet::whereQuestionId($row->question_id)->whereStatus(\App\Models\Bet::REFUND)->count() > 0)
    @if(\App\Models\Bet::whereOptionId($row->id)->whereStatus(\App\Models\Bet::WINNER)->count() > 0)
        <span class="badge bg-light-success">{{__('messages.bets.winner')}}</span>
    @elseif(\App\Models\Bet::whereOptionId($row->id)->whereStatus(\App\Models\Bet::LOSER)->count() > 0)
        <span class="badge bg-light-danger">{{__('messages.bets.lose')}}</span>
    @elseif(\App\Models\Bet::whereOptionId($row->id)->whereStatus(\App\Models\Bet::REFUND)->count() > 0)
        <span class="badge bg-light-success">{{__('messages.bets.refunded')}}</span>
    @endif
@else
    <a href="javascript:void(0)" title="{{ __('messages.common.edit') }}"
       class="btn px-1 text-primary fs-3 option-edit-btn" data-bs-toggle="tooltip"
       data-bs-original-title="{{ __('messages.common.edit') }}" data-id="{{$row->id}}">
        <i class="fa-solid fa-pen-to-square"></i>
    </a>
    <a href="javascript:void(0)" title="{{ __('messages.common.make_win') }}"
       class="btn px-1 text-primary fs-3 option-make-win-btn" data-bs-toggle="tooltip"
       data-bs-original-title="{{ __('messages.common.make_win') }}" data-id="{{$row->id}}">
        <i class="fa-solid fa-trophy"></i>
    </a>
@endif
