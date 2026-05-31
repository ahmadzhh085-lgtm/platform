@props(['status'])
@php
    $map = [
        'active' => 'success',
        'pending' => 'warning',
        'completed' => 'primary',
        'cancelled' => 'danger',
        'failed' => 'danger',
        'draft' => 'secondary',
    ];
    $color = $map[$status] ?? 'secondary';
@endphp
<span class="badge bg-{{ $color }}">{{ ucfirst($status) }}</span>