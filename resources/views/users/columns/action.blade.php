<a href="{{route('users.edit',$row->id)}}" title="{{ __('messages.common.edit') }}"
   class="btn px-1 text-primary fs-3 user-edit-btn" data-id="{{$row->id}}" data-bs-toggle="tooltip"
   data-bs-original-title="{{ __('messages.common.edit') }}">
    <i class="fa-solid fa-pen-to-square"></i>
</a>
<a href="javascript:void(0)" data-id="{{ $row->id }}" title="{{ __('messages.common.delete') }}"
   class="btn px-1 text-danger fs-3 user-delete-btn" data-bs-toggle="tooltip"
   data-bs-original-title="{{ __('messages.common.delete') }}">
    <i class="fa-solid fa-trash"></i>
</a>
