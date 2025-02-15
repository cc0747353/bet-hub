<div class="form-check form-switch form-check-custom form-check-solid justify-content-center">
    <input class="form-check-input h-20px w-30px user-status" data-id="{{ $row->id}}" type="checkbox"
           value=""
            {{ !empty($row->status) ? 'checked' : ''}}/>
</div>

