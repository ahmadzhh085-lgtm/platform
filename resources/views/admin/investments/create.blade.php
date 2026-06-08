@extends('layouts.admin')

@section('title', 'إضافة استثمار جديد')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-3">إضافة استثمار جديد</h1>
    @include('partials.form-errors')
    <form action="{{ route('admin.investments.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="investor_id" class="form-label">المستثمر</label>
                <select name="investor_id" id="investor_id" class="form-select" required>
                    <option value="">اختر المستثمر</option>
                    @foreach($investors as $investor)
                        <option value="{{ $investor->id }}" {{ old('investor_id') == $investor->id ? 'selected' : '' }}>{{ $investor->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="property_id" class="form-label">العقار</label>
                <select name="property_id" id="property_id" class="form-select" required>
                    <option value="">اختر العقار</option>
                    @foreach($properties as $property)
                        <option value="{{ $property->id }}" {{ old('property_id') == $property->id ? 'selected' : '' }}>{{ $property->title }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="amount" class="form-label">المبلغ</label>
                <input type="number" name="amount" id="amount" class="form-control" value="{{ old('amount') }}" required min="0" step="0.01">
            </div>
            <div class="col-md-6 mb-3">
                <label for="status" class="form-label">الحالة</label>
                <select name="status" id="status" class="form-select" required>
                    <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                    <option value="approved" {{ old('status') == 'approved' ? 'selected' : '' }}>مقبول</option>
                    <option value="rejected" {{ old('status') == 'rejected' ? 'selected' : '' }}>مرفوض</option>
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-success"><i class="bi bi-check"></i> حفظ</button>
        <a href="{{ route('admin.investments.index') }}" class="btn btn-secondary">إلغاء</a>
    </form>
</div>
@endsection
