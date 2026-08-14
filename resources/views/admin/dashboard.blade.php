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
        <x-admin.card title="Pending Purchase Requests" icon="bi-bag-check" value="{{ $pendingPurchaseRequests ?? 0 }}" color="warning" />
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

        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-white border-0 fw-bold d-flex justify-content-between align-items-center">
                <span>طلبات الشراء الأخيرة</span>
                <a href="{{ route('admin.purchase-requests.index') }}" class="btn btn-sm btn-outline-primary">عرض الكل</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>المشتري</th>
                                <th>المشروع</th>
                                <th>المبلغ</th>
                                <th>الحالة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($purchaseRequests as $purchaseRequest)
                                <tr>
                                    <td>{{ $purchaseRequest->buyer_name }}</td>
                                    <td>{{ $purchaseRequest->project?->name ?? '-' }}</td>
                                    <td>${{ number_format((float) $purchaseRequest->offer_amount, 2) }}</td>
                                    <td>
                                        @if($purchaseRequest->status === 'pending')
                                            <span class="badge bg-warning text-dark">معلقة</span>
                                        @elseif($purchaseRequest->status === 'approved')
                                            <span class="badge bg-success">موافق عليها</span>
                                        @else
                                            <span class="badge bg-danger">مرفوضة</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            @if($purchaseRequest->status === 'pending')
                                                <form action="{{ route('admin.purchase-requests.approve', $purchaseRequest) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success" title="قبول">
                                                        <i class="bi bi-check-lg"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.purchase-requests.reject', $purchaseRequest) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-danger" title="رفض">
                                                        <i class="bi bi-x-lg"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            <a href="{{ route('admin.purchase-requests.show', $purchaseRequest) }}" class="btn btn-sm btn-info" title="عرض">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">لا توجد طلبات شراء حتى الآن</td>
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
                    <a href="{{ route('admin.projects.index') }}" class="btn btn-outline-primary"><i class="bi bi-building me-2"></i>Manage Projects</a>
                    <a href="{{ route('admin.investors.index') }}" class="btn btn-outline-success"><i class="bi bi-people me-2"></i>View Investors</a>
                    <a href="{{ route('admin.payments.index') }}" class="btn btn-outline-info"><i class="bi bi-credit-card me-2"></i>Payments</a>
                    <a href="{{ route('admin.purchase-requests.index') }}" class="btn btn-outline-warning"><i class="bi bi-bag-check me-2"></i>Purchase Requests</a>
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
