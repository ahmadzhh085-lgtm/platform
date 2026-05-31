@extends('layouts.admin')
@section('title', 'Property Details')
@section('content')
<div class="card shadow-sm rounded">
    <div class="card-header bg-white fw-bold">Property Details</div>
    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-3">Title</dt>
            <dd class="col-sm-9">{{ $property->title }}</dd>
            <dt class="col-sm-3">Project</dt>
            <dd class="col-sm-9">{{ $property->project->name ?? '-' }}</dd>
            <dt class="col-sm-3">Type</dt>
            <dd class="col-sm-9">{{ $property->type }}</dd>
            <dt class="col-sm-3">Price</dt>
            <dd class="col-sm-9">₦{{ number_format($property->price, 2) }}</dd>
            <dt class="col-sm-3">Location</dt>
            <dd class="col-sm-9">{{ $property->location }}</dd>
            <dt class="col-sm-3">Area</dt>
            <dd class="col-sm-9">{{ $property->area }}</dd>
            <dt class="col-sm-3">Status</dt>
            <dd class="col-sm-9">@include('partials.status-badge', ['status' => $property->status])</dd>
            <dt class="col-sm-3">Image</dt>
            <dd class="col-sm-9">
                @if($property->image)
                    <img src="{{ asset('storage/'.$property->image) }}" alt="Image" class="img-thumbnail" width="120">
                @else
                    -
                @endif
            </dd>
        </dl>
        <a href="{{ route('admin.properties.edit', $property) }}" class="btn btn-warning mt-3">Edit</a>
        <a href="{{ route('admin.properties.index') }}" class="btn btn-secondary mt-3">Back</a>
    </div>
</div>
@endsection
