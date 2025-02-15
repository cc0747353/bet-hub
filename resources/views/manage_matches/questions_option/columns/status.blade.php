<div class="form-check form-switch form-check-custom form-check-solid justify-content-center">
    <input class="form-check-input h-20px w-30px option-change-status" data-id="{{ $row->id }}" type="checkbox"
            {{ $row->status == \App\Models\Option::ACTIVE ? 'checked' : ''}} {{ \App\Models\Question::whereId($row->question_id)->value('result_declared') == true ? 'disabled' : '' }}>
</div>
