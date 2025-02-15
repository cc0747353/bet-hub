<div id="editSocialIconModal" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel">{{ __('messages.social_icon.edit_social_icon') }}</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            {{ Form::open(['id'=>'editSocialIconForm','files' => 'true']) }}
            @method('put')
            <div class="modal-body">
                {{ Form::hidden('icon_id', null,['id' => 'socialIconId']) }}
                <div class="alert alert-danger d-none hide" id="validationErrorsBox"></div>
                <div class="row">
                    <div class="form-group col-md-12 mb-5">
                        {{ Form::label('title', __('messages.social_icon.title').(':'), ['class' => 'form-label']) }}
                        <span class="required"></span>
                        {{ Form::text('title', null, ['id'=>'editTitle','class' => 'form-control','required' ,'placeholder' => __('messages.social_icon.title')]) }}
                    </div>
                    <div class="form-group col-md-12 mb-5">
                        {{ Form::label('url', __('URL').(':'), ['class' => 'form-label']) }}
                        <span class="required"></span>
                        {{ Form::text('url', null, ['id'=>'editUrl','class' => 'form-control','required' ,'placeholder' => __('URL')]) }}
                    </div>
                    <div class="form-group col-md-12 mb-5">
                        {{ Form::label('icon', __('messages.social_icon.icon').(':'), ['class' => 'form-label required']) }}
                        <div class="input-group">
                            <input type="text" class="form-control icon" name="icon" id="editSocialIconPicker" required placeholder={{ __('messages.social_icon.select_icon') }}>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer pt-0">
                {{ Form::button(__('messages.common.save'), ['type' => 'submit','class' => 'btn btn-primary m-0','id' => 'editSocialIconFormBtn','data-loading-text' => "<span class='spinner-border spinner-border-sm'></span> Processing..."]) }}
                <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('messages.common.cancel') }}</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
