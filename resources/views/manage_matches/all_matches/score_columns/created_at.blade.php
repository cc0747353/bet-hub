<div class="d-flex justify-content-center">
    <span class="badge bg-primary">{{ Carbon\Carbon::parse($row->created_at)->format('d M, h:m A') }}</span>
</div>
