@extends('layouts.admin')

@section('title', 'Users')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h3 mb-1">User Management</h1>
            <p class="text-muted mb-0">View users and change their roles between Admin, Employee and standard User.</p>
        </div>
        <a href="{{ route('admin.employees.create') }}" class="btn btn-primary">
            <i class="bi bi-plus"></i> Add User
        </a>
    </div>
    @include('partials.flash-messages')
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Permissions</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($employees as $employee)
                        <tr>
                            <td>{{ $employee->id }}</td>
                            <td>{{ $employee->name }}</td>
                            <td>{{ $employee->email }}</td>
                            <td>
                                @forelse($employee->roles as $role)
                                    <span class="badge bg-primary-subtle text-primary">{{ $role->name }}</span>
                                @empty
                                    <span class="badge bg-secondary-subtle text-secondary">User</span>
                                @endforelse
                            </td>
                            <td>{{ $employee->getAllPermissions()->pluck('name')->join(', ') ?: 'No custom permissions' }}</td>
                            <td>@include('partials.status-badge', ['status' => $employee->status])</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.employees.show', $employee) }}" class="btn btn-sm btn-info"><i class="bi bi-eye"></i></a>
                                    <a href="{{ route('admin.employees.edit', $employee) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                                    <form action="{{ route('admin.employees.destroy', $employee) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">No users found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="mt-3">
        {{ $employees->links('partials.pagination') }}
    </div>
</div>
@endsection
