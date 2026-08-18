<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\InvestmentController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\PropertyController;
use App\Http\Controllers\Api\InvestorController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\ProjectPurchaseRequestController;
use App\Http\Controllers\Api\PropertySaleRequestController;

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('user', [AuthController::class, 'user']);
    });
});

// Public Project routes (listing, show)
Route::get('projects', [ProjectController::class, 'index']);
Route::get('projects/{project}', [ProjectController::class, 'show']);

// Public Property routes (listing, show)
// Usage: GET /api/properties?project_id=1 for properties of a specific project
Route::get('properties', [PropertyController::class, 'index']);
Route::get('properties/{property}', [PropertyController::class, 'show']);

// Public Investor routes (listing, show)
Route::get('investors', [InvestorController::class, 'index']);
Route::get('investors/{investor}', [InvestorController::class, 'show']);

// Public Payment routes (listing, show)
Route::get('payments', [PaymentController::class, 'index']);
Route::get('payments/{payment}', [PaymentController::class, 'show']);

// Public Investment routes (listing, show)
Route::get('investments', [InvestmentController::class, 'index']);
Route::get('investments/{investment}', [InvestmentController::class, 'show']);

// Purchase requests API
// Purchase requests API - expose canonical endpoints and keep legacy alias for compatibility
Route::middleware(['auth:sanctum'])->group(function () {
    // Canonical routes
    Route::get('purchase-requests', [ProjectPurchaseRequestController::class, 'index']);
    Route::get('purchase-requests/{projectPurchaseRequest}', [ProjectPurchaseRequestController::class, 'show']);
    Route::patch('purchase-requests/{projectPurchaseRequest}/status', [ProjectPurchaseRequestController::class, 'updateStatus']);
    Route::post('purchase-requests', [ProjectPurchaseRequestController::class, 'store']);

    // Legacy alias routes kept for older clients
    Route::get('project-purchase-requests', [ProjectPurchaseRequestController::class, 'index']);
    Route::get('project-purchase-requests/{projectPurchaseRequest}', [ProjectPurchaseRequestController::class, 'show']);
    Route::patch('project-purchase-requests/{projectPurchaseRequest}/status', [ProjectPurchaseRequestController::class, 'updateStatus']);
    Route::post('project-purchase-requests', [ProjectPurchaseRequestController::class, 'store']);

    Route::get('property-sale-requests', [PropertySaleRequestController::class, 'index']);
    Route::get('property-sale-requests/{propertySaleRequest}', [PropertySaleRequestController::class, 'show']);
    Route::patch('property-sale-requests/{propertySaleRequest}/status', [PropertySaleRequestController::class, 'updateStatus']);
    Route::post('property-sale-requests', [PropertySaleRequestController::class, 'store']);
});


// Protected Payment and Investment routes (create, update, delete)
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('payments', [PaymentController::class, 'store']);
    Route::put('payments/{payment}', [PaymentController::class, 'update']);
    Route::delete('payments/{payment}', [PaymentController::class, 'destroy']);

    Route::post('investments', [InvestmentController::class, 'store']);
    Route::put('investments/{investment}', [InvestmentController::class, 'update']);
    Route::delete('investments/{investment}', [InvestmentController::class, 'destroy']);
});
