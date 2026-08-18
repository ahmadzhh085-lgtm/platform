@extends('layouts.admin')

@section('title', 'تفاصيل طلب بيع العقار')

@section('content')
    @include('partials.flash-messages')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">تفاصيل طلب بيع العقار #{{ $propertySaleRequest->id }}</h4>
        <a href="{{ route('admin.property-sale-requests.index') }}" class="btn btn-secondary">
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
                            <p class="mb-2"><small class="text-muted">اسم البائع</small></p>
                            <p class="mb-3">{{ $propertySaleRequest->seller_name }}</p>

                            <p class="mb-2"><small class="text-muted">رقم الهاتف</small></p>
                            <p class="mb-3">{{ $propertySaleRequest->seller_phone }}</p>

                            <p class="mb-2"><small class="text-muted">البريد الإلكتروني</small></p>
                            <p class="mb-3">{{ $propertySaleRequest->seller_email }}</p>

                            <p class="mb-2"><small class="text-muted">رقم الهوية</small></p>
                            <p class="mb-3">{{ $propertySaleRequest->seller_national_id }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-2"><small class="text-muted">اسم العقار</small></p>
                            <p class="mb-3">{{ $propertySaleRequest->title }}</p>

                            <p class="mb-2"><small class="text-muted">نوع العقار</small></p>
                            <p class="mb-3">{{ $propertySaleRequest->type }}</p>

                            <p class="mb-2"><small class="text-muted">السعر</small></p>
                            <p class="mb-3"><strong class="text-success fs-5">${{ number_format((float) $propertySaleRequest->price, 2) }}</strong></p>

                            <p class="mb-2"><small class="text-muted">الموقع</small></p>
                            <p class="mb-3">{{ $propertySaleRequest->city }} - {{ $propertySaleRequest->location ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="row g-3 mt-2">
                        <div class="col-md-4">
                            <p class="mb-2"><small class="text-muted">المساحة</small></p>
                            <p>{{ $propertySaleRequest->area ?? '-' }}</p>
                        </div>
                        <div class="col-md-4">
                            <p class="mb-2"><small class="text-muted">عدد الغرف</small></p>
                            <p>{{ $propertySaleRequest->bedrooms ?? '-' }}</p>
                        </div>
                        <div class="col-md-4">
                            <p class="mb-2"><small class="text-muted">تاريخ الطلب</small></p>
                            <p>{{ $propertySaleRequest->created_at->format('Y-m-d H:i') }}</p>
                        </div>
                    </div>

                    @if($propertySaleRequest->description)
                        <div class="mt-4 pt-4 border-top">
                            <h6 class="mb-2">وصف العقار</h6>
                            <p class="text-muted mb-0">{{ $propertySaleRequest->description }}</p>
                        </div>
                    @endif

                    @if($propertySaleRequest->notes)
                        <div class="mt-4 pt-4 border-top">
                            <h6 class="mb-2">ملاحظات البائع</h6>
                            <p class="text-muted mb-0">{{ $propertySaleRequest->notes }}</p>
                        </div>
                    @endif
                </div>
            </div>

            @if($propertySaleRequest->status !== 'pending')
                <div class="card shadow-sm rounded mt-4">
                    <div class="card-header bg-light border-0">
                        <h6 class="mb-0">ملاحظات الإدارة</h6>
                    </div>
                    <div class="card-body">
                        <p class="mb-2"><small class="text-muted">تمت المراجعة من قبل:</small></p>
                        <p class="mb-3">{{ $propertySaleRequest->reviewer?->name ?? '-' }}</p>

                        <p class="mb-2"><small class="text-muted">تاريخ المراجعة:</small></p>
                        <p class="mb-3">{{ $propertySaleRequest->reviewed_at?->format('Y-m-d H:i') ?? '-' }}</p>

                        <p class="mb-2"><small class="text-muted">ملاحظات الإدارة:</small></p>
                        <p class="text-muted mb-0">{{ $propertySaleRequest->admin_notes ?: 'لا توجد ملاحظات' }}</p>
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
                        @if($propertySaleRequest->status === 'pending')
                            <span class="badge bg-warning text-dark p-2" style="font-size: 0.875rem;">معلقة</span>
                        @elseif($propertySaleRequest->status === 'approved')
                            <span class="badge bg-success p-2" style="font-size: 0.875rem;">موافق عليها</span>
                        @else
                            <span class="badge bg-danger p-2" style="font-size: 0.875rem;">مرفوضة</span>
                        @endif
                    </div>

                    @if($propertySaleRequest->status === 'pending')
                        <div class="card border-warning shadow-sm">
                            <div class="card-body">
                                <h6 class="mb-3">اتخاذ قرار</h6>

                                <form action="{{ route('admin.property-sale-requests.approve', $propertySaleRequest) }}" method="POST" class="mb-2">
                                    @csrf
                                    <button type="submit" class="btn btn-success w-100 mb-2">
                                        <i class="bi bi-check-circle me-2"></i>قبول الطلب
                                    </button>
                                </form>

                                <form action="{{ route('admin.property-sale-requests.reject', $propertySaleRequest) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-danger w-100">
                                        <i class="bi bi-x-circle me-2"></i>رفض الطلب
                                    </button>
                                </form>
                            </div>
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
