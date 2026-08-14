@extends('layouts.admin')

@section('title', 'تفاصيل طلب الشراء')

@section('content')
    @include('partials.flash-messages')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">تفاصيل طلب الشراء #{{ $purchaseRequest->id }}</h4>
        <a href="{{ route('admin.purchase-requests.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> العودة
        </a>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card shadow-sm rounded">
                <div class="card-header bg-light border-0">
                    <h6 class="mb-0">معلومات الطلب</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <p class="mb-2"><small class="text-muted">المشروع</small></p>
                            <p class="mb-3">
                                <a href="{{ route('admin.projects.show', $purchaseRequest->project) }}" class="text-decoration-none fw-bold">
                                    {{ $purchaseRequest->project?->name ?? '-' }}
                                </a>
                            </p>

                            <p class="mb-2"><small class="text-muted">اسم المشتري</small></p>
                            <p class="mb-3">{{ $purchaseRequest->buyer_name }}</p>

                            <p class="mb-2"><small class="text-muted">البريد الإلكتروني</small></p>
                            <p class="mb-3">{{ $purchaseRequest->buyer_email }}</p>

                            <p class="mb-2"><small class="text-muted">رقم الهوية الوطنية</small></p>
                            <p class="mb-3">{{ $purchaseRequest->buyer_national_id }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-2"><small class="text-muted">الهاتف</small></p>
                            <p class="mb-3">{{ $purchaseRequest->buyer_phone }}</p>

                            <p class="mb-2"><small class="text-muted">المبلغ المعروض</small></p>
                            <p class="mb-3"><strong class="text-success fs-5">${{ number_format((float) $purchaseRequest->offer_amount, 2) }}</strong></p>

                            <p class="mb-2"><small class="text-muted">تم التقديم من قبل</small></p>
                            <p class="mb-3">{{ $purchaseRequest->user?->name ?? 'مستخدم' }}</p>

                            <p class="mb-2"><small class="text-muted">تاريخ التقديم</small></p>
                            <p class="mb-3">{{ $purchaseRequest->created_at->format('Y-m-d H:i') }}</p>
                        </div>
                    </div>

                    @if($purchaseRequest->notes)
                        <div class="mt-4 pt-4 border-top">
                            <h6 class="mb-2">ملاحظات المشتري</h6>
                            <p class="text-muted mb-0">{{ $purchaseRequest->notes }}</p>
                        </div>
                    @endif
                </div>
            </div>

            @if($purchaseRequest->status !== 'pending')
                <div class="card shadow-sm rounded mt-4">
                    <div class="card-header bg-light border-0">
                        <h6 class="mb-0">ملاحظات الإدارة</h6>
                    </div>
                    <div class="card-body">
                        <p class="mb-2"><small class="text-muted">تم المراجعة من قبل:</small></p>
                        <p class="mb-3">{{ $purchaseRequest->reviewer?->name ?? '-' }}</p>

                        <p class="mb-2"><small class="text-muted">تاريخ المراجعة:</small></p>
                        <p class="mb-3">{{ $purchaseRequest->reviewed_at?->format('Y-m-d H:i') ?? '-' }}</p>

                        <p class="mb-2"><small class="text-muted">ملاحظات الإدارة:</small></p>
                        <p class="text-muted mb-0">{{ $purchaseRequest->admin_notes ?: 'لا توجد ملاحظات' }}</p>
                    </div>
                </div>
            @endif
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm rounded">
                <div class="card-header bg-light border-0">
                    <h6 class="mb-0">حالة الطلب</h6>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        @if($purchaseRequest->status === 'pending')
                            <span class="badge bg-warning text-dark p-2" style="font-size: 0.875rem;">معلقة</span>
                        @elseif($purchaseRequest->status === 'approved')
                            <span class="badge bg-success p-2" style="font-size: 0.875rem;">موافق عليها</span>
                        @else
                            <span class="badge bg-danger p-2" style="font-size: 0.875rem;">مرفوضة</span>
                        @endif
                    </div>

                    @if($purchaseRequest->status === 'pending')
                        <div class="card border-warning shadow-sm">
                            <div class="card-body">
                                <h6 class="mb-3">اتخاذ قرار</h6>
                                
                                <form action="{{ route('admin.purchase-requests.approve', $purchaseRequest) }}" method="POST" class="mb-2">
                                    @csrf
                                    <button type="submit" class="btn btn-success w-100 mb-2">
                                        <i class="bi bi-check-circle me-2"></i>قبول الطلب
                                    </button>
                                </form>

                                <form action="{{ route('admin.purchase-requests.reject', $purchaseRequest) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-danger w-100">
                                        <i class="bi bi-x-circle me-2"></i>رفض الطلب
                                    </button>
                                </form>
                            </div>
                        </div>

                        <div class="alert alert-info mt-3 mb-0">
                            <small><i class="bi bi-info-circle me-2"></i>يمكنك قبول أو رفض الطلب باستخدام الأزرار أعلاه</small>
                        </div>
                    @else
                        <div class="alert alert-info mb-0">
                            <small>تم معالجة هذا الطلب بالفعل</small>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
