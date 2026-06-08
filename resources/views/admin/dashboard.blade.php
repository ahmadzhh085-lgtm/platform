@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <x-admin.card title="Total Investments" icon="bi-cash-stack" value="$0" color="primary" />
    </div>
    <div class="col-md-3">
        <x-admin.card title="Total Investors" icon="bi-people" value="0" color="success" />
    </div>
    <div class="col-md-3">
        <x-admin.card title="Total Properties" icon="bi-house-door" value="0" color="info" />
    </div>
    <div class="col-md-3">
        <x-admin.card title="Monthly Revenue" icon="bi-bar-chart-line" value="$0" color="warning" />
    </div>
</div>
<div class="row g-4">
    <div class="col-lg-8">
        <div class="card shadow-sm rounded mb-4">
            <div class="card-header bg-white fw-bold">Revenue Overview</div>
            <div class="card-body">
                <canvas id="revenueChart" height="120"></canvas>
            </div>
        </div>
        <div class="card shadow-sm rounded mb-4">
            <div class="card-header bg-white fw-bold">Recent Investments</div>
            <div class="card-body p-0">
                <x-admin.recent-investments-table />
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card shadow-sm rounded mb-4">
            <div class="card-header bg-white fw-bold">Monthly Profit</div>
            <div class="card-body">
                <canvas id="profitChart" height="120"></canvas>
            </div>
        </div>
        <div class="card shadow-sm rounded mb-4">
            <div class="card-header bg-white fw-bold">Recent Investors</div>
            <div class="card-body p-0">
                <x-admin.recent-investors />
            </div>
        </div>
    </div>
</div>
@endsection
