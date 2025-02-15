@if($row->attachment)
<a href="{{ $row->attachment }}" download="">{{ basename($row->attachment) }}</a>
@else
    NA
@endif
