<div id="editPartnerModal" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel">{{ __('messages.partner.edit_partner_section') }}</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            {{ Form::open(['id'=>'editPartnerForm','files' => 'true']) }}
            @method('put')
            <div class="modal-body">
                {{ Form::hidden('partner_id', null,['id' => 'partnerId']) }}
                <div class="alert alert-danger d-none hide" id="validationErrorsBox"></div>
                <div class="row">
                    <div class="form-group col-md-12 mb-5">
                        {{ Form::label('name', __('messages.partner.name').(':'), ['class' => 'form-label']) }}
                        <span class="required"></span>
                        {{ Form::text('name', null, ['id'=>'editPartnerName','class' => 'form-control','required','placeholder' => __('messages.partner.name')]) }}
                    </div>
                    <div class="mb-5 form-group col-md-12" io-image-input="true">
                        <label for="exampleInputImage" class="form-label">{{ __('messages.partner.image') }}</label>
                        <div class="d-block">
                            <div class="image-picker">
                                <div class="image previewImage" id="editPartnerImagePreview"></div>
                                <span class="picker-edit rounded-circle text-gray-500 fs-small"
                                      data-bs-toggle="tooltip"
                                      data-placement="top"
                                      data-bs-original-title="{{ __('messages.partner.image') }}">
                                    <label>
                                    <i class="fa-solid fa-pen" id="profileImageIcon"></i>
                                        <input type="file" id="image" name="image"
                                               class="image-upload d-none" accept="image/*"/>
                                    </label>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer pt-0">
                {{ Form::button(__('messages.common.save'), ['type' => 'submit','class' => 'btn btn-primary m-0','id' => 'editPartnerFormBtn','data-loading-text' => "<span class='spinner-border spinner-border-sm'></span> Processing..."]) }}
                <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('messages.common.cancel') }}</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
