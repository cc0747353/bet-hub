@php
    $disabledRejectBtn = isDisabledRejectBtn($row) ? 'disabled' : '';
@endphp

<a href="{{ route('admin.show.withdraw.request',$row->id) }}" data-bs-toggle="tooltip"
   title="{{ __('messages.common.view') }}"
   data-id="{{ $row->id }}"
   class="withdraw-request-show-btn btn px-1 text-primary fs-3 ps-0">
    <i class="bi bi-eye-fill"></i>
</a>

@if($row->status == \App\Models\WithdrawRequests::PENDING)
    <a class="withdraw-request-btn" title="{{ __('messages.withdraw.approve') }}"
       href="javascript:void(0)" data-bs-toggle="tooltip" data-id="{{$row->id}}"
       data-turbolinks="false"><i class="fa fa-check text-success fs-3"></i></a>

    <a class="withdraw-request-reject-btn ms-2" title="{{ __('messages.withdraw.reject') }}"
       href="javascript:void(0)" data-bs-toggle="tooltip" data-id="{{$row->id}}"
       data-turbolinks="false"><i class="fa fa-close text-danger fs-3"></i></a>
@endif
