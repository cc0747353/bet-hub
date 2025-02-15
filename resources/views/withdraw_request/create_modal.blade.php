<div id="withdrawRequestModal" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel">{{ __('messages.withdraw.add_withdraw_request') }}</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            {{ Form::open(['id'=>'withdrawRequestForm','files' => 'true']) }}
            <div class="modal-body">
                <div class="alert alert-danger d-none hide" id="validationErrorsBox"></div>
                <div class="row">
                    <div class="form-group col-md-12 mb-5">
                        {{ Form::label('amount', __('messages.transaction.amount').(':'), ['class' => 'form-label']) }}
                        <span class="required"></span>
                        {{ Form::number('amount', null, ['id'=>'categoryName','class' => 'form-control','required' ,'placeholder' => __('messages.transaction.amount'),'min' => 1]) }}
                    </div>
                    <div>
                        {{Form::label('notes',__('messages.deposit.notes').(':'),['class' => 'form-label required'])}}
                        {{ Form::textarea('user_notes', null,['class' => 'form-control required mb-3' ,'placeholder' => __('messages.deposit.notes')])}}
                    </div>
                    <div class="form-group col-md-12 mb-5">
                        {{ Form::label('withdraw_method', __('messages.withdraw.withdraw_method').(':'), ['class' => 'form-label']) }}
                        <span class="required"></span>
                        {{ Form::select('withdraw_method', \App\Models\WithdrawRequests::PAYMENT_METHOD, '', [
                           'class' => 'form-select', 'required', 'id' => 'withdrawMethod', 'aria-label'=>"Select Withdraw Method",
                           'data-control'=>'select2', 'placeholder' => __('messages.withdraw.select_withdraw_method') ]) }}
                    </div>
                    <div class="form-group col-md-12 mb-5 d-none confirmEmail">
                        {{ Form::label('confirm_email', __('messages.withdraw.confirm_paypal_account_email').(':'), ['class' => 'form-label']) }}
                        <span class="required"></span>
                        {{ Form::email('confirm_email', null, ['id'=>'confirmEmail','class' => 'form-control' ,'placeholder' => __('messages.withdraw.confirm_paypal_account_email')]) }}
                    </div>
                </div>
            </div>
            <div class="modal-footer pt-0">
                {{ Form::button(__('messages.common.save'), ['type' => 'submit','class' => 'btn btn-primary m-0','id' => 'withdrawRequestAddBtn','data-loading-text' => "<span class='spinner-border spinner-border-sm'></span> Processing..."]) }}
                <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('messages.common.cancel') }}</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
