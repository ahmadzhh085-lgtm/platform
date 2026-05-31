@extends('layouts.admin')
@section('title', 'Add Project')
@section('content')
<div class="card shadow-sm rounded">
    <div class="card-header bg-white fw-bold">Add Project</div>
    <div class="card-body">
        @include('partials.form-errors')
        <form action="{{ route('admin.projects.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control">{{ old('description') }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Location</label>
                <input type="text" name="location" class="form-control" value="{{ old('location') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="active" @selected(old('status')=='active')>Active</option>
                    <option value="pending" @selected(old('status')=='pending')>Pending</option>
                    <option value="completed" @selected(old('status')=='completed')>Completed</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Total Budget</label>
                <input type="number" name="total_budget" class="form-control" value="{{ old('total_budget', 0) }}" min="0" step="0.01" required>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
