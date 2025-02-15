<div id="sendTestMessageModel" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel">{{ __('Test SMS') }}</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="nexmoSmsTest d-none">
                {{ Form::open(['route' => 'sms.gateways.sendSMS', 'method' => 'post', 'id' => 'sendTestMessageForm',]) }}
                <div class="modal-body">
                    <div class="alert alert-danger d-none hide" id="validationErrorsBox"></div>
                    <div class="row">
                        <div class="form-group col-md-12 mb-5">
                            {{ Form::label('mobile_number', __('messages.sms_gateways.send_to').(':'), ['class' => 'form-label']) }}
                            <span class="required"></span>
                            {{ Form::tel('mobile_number', null, ['class' => 'form-control w-100', 'placeholder' => __('messages.user.contact_no'), 'onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")','id'=>'phoneNumber']) }}
                            {{ Form::hidden('region_code', null,['id'=>'prefix_code']) }}
                            <span id="valid-msg"
                                  class="text-success d-none fw-400 fs-small mt-2">{{ __('messages.valid_number') }}</span>
                            <span id="error-msg"
                                  class="text-danger d-none fw-400 fs-small mt-2">{{ __('messages.invalid_number') }}</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer pt-0">
                    {{ Form::button(__('messages.common.save'), ['type' => 'submit','class' => 'btn btn-primary m-0','id' => 'sendMessageBtn','data-loading-text' => "<span class='spinner-border spinner-border-sm'></span> Processing..."]) }}
                    <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">{{ __('messages.common.cancel') }}</button>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
