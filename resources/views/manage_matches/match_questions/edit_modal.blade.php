<div id="editQuestionModal" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel">{{ __('messages.question.edit_question') }}</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            {{ Form::open(['id'=>'editQuestionForm','files' => 'true']) }}
            @method('put')
            <div class="modal-body">
                {{ Form::hidden('question_id', null,['id' => 'questionId']) }}
                <div class="alert alert-danger d-none hide" id="validationErrorsBox"></div>
                <div class="row">
                    <div class="form-group col-md-12 mb-5">
                        {{ Form::label('question', __('messages.question.question').(':'), ['class' => 'form-label']) }}
                        <span class="required"></span>
                        {{ Form::text('question', null, ['id'=>'editQuestion','class' => 'form-control','required' ,'placeholder' => __('messages.question.question')]) }}
                    </div>
                    <div class="form-group col-md-6">
                        {{ Form::label('status', __('messages.question.status').(':'),['class' => 'form-label']) }}
                        <div class="form-check form-switch">
                            <input class="form-check-input h-20px w-30px" type="checkbox"
                                   id="editQuestionStatus" name="status" value="1">
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        {{ Form::label('is_locked', __('messages.question.is_locked').(':'),['class' => 'form-label']) }}
                        <div class="form-check form-switch">
                            <input class="form-check-input h-20px w-30px" type="checkbox"
                                   id="editLockedStatus" name="is_locked" value="1">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer pt-0">
                {{ Form::button(__('messages.common.save'), ['type' => 'submit','class' => 'btn btn-primary m-0','id' => 'editQuestionFormBtn','data-loading-text' => "<span class='spinner-border spinner-border-sm'></span> Processing..."]) }}
                <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('messages.common.cancel') }}</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
