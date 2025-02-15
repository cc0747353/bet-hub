<div id="adminWithdrawRequestModal" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel">{{ __('messages.withdraw.withdraw_request') }}</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>

            {{ Form::open(['id'=>'adminWithdrawRequestForm','files' => true,]) }}
            @method('POST')
            <input type="hidden" name="id" class="withdrawRequestId" value="">
            <input type="hidden" name="status" value="{{ \App\Models\WithdrawRequests::APPROVED }}">
            <div class="modal-body">
                <div class="alert alert-danger d-none hide" id="validationErrorsBox"></div>
                <div class="row">
                    <div>
                        {{ Form::label('attachment',__('messages.deposit.attachment').(':'), ['class' => 'form-label ']) }}
                        <input type="file" class="form-control custom-file-input mb-3" id="customFile" name="attachment" >
                    </div>
                    <div>
                        {{Form::label('notes',__('messages.deposit.notes').(':'),['class' => 'form-label required'])}}
                        {{ Form::textarea('notes', null,['class' => 'form-control  mb-3', 'id' => 'acceptNotes','placeholder' => __('messages.deposit.notes')])}}
                    </div>
                </div>
            </div>
            <div class="modal-footer pt-0">
                {{ Form::button(__('Approve'), ['type' => 'button','class' => 'btn btn-primary m-0','data-loading-text' => "<span class='spinner-border spinner-border-sm'></span> Processing...",'id' => 'approveWithdrawRequestBtn']) }}
                <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('messages.common.cancel') }}</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
