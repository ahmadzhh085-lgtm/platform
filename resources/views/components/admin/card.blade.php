@props(['title', 'icon', 'value', 'color' => 'primary'])
<div class="card shadow-sm rounded border-0">
    <div class="card-body d-flex align-items-center">
        <div class="me-3">
            <span class="bg-{{ $color }} bg-opacity-10 text-{{ $color }} p-3 rounded-circle">
                <i class="bi {{ $icon }} fs-4"></i>
            </span>
        </div>
        <div>
            <div class="fw-bold fs-5">{{ $value }}</div>
            <div class="text-muted small">{{ $title }}</div>
        </div>
    </div>
</div>