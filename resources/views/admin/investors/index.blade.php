@extends('layouts.admin')
@section('title', 'Investors')
@section('content')
@include('partials.flash-messages')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Investors</h4>
    <a href="{{ route('admin.investors.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i> Add Investor</a>
</div>
@include('partials.filters')
<div class="card shadow-sm rounded">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>National ID</th>
                    <th>Address</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($investors as $investor)
                    <tr>
                        <td>{{ $investor->full_name }}</td>
                        <td>{{ $investor->email }}</td>
                        <td>{{ $investor->phone }}</td>
                        <td>{{ $investor->national_id }}</td>
                        <td>{{ $investor->address }}</td>
                        <td>
                            <a href="{{ route('admin.investors.show', $investor) }}" class="btn btn-sm btn-info"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('admin.investors.edit', $investor) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.investors.destroy', $investor) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Delete this investor?')">
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
        @include('partials.pagination', ['paginator' => $investors])
    </div>
</div>
@endsection
