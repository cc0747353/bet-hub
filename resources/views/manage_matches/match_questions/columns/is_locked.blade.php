<div class="form-check form-switch form-check-custom form-check-solid justify-content-center">
    <input class="form-check-input h-20px w-30px question-locked-change-status" data-id="{{ $row->id }}" type="checkbox"
           id="flexSwitch20x30"
            {{ $row->is_locked == \App\Models\Question::ACTIVE ? 'checked' : ''}} {{ \App\Models\AllMatch::whereId($row->match_id)->value('is_locked') == true ? 'disabled' : '' }}>
</div>
