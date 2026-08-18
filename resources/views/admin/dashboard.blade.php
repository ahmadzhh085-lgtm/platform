@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">Admin Dashboard</h2>
        <p class="text-muted mb-0">Overview of users, projects, investments, and requests.</p>
    </div>
    <a href="{{ route('admin.projects.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-2"></i>New Project
    </a>
</div>

<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-muted">Total Investments</span>
                    <span class="badge bg-primary-subtle text-primary"><i class="bi bi-cash-stack"></i></span>
                </div>
                <h3 class="fw-bold mb-0">${{ number_format((float) ($totalInvestments ?? 0), 2, '.', '') }}</h3>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-muted">Total Investors</span>
                    <span class="badge bg-success-subtle text-success"><i class="bi bi-people"></i></span>
                </div>
                <h3 class="fw-bold mb-0">{{ $totalInvestors ?? 0 }}</h3>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-muted">Active Projects</span>
                    <span class="badge bg-info-subtle text-info"><i class="bi bi-building"></i></span>
                </div>
                <h3 class="fw-bold mb-0">{{ $activeProjects ?? 0 }}</h3>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-muted">Pending Requests</span>
                    <span class="badge bg-warning-subtle text-warning"><i class="bi bi-bag-check"></i></span>
                </div>
                <h3 class="fw-bold mb-0">{{ ($pendingPurchaseRequests ?? 0) + ($pendingPropertySaleRequests ?? 0) }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white border-0 fw-bold">Analytics Summary</div>
            <div class="card-body">
                <div class="row text-center g-3">
                    <div class="col-6">
                        <div class="bg-light rounded-4 p-3">
                            <div class="text-muted small">Total Users</div>
                            <div class="fw-bold fs-4">{{ $totalUsers ?? 0 }}</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="bg-light rounded-4 p-3">
                            <div class="text-muted small">Active Users</div>
                            <div class="fw-bold fs-4">{{ $activeUsers ?? 0 }}</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="bg-light rounded-4 p-3">
                            <div class="text-muted small">Admins</div>
                            <div class="fw-bold fs-4">{{ $adminUsers ?? 0 }}</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="bg-light rounded-4 p-3">
                            <div class="text-muted small">Users with Roles</div>
                            <div class="fw-bold fs-4">{{ $recentUsers->count() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white border-0 fw-bold d-flex justify-content-between align-items-center">
                <span>Recent Users</span>
                <a href="{{ route('admin.employees.index') }}" class="btn btn-sm btn-outline-primary">Manage</a>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @forelse($recentUsers as $user)
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fw-semibold">{{ $user->name }}</div>
                                <small class="text-muted">{{ $user->email }}</small>
                            </div>
                            <span class="badge bg-light text-dark">{{ $user->roles->pluck('name')->first() ?? 'User' }}</span>
                        </div>
                    @empty
                        <div class="list-group-item text-muted text-center py-4">No users yet.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-white border-0 fw-bold d-flex justify-content-between align-items-center">
                <span>Latest Purchase Requests</span>
                <a href="{{ route('admin.purchase-requests.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Buyer</th>
                                <th>Project</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($purchaseRequests as $purchaseRequest)
                                <tr>
                                    <td>{{ $purchaseRequest->buyer_name }}</td>
                                    <td>{{ $purchaseRequest->project?->name ?? '-' }}</td>
                                    <td>${{ number_format((float) $purchaseRequest->offer_amount, 2, '.', '') }}</td>
                                    <td>
                                        @if($purchaseRequest->status === 'pending')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @elseif($purchaseRequest->status === 'approved')
                                            <span class="badge bg-success">Approved</span>
                                        @else
                                            <span class="badge bg-danger">Rejected</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            @if($purchaseRequest->status === 'pending')
                                                <form action="{{ route('admin.purchase-requests.approve', $purchaseRequest) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success" title="Approve">
                                                        <i class="bi bi-check-lg"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.purchase-requests.reject', $purchaseRequest) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Reject">
                                                        <i class="bi bi-x-lg"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            <a href="{{ route('admin.purchase-requests.show', $purchaseRequest) }}" class="btn btn-sm btn-info" title="View">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">No purchase requests yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-white border-0 fw-bold d-flex justify-content-between align-items-center">
                <span>Latest Property Sale Requests</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Seller</th>
                                <th>Property</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($propertySaleRequests as $propertySaleRequest)
                                <tr>
                                    <td>{{ $propertySaleRequest->seller_name }}</td>
                                    <td>{{ $propertySaleRequest->title }}</td>
                                    <td>${{ number_format((float) $propertySaleRequest->price, 2, '.', '') }}</td>
                                    <td>
                                        @if($propertySaleRequest->status === 'pending')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @elseif($propertySaleRequest->status === 'approved')
                                            <span class="badge bg-success">Approved</span>
                                        @else
                                            <span class="badge bg-danger">Rejected</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.property-sale-requests.show', $propertySaleRequest) }}" class="btn btn-sm btn-info" title="View Details">
                                            <i class="bi bi-eye"></i> Details
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">No property sale requests yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-white border-0 fw-bold">Quick Actions</div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.projects.index') }}" class="btn btn-outline-primary"><i class="bi bi-building me-2"></i>Projects</a>
                    <a href="{{ route('admin.investors.index') }}" class="btn btn-outline-success"><i class="bi bi-people me-2"></i>Investors</a>
                    <a href="{{ route('admin.payments.index') }}" class="btn btn-outline-info"><i class="bi bi-credit-card me-2"></i>Payments</a>
                    <a href="{{ route('admin.reports.index') }}" class="btn btn-outline-warning"><i class="bi bi-bar-chart-line me-2"></i>Reports</a>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-white border-0 fw-bold">System Summary</div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Users</span>
                        <strong>{{ $totalUsers ?? 0 }}</strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Projects</span>
                        <strong>{{ $activeProjects ?? 0 }}</strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Investments</span>
                        <strong>${{ number_format((float) ($totalInvestments ?? 0), 2, '.', '') }}</strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Pending</span>
                        <strong>{{ $pendingPurchaseRequests ?? 0 }}</strong>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
