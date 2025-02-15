@php
    $settings = App\Models\Setting::pluck('value','key')->toArray();
@endphp
<div id="addBetModal" class="modal fade " role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header text-white bg-blue-200">
                <h3 class="modal-title" id="betModalLabel"></h3>
                <button type="button" class="btn-close btn-primary" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            {{ Form::open(['id'=>'addBetForm','files' => 'true']) }}
            <div class="modal-body bg-dark">
                <div class="alert alert-danger d-none hide" id="validationErrorsBox"></div>
                <div class="row">
                    <div class="form-group col-md-12 mb-3 text-center text-white">
                        <h5 id="betModalQuestion"></h5>
                        <span>You are betting for  <span id="betModalOption"></span></span>
                        <br>
                        <span class="text-warning">Available Balance : {{ getCurrencyIcon().' ' }}<span id="userBalance"></span></span>
                    </div>
                    <div class="form-group col-md-12 mb-3 text-white">
                        {{ Form::label('amount', __('Enter Bet Amount').(':'), ['class' => 'form-label']) }}
                        <span class="required"></span>
                        {{ Form::text('amount', null, ['id'=>'amount','class' => 'form-control bg-blue-200 text-white','required','onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")','placeholder' => __('Enter Bet Amount')]) }}
                    </div>
                    <div class="form-group col-md-12 text-white">
                        <p>Minimum Limit : {{ getCurrencyIcon().' '.$settings['min_bet'] }}</p>
                        <input type="hidden" value="{{ $settings['min_bet'] }}" id="minBet">
                        <p>Maximum Limit : {{ getCurrencyIcon().' '.$settings['max_bet'] }}</p>
                        <input type="hidden" value="{{ $settings['max_bet'] }}" id="maxBet">
                    </div>
                    <div class="form-group col-md-12 d-flex justify-content-center text-white">
                        <h5 class="mt-2 fs-4">If you win you will get: </h5>
                        <p class=" fs-3 ps-2 text-primary">{{ getCurrencyIcon() }}</p>
                        <p id="totalAmount" class="fs-3 text-primary"></p>
                    </div>
                    <input type="hidden" id="matchId" value="">
                    <input type="hidden" id="questionId" value="">
                    <input type="hidden" id="optionId" value="">
                    <input type="hidden" id="divisorData" value="">
                </div>
            </div>
            <div class="modal-footer pt-0 bg-blue-200">
                {{ Form::button(__('messages.common.save'), ['type' => 'submit','class' => 'btn btn-primary m-0','id' => 'betAddBtn','data-loading-text' => "<span class='spinner-border spinner-border-sm'></span> Processing..."]) }}
                <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('messages.common.cancel') }}</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
