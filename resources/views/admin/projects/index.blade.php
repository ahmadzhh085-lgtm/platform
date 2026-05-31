@extends('layouts.admin')
@section('title', 'Projects')
@section('content')
@include('partials.flash-messages')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Projects</h4>
    <a href="{{ route('admin.projects.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i> Add Project</a>
</div>
@include('partials.filters')
<div class="card shadow-sm rounded">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Name</th>
                    <th>Location</th>
                    <th>Status</th>
                    <th>Total Budget</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($projects as $project)
                    <tr>
                        <td>{{ $project->name }}</td>
                        <td>{{ $project->location }}</td>
                        <td>@include('partials.status-badge', ['status' => $project->status])</td>
                        <td>₦{{ number_format($project->total_budget, 2) }}</td>
                        <td>
                            <a href="{{ route('admin.projects.show', $project) }}" class="btn btn-sm btn-info"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Delete this project?')">
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
        @include('partials.pagination', ['paginator' => $projects])
    </div>
</div>
@endsection
