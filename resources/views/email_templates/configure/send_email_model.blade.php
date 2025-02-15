<div id="sendTestEmailModel" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel">{{ __('Test Email') }}</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="emailTest">
                {{ Form::open(['route' => 'email.configure.sendEmail', 'method' => 'post', 'id' => 'sendTestEmailForm',]) }}
                <div class="modal-body">
                    <div class="alert alert-danger d-none hide" id="validationErrorsBox"></div>
                    <div class="row">
                        <div class="form-group col-md-12 mb-5">
                            {{ Form::label('email', __('messages.user.email').(':'), ['class' => 'form-label']) }}
                            <span class="required"></span>
                            {{ Form::email('email', null, ['id'=>'testSmsEmail','class' => 'form-control w-100', 'disable','placeholder' => __('messages.user.email')]) }}
                        </div>
                        <div class="form-group col-md-12 mb-5">
                            {{ Form::label('message', __('messages.email_template.message').(':'), ['class' => 'form-label']) }}
                            <span class="required"></span>
                            {{ Form::text('message', null, ['id'=>'testSmsMessage','class' => 'form-control w-100', 'disable','placeholder' => __('messages.email_template.message')]) }}
                        </div>
                    </div>
                </div>
                <div class="modal-footer pt-0">
                    {{ Form::button(__('messages.common.save'), ['type' => 'submit','class' => 'btn btn-primary m-0','id' => 'sendEmailBtn','data-loading-text' => "<span class='spinner-border spinner-border-sm'></span> Processing..."]) }}
                    <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">{{ __('messages.common.cancel') }}</button>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
