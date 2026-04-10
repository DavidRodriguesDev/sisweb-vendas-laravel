<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SaleController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    Route::get('/dashboard', [DashboardController::class, 'index']);

    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('products', ProductController::class);
    Route::apiResource('customers', CustomerController::class);

    Route::apiResource('sales', SaleController::class)->except(['update', 'destroy']);
    Route::patch('/sales/{sale}/cancel', [SaleController::class, 'cancel']);

    Route::get('/sales/{sale}/payments', [PaymentController::class, 'index']);
    Route::post('/sales/{sale}/payments', [PaymentController::class, 'store']);

    Route::get('/reports/sales', [ReportController::class, 'sales']);
    Route::get('/reports/sales/pdf', [ReportController::class, 'salesPdf']);
});