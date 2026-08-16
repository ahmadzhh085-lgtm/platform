@extends('layouts.admin')

@section('title', 'Reports')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">Reports Center</h2>
        <p class="text-muted mb-0">Performance overview for the investment platform.</p>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-3 col-sm-6">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body">
                <div class="text-muted small">Total Revenue</div>
                <div class="fw-bold fs-4">${{ number_format((float) ($totalRevenue ?? 0), 2) }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body">
                <div class="text-muted small">Active Projects</div>
                <div class="fw-bold fs-4">{{ $activeProjects ?? 0 }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body">
                <div class="text-muted small">Total Users</div>
                <div class="fw-bold fs-4">{{ $totalUsers ?? 0 }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body">
                <div class="text-muted small">Active Users</div>
                <div class="fw-bold fs-4">{{ $activeUsers ?? 0 }}</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white border-0 fw-bold">Request Stats</div>
            <div class="card-body">
                <div class="row g-3 text-center">
                    <div class="col-md-4">
                        <div class="bg-light rounded-4 p-3">
                            <div class="small text-muted">Pending</div>
                            <div class="fw-bold fs-4 text-warning">{{ $pendingRequests ?? 0 }}</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="bg-light rounded-4 p-3">
                            <div class="small text-muted">Approved</div>
                            <div class="fw-bold fs-4 text-success">{{ $approvedRequests ?? 0 }}</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="bg-light rounded-4 p-3">
                            <div class="small text-muted">Rejected</div>
                            <div class="fw-bold fs-4 text-danger">{{ $rejectedRequests ?? 0 }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white border-0 fw-bold">Projects By Status</div>
            <div class="card-body">
                @forelse($projectsByStatus as $status)
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-capitalize">{{ $status->status }}</span>
                        <span class="badge bg-primary">{{ $status->total }}</span>
                    </div>
                @empty
                    <p class="text-muted mb-0">No project status data available.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-12">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 fw-bold">Monthly Request Summary</div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Month</th>
                                <th>Requests</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($monthlyReports as $monthData)
                                <tr>
                                    <td>{{ $monthData->month }}</td>
                                    <td>{{ $monthData->total }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center text-muted py-4">No monthly report data available.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
