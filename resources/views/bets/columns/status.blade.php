@if($row->status == \App\Models\Bet::WINNER)
    <span class="badge bg-light-success">{{__('messages.bets.winner')}}</span>
@elseif($row->status == \App\Models\Bet::LOSER)
    <span class="badge bg-light-danger">{{__('messages.bets.loser') }}</span>
@elseif($row->status == \App\Models\Bet::REFUND)
    <span class="badge bg-light-success">{{__('messages.bets.refunded') }}</span>
@else
    <span class="badge bg-light-warning">{{__('messages.bets.pending')}}</span>
@endif
