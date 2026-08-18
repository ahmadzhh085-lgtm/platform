<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProjectController;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }

    return view('home');
});

Route::middleware(['auth', 'verified'])
    ->get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');


use App\Http\Controllers\Admin\PropertyController;
use App\Http\Controllers\Admin\PropertySaleRequestController;
use App\Http\Controllers\Admin\InvestorController;
use App\Http\Controllers\Admin\InvestmentController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\PurchaseRequestController;

Route::prefix('admin')
    ->middleware(['auth', 'verified'])
    ->as('admin.')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('projects', ProjectController::class);
        Route::resource('properties', PropertyController::class);
        Route::resource('investors', InvestorController::class);
            Route::resource('investments', InvestmentController::class); // Adding investments resource route
        Route::resource('payments', PaymentController::class);
        Route::resource('purchase-requests', PurchaseRequestController::class);
        Route::post('purchase-requests/{purchaseRequest}/approve', [PurchaseRequestController::class, 'approve'])->name('purchase-requests.approve');
        Route::post('purchase-requests/{purchaseRequest}/reject', [PurchaseRequestController::class, 'reject'])->name('purchase-requests.reject');

        Route::get('property-sale-requests', [PropertySaleRequestController::class, 'index'])->name('property-sale-requests.index');
        Route::get('property-sale-requests/{propertySaleRequest}', [PropertySaleRequestController::class, 'show'])->name('property-sale-requests.show');
        Route::post('property-sale-requests/{propertySaleRequest}/approve', [PropertySaleRequestController::class, 'approve'])->name('property-sale-requests.approve');
        Route::post('property-sale-requests/{propertySaleRequest}/reject', [PropertySaleRequestController::class, 'reject'])->name('property-sale-requests.reject');

        Route::resource('employees', EmployeeController::class); // إضافة مسار الموظفين
        Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('settings', function() { return view('admin.settings'); })->name('settings');
    });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
