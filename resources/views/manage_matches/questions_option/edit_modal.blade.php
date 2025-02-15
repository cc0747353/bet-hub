<div id="editOptionModal" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel">{{ __('messages.question.edit_option') }}</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            {{ Form::open(['id'=>'editOptionForm','files' => 'true']) }}
            @method('put')
            <div class="modal-body">
                {{ Form::hidden('option_id', null,['id' => 'optionId']) }}
                <div class="alert alert-danger d-none hide" id="validationErrorsBox"></div>
                <div class="row">
                    <div class="form-group col-md-12 mb-5">
                        {{ Form::label('name', __('messages.question.name').(':'), ['class' => 'form-label']) }}
                        <span class="required"></span>
                        {{ Form::text('name', null, ['id'=>'editOptionName','class' => 'form-control','required' ,'placeholder' => __('messages.question.name')]) }}
                    </div>
                    <div class="form-group mb-5">
                        <label class="form-label font-weight-bold">Ratio <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="number" step="0.01" class="form-control" name="dividend" min="1"
                                   id="editOptionDividend" required="">
                            <span class="input-group-text font-weight-bold rounded-0">:</span>
                            <input type="number" step="0.01" class="form-control" name="divisor" min="1"
                                   id="editOptionDivisor" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('status', __('messages.question.status').(':'),['class' => 'form-label']) }}
                        <div class="form-check form-switch">
                            <input class="form-check-input h-20px w-30px" type="checkbox"
                                   id="editOptionStatus" name="status" value="1">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer pt-0">
                {{ Form::button(__('messages.common.save'), ['type' => 'submit','class' => 'btn btn-primary m-0','id' => 'editOptionFormBtn','data-loading-text' => "<span class='spinner-border spinner-border-sm'></span> Processing..."]) }}
                <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('messages.common.cancel') }}</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
