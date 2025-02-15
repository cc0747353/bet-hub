<div class="d-flex">
    <a href="{{ route('blog.edit', $row->id) }}" title="{{ __('messages.common.edit') }}"
        class="btn px-2 text-primary fs-3 ps-0 action-btn" data-bs-toggle="tooltip">
        <i class="fa-solid fa-pen-to-square"></i>
    </a>

    <a href="javascript:void(0)" data-id="{{ $row->id }}" title="{{ __('messages.common.delete') }}"
       data-bs-toggle="tooltip"
       data-bs-original-title="{{ __('messages.common.delete') }}"
       class="btn px-1 text-danger fs-3 blog-delete-btn">
        <i class="fa-solid fa-trash"></i>
    </a>
</div>
