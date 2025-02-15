@php
    $recentWinnerData = getRecentWinnerDataFront()
@endphp
<div class="col-xxl-2 col-lg-3 pt-40">
    @if($recentWinnerData->isNotEmpty())
    <div class="recent-winner-box bg-secondary br-10 py-20">
        <div class="heading-text px-20 mb-3">
            <h3 class="text-white d-inline me-3">{{ __('messages.front.recent_winners') }}</h3>
        </div>
        <div class="categories">
            @foreach($recentWinnerData as $recentWinner)
                <a href="#!"
                   class="d-flex justify-content-between fs-14 pe-none"> {{ $recentWinner->user->full_name }}
                    <span>{{ $recentWinner->win_amount.' '.$recentWinner->currency->currency_icon }}</span>
                </a>
            @endforeach
        </div>
    </div>
    @endif
</div>
