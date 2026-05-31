@extends('layouts.admin')
@section('title', 'Investor Details')
@section('content')
<div class="card shadow-sm rounded">
    <div class="card-header bg-white fw-bold">Investor Details</div>
    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-3">Full Name</dt>
            <dd class="col-sm-9">{{ $investor->full_name }}</dd>
            <dt class="col-sm-3">Email</dt>
            <dd class="col-sm-9">{{ $investor->email }}</dd>
            <dt class="col-sm-3">Phone</dt>
            <dd class="col-sm-9">{{ $investor->phone }}</dd>
            <dt class="col-sm-3">National ID</dt>
            <dd class="col-sm-9">{{ $investor->national_id }}</dd>
            <dt class="col-sm-3">Address</dt>
            <dd class="col-sm-9">{{ $investor->address }}</dd>
        </dl>
        <a href="{{ route('admin.investors.edit', $investor) }}" class="btn btn-warning mt-3">Edit</a>
        <a href="{{ route('admin.investors.index') }}" class="btn btn-secondary mt-3">Back</a>
    </div>
</div>
@endsection
