@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">Investment Overview</h2>
        <p class="text-muted mb-0">Track projects, investors, and performance in one place.</p>
    </div>
    <a href="{{ route('admin.projects.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-2"></i>New Project
    </a>
</div>

<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <x-admin.card title="Total Investments" icon="bi-cash-stack" value="$250K" color="primary" />
    </div>
    <div class="col-xl-3 col-md-6">
        <x-admin.card title="Total Investors" icon="bi-people" value="120" color="success" />
    </div>
    <div class="col-xl-3 col-md-6">
        <x-admin.card title="Active Projects" icon="bi-building" value="18" color="info" />
    </div>
    <div class="col-xl-3 col-md-6">
        <x-admin.card title="Monthly Revenue" icon="bi-bar-chart-line" value="$35K" color="warning" />
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-white border-0 fw-bold">Revenue Overview</div>
            <div class="card-body">
                <div class="bg-light rounded-4 p-4 text-center text-muted">
                    <i class="bi bi-graph-up-arrow fs-1 d-block mb-2"></i>
                    Revenue chart can be connected to your analytics data.
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-white border-0 fw-bold">Recent Investments</div>
            <div class="card-body p-0">
                <x-admin.recent-investments-table />
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-white border-0 fw-bold">Quick Actions</div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.projects.index') }}" class="btn btn-outline-primary"><i class="bi bi-building me-2"></i>Manage Projects</a>
                    <a href="{{ route('admin.investors.index') }}" class="btn btn-outline-success"><i class="bi bi-people me-2"></i>View Investors</a>
                    <a href="{{ route('admin.payments.index') }}" class="btn btn-outline-info"><i class="bi bi-credit-card me-2"></i>Payments</a>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-white border-0 fw-bold">Recent Investors</div>
            <div class="card-body p-0">
                <x-admin.recent-investors />
            </div>
        </div>
    </div>
</div>
@endsection
