<div id="editFaqModal" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel">{{ __('messages.faqs.edit_faqs') }}</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            {{ Form::open(['id'=>'editFaqForm','files' => 'true']) }}
            @method('put')
            <div class="modal-body">
                {{ Form::hidden('faq_id', null,['id' => 'faqId']) }}
                <div class="alert alert-danger d-none hide" id="validationErrorsBox"></div>
                <div class="row">
                    <div class="form-group col-md-12 mb-5">
                        {{ Form::label('question', __('messages.faqs.question').(':'), ['class' => 'form-label']) }}
                        <span class="required"></span>
                        {{ Form::text('question', null, ['id'=>'editFaqQuestion','class' => 'form-control','required' ,'placeholder' =>  __('messages.faqs.question')]) }}
                    </div>
                    <div class="form-group col-md-12 mb-5">
                        {{ Form::label('answer', __('messages.faqs.answer').(':'), ['class' => 'form-label']) }}
                        <span class="required"></span>
                        {{ Form::textarea('answer', null, ['id'=>'editFaqAnswer','class' => 'form-control','required' ,'placeholder' => __('messages.faqs.answer')]) }}
                    </div>
                    <div class="form-group col-md-12 mb-5">
                        {{ Form::label('status',__('messages.faqs.status').(':'),['class' => 'form-label']) }}
                        <div class="form-check form-switch">
                            <input class="form-check-input h-20px w-30px" type="checkbox"
                                   id="editFaqStatus" name="status" value="1">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer pt-0">
                {{ Form::button(__('messages.common.save'), ['type' => 'submit','class' => 'btn btn-primary m-0','id' => 'editFaqFormBtn','data-loading-text' => "<span class='spinner-border spinner-border-sm'></span> Processing..."]) }}
                <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('messages.common.cancel') }}</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
