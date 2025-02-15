<div class="modal show fade" id="createCurrencyModal" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3>{{__('messages.currency.add_currency')}}</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <form id="createCurrencyForm">
                <div class="modal-body">
                    @csrf
                    @method('POST')
                    <div class="alert alert-danger d-none" id="createCurrencyValidationErrorsBox"></div>
                    <div class="mb-5">
                        {{ Form::label('currency_name', __('messages.common.name').':', 
                            ['class' => 'required form-label']) }}
                        {{ Form::text('currency_name', null, ['class' => 'form-control', 'placeholder' => __('messages.currency.currency_name'),'required']) }}
                    </div>
                    <div class="mb-5">
                        {{ Form::label('currency_icon', __('messages.currency.currency_icon').':', ['class' => 'required form-label']) }}
                        {{ Form::text('currency_icon', null, ['class' => 'form-control', 'placeholder' =>                                        __('messages.currency.currency_icon'),'required']) }}
                    </div>
                    <div class="mb-5">
                        {{ Form::label('currency_code', __('messages.currency.currency_code').':', ['class' => 'required form-label']) }}
                        {{ Form::text('currency_code', null, ['class' => 'form-control', 'placeholder' =>                                       __('messages.currency.currency_code'),'required', 'max' => 3 ,'id' =>'currencyCode' ] ) }}
                    </div>
                </div>
                <div class="modal-footer pt-0">
                    {{ Form::submit(__('messages.common.save'),['class' => 'btn btn-primary me-2']) }}
                    {{ Form::button(__('messages.common.discard'),['class' => 'btn btn-secondary'
                            ,'data-bs-dismiss'=>'modal']) }}
                </div>
            </form>
        </div>
    </div>
</div>
