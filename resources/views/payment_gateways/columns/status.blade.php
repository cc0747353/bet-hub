<div class="form-check form-switch form-check-custom form-check-solid justify-content-center">
    <input class="form-check-input h-20px w-30px paymentGateway-change-status" data-id="{{ $row->id }}" type="checkbox"
           id="flexSwitch20x30"
            {{ $row->status == \App\Models\PaymentGateway::ACTIVE ? 'checked' : ''}}>
</div>


