@extends('layouts.admin')
@section('title', 'Properties')
@section('content')
@include('partials.flash-messages')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Properties</h4>
    <a href="{{ route('admin.properties.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i> Add Property</a>
</div>
@include('partials.filters')
<div class="card shadow-sm rounded">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Title</th>
                    <th>Project</th>
                    <th>Type</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($properties as $property)
                    <tr>
                        <td>{{ $property->title }}</td>
                        <td>{{ $property->project->name ?? '-' }}</td>
                        <td>{{ $property->type }}</td>
                        <td>${{ number_format($property->price, 2) }}</td>
                        <td>@include('partials.status-badge', ['status' => $property->status])</td>
                        <td>
                            <a href="{{ route('admin.properties.show', $property) }}" class="btn btn-sm btn-info"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('admin.properties.edit', $property) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.properties.destroy', $property) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Delete this property?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    @include('partials.empty-state')
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-white py-2">
        @include('partials.pagination', ['paginator' => $properties])
    </div>
</div>
@endsection
