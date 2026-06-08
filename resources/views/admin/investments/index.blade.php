@extends('layouts.admin')

@section('title', 'الاستثمارات')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3">قائمة الاستثمارات</h1>
        <a href="{{ route('admin.investments.create') }}" class="btn btn-primary">
            <i class="bi bi-plus"></i> إضافة استثمار جديد
        </a>
    </div>
    @include('partials.flash-messages')
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>المستثمر</th>
                            <th>العقار</th>
                            <th>المبلغ</th>
                            <th>تاريخ الاستثمار</th>
                            <th>الحالة</th>
                            <th>العمليات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($investments as $investment)
                        <tr>
                            <td>{{ $investment->id }}</td>
                            <td>{{ $investment->investor->name ?? '-' }}</td>
                            <td>{{ $investment->property->title ?? '-' }}</td>
                            <td>{{ number_format($investment->amount, 2) }}</td>
                            <td>{{ $investment->created_at->format('Y-m-d') }}</td>
                            <td>@include('partials.status-badge', ['status' => $investment->status])</td>
                            <td>
                                <a href="{{ route('admin.investments.show', $investment) }}" class="btn btn-sm btn-info"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('admin.investments.edit', $investment) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('admin.investments.destroy', $investment) }}" method="POST" class="d-inline-block" onsubmit="return confirm('تأكيد الحذف؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">لا توجد استثمارات بعد.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="mt-3">
        {{ $investments->links('partials.pagination') }}
    </div>
</div>
@endsection
