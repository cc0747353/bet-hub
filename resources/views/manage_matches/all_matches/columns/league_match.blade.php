<h6 class="">{{ $row->league->name }}</h6>
<div class="d-flex flex-column me-3">
    <a href="{{ route('all-matches.show', $row->id) }}" class="mb-1 text-decoration-none fs-6">
        {{ $row->match_title }}
    </a>
</div>
