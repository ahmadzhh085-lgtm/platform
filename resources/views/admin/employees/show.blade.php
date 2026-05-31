@extends('layouts.admin')

@section('title', 'تفاصيل الموظف')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-3">تفاصيل الموظف</h1>
    <div class="card">
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">الاسم</dt>
                <dd class="col-sm-9">{{ $employee->name }}</dd>
                <dt class="col-sm-3">البريد الإلكتروني</dt>
                <dd class="col-sm-9">{{ $employee->email }}</dd>
                <dt class="col-sm-3">الدور</dt>
                <dd class="col-sm-9">{{ $employee->roles->pluck('name')->join(', ') }}</dd>
                <dt class="col-sm-3">الصلاحيات</dt>
                <dd class="col-sm-9">{{ $employee->getAllPermissions()->pluck('name')->join(', ') }}</dd>
                <dt class="col-sm-3">الحالة</dt>
                <dd class="col-sm-9">@include('partials.status-badge', ['status' => $employee->status])</dd>
                <dt class="col-sm-3">تاريخ الإنشاء</dt>
                <dd class="col-sm-9">{{ $employee->created_at->format('Y-m-d H:i') }}</dd>
                <dt class="col-sm-3">آخر تحديث</dt>
                <dd class="col-sm-9">{{ $employee->updated_at->format('Y-m-d H:i') }}</dd>
            </dl>
            <a href="{{ route('admin.employees.edit', $employee) }}" class="btn btn-warning"><i class="bi bi-pencil"></i> تعديل</a>
            <a href="{{ route('admin.employees.index') }}" class="btn btn-secondary">عودة للقائمة</a>
        </div>
    </div>
</div>
@endsection
