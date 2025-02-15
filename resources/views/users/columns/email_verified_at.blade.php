<div class="form-check form-switch form-check-custom form-check-solid justify-content-center">
    <input class="form-check-input h-20px w-30px user-email-verified "
           {{!empty($row->email_verified_at) ? 'disabled' : ''}} data-id="{{ $row->id}}" type="checkbox"
           value=""
            {{ !empty($row->email_verified_at) ? 'checked' : ''}}/>
</div>
