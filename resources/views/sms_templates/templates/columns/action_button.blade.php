<a href="{{ route('sms-template.edit', $row->id) }}" title="{{ __('messages.common.edit') }}"
   class="btn px-1 text-primary fs-3 template-edit-btn" data-bs-toggle="tooltip"
   data-bs-original-title="{{ __('messages.common.edit') }}" data-id="{{$row->id}}">
    <i class="fa-solid fa-pen-to-square"></i>
</a>
