@extends('layouts.admin')
@section('title', 'Edit Property')
@section('content')
<div class="card shadow-sm rounded">
    <div class="card-header bg-white fw-bold">Edit Property</div>
    <div class="card-body">
        @include('partials.form-errors')
        <form action="{{ route('admin.properties.update', $property) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label">Project</label>
                <select name="project_id" class="form-select" required>
                    <option value="">Select Project</option>
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}" @selected(old('project_id', $property->project_id)==$project->id)>{{ $project->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $property->title) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Type</label>
                <input type="text" name="type" class="form-control" value="{{ old('type', $property->type) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Price</label>
                <input type="number" name="price" class="form-control" value="{{ old('price', $property->price) }}" min="0" step="0.01" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Location</label>
                <input type="text" name="location" class="form-control" value="{{ old('location', $property->location) }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Area</label>
                <input type="text" name="area" class="form-control" value="{{ old('area', $property->area) }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="available" @selected(old('status', $property->status)=='available')>Available</option>
                    <option value="sold" @selected(old('status', $property->status)=='sold')>Sold</option>
                    <option value="pending" @selected(old('status', $property->status)=='pending')>Pending</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Image</label>
                <input type="file" name="image" class="form-control">
                @if($property->image)
                    <img src="{{ asset('storage/'.$property->image) }}" alt="Image" class="img-thumbnail mt-2" width="120">
                @endif
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.properties.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
