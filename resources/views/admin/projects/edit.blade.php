@extends('layouts.admin')
@section('title', 'Edit Project')
@section('content')
<div class="card shadow-sm rounded">
    <div class="card-header bg-white fw-bold">Edit Project</div>
    <div class="card-body">
        @include('partials.form-errors')
        <form action="{{ route('admin.projects.update', $project) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $project->name) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control">{{ old('description', $project->description) }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Location</label>
                <input type="text" name="location" class="form-control" value="{{ old('location', $project->location) }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="active" @selected(old('status', $project->status)=='active')>Active</option>
                    <option value="pending" @selected(old('status', $project->status)=='pending')>Pending</option>
                    <option value="completed" @selected(old('status', $project->status)=='completed')>Completed</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Total Budget</label>
                <input type="number" name="total_budget" class="form-control" value="{{ old('total_budget', $project->total_budget) }}" min="0" step="0.01" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
