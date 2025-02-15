<div id="addLeagueModal" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel">{{ __('messages.league.add_league') }}</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            {{ Form::open(['id'=>'addLeagueForm','files' => 'true']) }}
            <div class="modal-body">
                <div class="alert alert-danger d-none hide" id="validationErrorsBox"></div>
                <div class="row">
                    <div class="form-group col-md-12 mb-5">
                        {{ Form::label('category_id', __('messages.league.category').(':'), ['class' => 'form-label']) }}
                        <span class="required"></span>
                        {{ Form::select('category_id', $category, '', [
                           'class' => 'form-select', 'aria-label'=>"Select a Category", 'id' => 'categoryDropdown', 'placeholder' => __('messages.category.select_category') ]) }}
                    </div>
                    <div class="form-group col-md-12 mb-5">
                        {{ Form::label('name', __('messages.league.name').(':'), ['class' => 'form-label']) }}
                        <span class="required"></span>
                        {{ Form::text('name', null, ['id'=>'leagueName','class' => 'form-control','required' ,'placeholder' => __('messages.league.name')]) }}
                    </div>
                    <div class="form-group col-md-12 mb-5">
                        {{ Form::label('icon', __('messages.league.select_icon').(':'), ['class' => 'form-label required']) }}
                        <div class="input-group">
                            {{ Form::text('icon', null, ['id'=>'leagueIconPicker','class' => 'form-control icon h-auto', 'required', 'placeholder' => __('messages.category.select_icon'),'autocomplete'=>'off']) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('status', __('messages.league.status').(':'),['class' => 'form-label']) }}
                        <div class="form-check form-switch">
                            <input class="form-check-input h-20px w-30px" type="checkbox"
                                   id="leagueStatus" name="status">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer pt-0">
                {{ Form::button(__('messages.common.save'), ['type' => 'submit','class' => 'btn btn-primary m-0','id' => 'leagueAddBtn','data-loading-text' => "<span class='spinner-border spinner-border-sm'></span> Processing..."]) }}
                <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('messages.common.cancel') }}</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
