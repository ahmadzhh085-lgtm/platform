@extends('layouts.admin')

@section('title', 'تفاصيل الاستثمار')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-3">تفاصيل الاستثمار</h1>
    <div class="card">
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">المستثمر</dt>
                <dd class="col-sm-9">{{ $investment->investor->name ?? '-' }}</dd>
                <dt class="col-sm-3">المشروع</dt>
                <dd class="col-sm-9">{{ $investment->project->name ?? '-' }}</dd>
                <dt class="col-sm-3">المبلغ</dt>
                <dd class="col-sm-9">{{ number_format($investment->amount, 2) }}</dd>
                <dt class="col-sm-3">الحالة</dt>
                <dd class="col-sm-9">@include('partials.status-badge', ['status' => $investment->status])</dd>
                <dt class="col-sm-3">تاريخ الإنشاء</dt>
                <dd class="col-sm-9">{{ $investment->created_at->format('Y-m-d H:i') }}</dd>
                <dt class="col-sm-3">آخر تحديث</dt>
                <dd class="col-sm-9">{{ $investment->updated_at->format('Y-m-d H:i') }}</dd>
            </dl>
            <a href="{{ route('admin.investments.edit', $investment) }}" class="btn btn-warning"><i class="bi bi-pencil"></i> تعديل</a>
            <a href="{{ route('admin.investments.index') }}" class="btn btn-secondary">عودة للقائمة</a>
        </div>
    </div>
</div>
@endsection
