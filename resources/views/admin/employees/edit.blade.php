@extends('layouts.admin')

@section('title', 'تعديل موظف')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-3">تعديل موظف</h1>
    @include('partials.form-errors')
    <form action="{{ route('admin.employees.update', $employee) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="name" class="form-label">الاسم</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $employee->name) }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="email" class="form-label">البريد الإلكتروني</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $employee->email) }}" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="status" class="form-label">الحالة</label>
                <select name="status" id="status" class="form-select" required>
                    <option value="active" {{ old('status', $employee->status) == 'active' ? 'selected' : '' }}>نشط</option>
                    <option value="inactive" {{ old('status', $employee->status) == 'inactive' ? 'selected' : '' }}>غير نشط</option>
                </select>
            </div>
        </div>
        <div class="mb-3">
            <label for="roles" class="form-label">الدور الوظيفي</label>
            <select name="roles[]" id="roles" class="form-select" multiple required>
                @foreach($roles as $role)
                    <option value="{{ $role->name }}" {{ ($employee->roles->contains('name', $role->name) || collect(old('roles'))->contains($role->name)) ? 'selected' : '' }}>{{ $role->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="permissions" class="form-label">الصلاحيات الإضافية</label>
            <select name="permissions[]" id="permissions" class="form-select" multiple>
                @foreach($permissions as $permission)
                    <option value="{{ $permission->name }}" {{ ($employee->permissions->contains('name', $permission->name) || collect(old('permissions'))->contains($permission->name)) ? 'selected' : '' }}>{{ $permission->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-success"><i class="bi bi-check"></i> حفظ التعديلات</button>
        <a href="{{ route('admin.employees.index') }}" class="btn btn-secondary">إلغاء</a>
    </form>
</div>
@endsection
