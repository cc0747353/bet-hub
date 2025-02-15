@if($row->roles[0]->name != 'admin')
    @if ($row->email_verified_at != null)
        @php
            $impersonateCss = 'style="width: fit-content"';
        @endphp
        <a data-turbo="false" title="Impersonate {{$row->full_name}}"
           class="btn btn-sm btn-primary me-5 {{$row->status ? '' : 'disabled'}} "
           href="{{route('impersonate', $row->id)}}" {!! $impersonateCss !!}>
            {{__('messages.common.impersonate')}}
        </a>
    @else
        @php
            $imperCss = 'style="pointer-events: none; cursor: default"';
        @endphp
        <a href="javascript:void(0)"
           class="btn btn-sm me-5 btn-secondary" {!! $imperCss !!}>
            {{__('messages.common.impersonate')}}
        </a>
    @endif
@endif
