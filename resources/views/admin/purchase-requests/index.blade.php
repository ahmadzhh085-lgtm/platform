@extends('layouts.admin')

@section('title', 'Purchase Requests')

@section('content')
    @include('partials.flash-messages')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">طلبات الشراء</h4>
            <p class="text-muted mb-0">إدارة وتأكيد جميع طلبات شراء المشاريع</p>
        </div>
        <div>
            <span class="badge bg-warning text-dark me-2">معلقة: {{ $pendingCount ?? 0 }}</span>
            <span class="badge bg-success me-2">موافق عليها: {{ $approvedCount ?? 0 }}</span>
            <span class="badge bg-danger">مرفوضة: {{ $rejectedCount ?? 0 }}</span>
        </div>
    </div>

    <div class="card shadow-sm rounded">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>المشروع</th>
                        <th>المشتري</th>
                        <th>الهاتف</th>
                        <th>المبلغ المعروض</th>
                        <th>الحالة</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($purchaseRequests as $request)
                        <tr>
                            <td>{{ $request->id }}</td>
                            <td>
                                <a href="{{ route('admin.projects.show', $request->project) }}" class="text-decoration-none">
                                    {{ $request->project?->name ?? '-' }}
                                </a>
                            </td>
                            <td>{{ $request->buyer_name }}</td>
                            <td>{{ $request->buyer_phone }}</td>
                            <td><strong>${{ number_format((float) $request->offer_amount, 2) }}</strong></td>
                            <td>
                                @if($request->status === 'pending')
                                    <span class="badge bg-warning text-dark">معلقة</span>
                                @elseif($request->status === 'approved')
                                    <span class="badge bg-success">موافق عليها</span>
                                @else
                                    <span class="badge bg-danger">مرفوضة</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    @if($request->status === 'pending')
                                        <form action="{{ route('admin.purchase-requests.approve', $request) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success" title="قبول">
                                                <i class="bi bi-check-lg"></i> قبول
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.purchase-requests.reject', $request) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger" title="رفض">
                                                <i class="bi bi-x-lg"></i> رفض
                                            </button>
                                        </form>
                                    @endif
                                    <a href="{{ route('admin.purchase-requests.show', $request) }}" class="btn btn-sm btn-info" title="التفاصيل">
                                        <i class="bi bi-eye"></i> عرض
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                لا توجد طلبات شراء حتى الآن
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer bg-white py-3">
            {{ $purchaseRequests->links() }}
        </div>
    </div>

    <style>
        .btn-group {
            gap: 4px;
        }
        .btn-group form {
            display: inline-block;
        }
    </style>
@endsection
