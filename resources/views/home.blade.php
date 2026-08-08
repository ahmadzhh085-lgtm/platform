@extends('layouts.base')

@section('title', 'Welcome')

@section('body')
<div class="d-flex min-vh-100">
    @include('partials.sidebar')

    <div class="flex-grow-1 d-flex flex-column">
        @include('partials.header')

        <main class="flex-grow-1 p-4 p-lg-5">
            <div class="container">
                <div class="row align-items-center gy-4">
                    <div class="col-lg-6">
                        <h1 class="display-5 fw-bold">منصة الاستثمار الحديثة</h1>
                        <p class="lead text-muted">إدارة مشاريعك، المستثمرين، والمدفوعات في مكان واحد. لوحة تحكم احترافية وسهلة الاستخدام.</p>
                        <div class="d-flex gap-2 mt-3">
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-primary btn-lg">اذهب للوحة التحكم</a>
                            <a href="{{ route('register') }}" class="btn btn-outline-secondary btn-lg">سجل الآن</a>
                        </div>
                    </div>
                    <div class="col-lg-6 text-center">
                        <img src="{{ asset('images/dashboard-preview.svg') }}" alt="Dashboard preview" class="img-fluid rounded-4 shadow-sm">
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
