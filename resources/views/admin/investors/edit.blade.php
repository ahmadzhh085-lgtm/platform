@extends('layouts.admin')
@section('title', 'Edit Investor')
@section('content')
<div class="card shadow-sm rounded">
    <div class="card-header bg-white fw-bold">Edit Investor</div>
    <div class="card-body">
        @include('partials.form-errors')
        <form action="{{ route('admin.investors.update', $investor) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input type="text" name="full_name" class="form-control" value="{{ old('full_name', $investor->full_name) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $investor->email) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone', $investor->phone) }}">
            </div>
            <div class="mb-3">
                <label class="form-label">National ID</label>
                <input type="text" name="national_id" class="form-control" value="{{ old('national_id', $investor->national_id) }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Address</label>
                <input type="text" name="address" class="form-control" value="{{ old('address', $investor->address) }}">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.investors.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
