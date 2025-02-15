<div id="addSocialIconModal" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel">{{ __('messages.social_icon.add_social_icon') }}</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            {{ Form::open(['id'=>'addSocialIconForm','files' => 'true']) }}
            <div class="modal-body">
                <div class="alert alert-danger d-none hide" id="validationErrorsBox"></div>
                <div class="row">
                    <div class="form-group col-md-12 mb-5">
                        {{ Form::label('title', __('messages.social_icon.title').(':'), ['class' => 'form-label']) }}
                        <span class="required"></span>
                        {{ Form::text('title', null, ['id'=>'title','class' => 'form-control','required' ,'placeholder' => __('messages.social_icon.title')]) }}
                    </div>
                    <div class="form-group col-md-12 mb-5">
                        {{ Form::label('url', __('messages.social_icon.url').(':'), ['class' => 'form-label']) }}
                        <span class="required"></span>
                        {{ Form::url('url', null, ['id'=>'url','class' => 'form-control','required' ,'placeholder' => __('URL')]) }}
                    </div>
                    <div class="form-group col-md-12 mb-5">
                        {{ Form::label('icon', __('messages.social_icon.icon').(':'), ['class' => 'form-label required']) }}
                        <div class="input-group">
                            {{ Form::text('icon', null, ['id'=>'socialIconPicker','class' => 'form-control icon h-auto' ,'placeholder' => __('messages.social_icon.select_icon'),'required']) }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer pt-0">
                {{ Form::button(__('messages.common.save'), ['type' => 'submit','class' => 'btn btn-primary m-0','id' => 'socialIconAddBtn','data-loading-text' => "<span class='spinner-border spinner-border-sm'></span> Processing..."]) }}
                <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('messages.common.cancel') }}</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
