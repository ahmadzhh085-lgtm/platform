@extends('layouts.admin')
@section('title', 'Project Details')
@section('content')
<div class="card shadow-sm rounded">
    <div class="card-header bg-white fw-bold">Project Details</div>
    <div class="card-body">
        @if($project->image)
            <div class="mb-4 text-center">
                <img src="{{ $project->image }}" alt="{{ $project->name }}" class="img-fluid rounded shadow-sm" style="max-height: 260px;">
            </div>
        @endif
        <dl class="row mb-0">
            <dt class="col-sm-3">Name</dt>
            <dd class="col-sm-9">{{ $project->name }}</dd>
            <dt class="col-sm-3">Description</dt>
            <dd class="col-sm-9">{{ $project->description }}</dd>
            <dt class="col-sm-3">Location</dt>
            <dd class="col-sm-9">{{ $project->location }}</dd>
            <dt class="col-sm-3">Status</dt>
            <dd class="col-sm-9">@include('partials.status-badge', ['status' => $project->status])</dd>
            <dt class="col-sm-3">Total Budget</dt>
            <dd class="col-sm-9">${{ number_format($project->total_budget, 2) }}</dd>
        </dl>
        <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-warning mt-3">Edit</a>
        <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary mt-3">Back</a>
    </div>
</div>
@endsection
