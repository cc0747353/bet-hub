<a title="{{ __('messages.common.edit') }}"
   class="btn px-1 text-primary fs-3 edit-language-btn" data-id="{{$row->id}}">
    <i class="fa-solid fa-pen-to-square"></i>
</a>
<a href="javascript:void(0)" data-id="{{ $row->id }}" title="{{ __('messages.common.delete') }}"
   class="btn px-1 text-danger fs-3 language-delete-btn">
    <i class="fa-solid fa-trash"></i>
</a>
