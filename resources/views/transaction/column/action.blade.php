<div class="d-flex">
    @if($row->status == 2)
        <div class="form-check form-switch form-check-custom form-check-solid d-flex pt-4">
            <input class="form-check-input h-20px w-30px transaction-statusbar" data-id="{{$row->id}}" type="checkbox"
                   data-bs-toggle="tooltip" title="{{ __('messages.deposit.approve_deposit') }}"
                   value="" {{$row->status === 1?'checked':''}} />
        </div>
    @endif
    <div class="pt-0">
        <a href="{{ route('admin.deposit.details',$row->id) }}"
           class="btn px-1 text-primary fs-3" title="{{ __('messages.common.view') }}" data-bs-toggle="tooltip"
           data-bs-original-title="{{ __('messages.common.view') }}">
            <i class="fas fa-eye"></i>
        </a>
    </div>
</div>
