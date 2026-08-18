@extends('layouts.admin')

@section('title', 'Property Sale Requests')

@section('content')
    @include('partials.flash-messages')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">طلبات بيع العقارات</h4>
            <p class="text-muted mb-0">إدارة طلبات بيع العقارات من المستخدمين</p>
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
                        <th>اسم البائع</th>
                        <th>العقار</th>
                        <th>المدينة</th>
                        <th>السعر</th>
                        <th>الحالة</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($propertySaleRequests as $request)
                        <tr>
                            <td>{{ $request->id }}</td>
                            <td>{{ $request->seller_name }}</td>
                            <td>{{ $request->title }}</td>
                            <td>{{ $request->city }}</td>
                            <td><strong>${{ number_format((float) $request->price, 2) }}</strong></td>
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
                                        <form action="{{ route('admin.property-sale-requests.approve', $request) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success" title="قبول">
                                                <i class="bi bi-check-lg"></i> قبول
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.property-sale-requests.reject', $request) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger" title="رفض">
                                                <i class="bi bi-x-lg"></i> رفض
                                            </button>
                                        </form>
                                    @endif
                                    <a href="{{ route('admin.property-sale-requests.show', $request) }}" class="btn btn-sm btn-info" title="التفاصيل">
                                        <i class="bi bi-eye"></i> عرض
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                لا توجد طلبات بيع عقارات حتى الآن
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer bg-white py-3">
            {{ $propertySaleRequests->links() }}
        </div>
    </div>
@endsection
