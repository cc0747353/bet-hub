<a href="javascript:void(0)" title="{{ __('messages.common.edit') }}"
   class="btn px-1 text-primary fs-3 question-edit-btn" data-bs-toggle="tooltip"
   data-bs-original-title="{{ __('messages.common.edit') }}" data-id="{{$row->id}}">
    <i class="fa-solid fa-pen-to-square"></i>
</a>
<a href="javascript:void(0)" data-id="{{ $row->id }}" title="{{ __('messages.common.delete') }}"
   data-bs-toggle="tooltip"
   data-bs-original-title="{{ __('messages.common.delete') }}"
   class="btn px-1 text-danger fs-3 question-delete-btn">
    <i class="fa-solid fa-trash"></i>
</a>
<a href="{{ route('questions.options', $row->id) }}" data-id="{{ $row->id }}"
   title="{{ $row->options_count.' '.__('messages.common.option') }}"
   data-bs-toggle="tooltip"
   data-bs-original-title="{{ __('messages.common.option') }}"
   class="btn px-1 text-info fs-3 question-option-btn">
    <i class="fa-solid fa-list"></i>
</a>
