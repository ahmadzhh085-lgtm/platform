<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\InvestmentController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\PropertyController;
use App\Http\Controllers\Api\InvestorController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\ProjectPurchaseRequestController;

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
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('purchase-requests', [ProjectPurchaseRequestController::class, 'index']);
    Route::get('purchase-requests/{projectPurchaseRequest}', [ProjectPurchaseRequestController::class, 'show']);
    Route::patch('purchase-requests/{projectPurchaseRequest}/status', [ProjectPurchaseRequestController::class, 'updateStatus']);
    Route::post('purchase-requests', [ProjectPurchaseRequestController::class, 'store']);
    
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
