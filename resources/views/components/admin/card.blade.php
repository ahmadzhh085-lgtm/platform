@props(['title', 'icon', 'value', 'color' => 'primary'])
<div class="card border-0 shadow-sm rounded-4 h-100">
    <div class="card-body d-flex align-items-center">
        <div class="me-3">
            <span class="bg-{{ $color }} bg-opacity-10 text-{{ $color }} p-3 rounded-circle d-inline-flex">
                <i class="bi {{ $icon }} fs-4"></i>
            </span>
        </div>
        <div>
            <div class="fw-bold fs-4">{{ $value }}</div>
            <div class="text-muted small">{{ $title }}</div>
        </div>
    </div>
</div>