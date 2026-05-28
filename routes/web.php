<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BrandingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\InventoryMovementController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('healthz', fn () => response()->json(['status' => 'ok']))->name('healthz');

Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'create'])->name('login');
    Route::post('login', [LoginController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [LoginController::class, 'destroy'])->name('logout');
    Route::get('/', DashboardController::class)->name('dashboard');

    Route::resource('projects', ProjectController::class);
    Route::resource('expenses', ExpenseController::class)->except(['show']);
    Route::post('expenses/{expense}/approve', [ExpenseController::class, 'approve'])->name('expenses.approve');
    Route::post('expenses/{expense}/reject', [ExpenseController::class, 'reject'])->name('expenses.reject');

    Route::resource('suppliers', SupplierController::class)->except(['show']);
    Route::resource('materials', MaterialController::class)->except(['show']);

    Route::get('inventory', [InventoryMovementController::class, 'index'])->name('inventory.index');
    Route::get('inventory/create', [InventoryMovementController::class, 'create'])->name('inventory.create');
    Route::post('inventory', [InventoryMovementController::class, 'store'])->name('inventory.store');

    Route::resource('purchases', PurchaseController::class)->only(['index', 'create', 'store', 'show']);
    Route::post('purchases/{purchase}/receive', [PurchaseController::class, 'receive'])->name('purchases.receive');
    Route::post('purchases/{purchase}/cancel', [PurchaseController::class, 'cancel'])->name('purchases.cancel');

    Route::get('reports/expenses', [ReportController::class, 'expenses'])->name('reports.expenses');

    Route::middleware('role:admin')->group(function () {
        Route::get('settings/branding', [BrandingController::class, 'edit'])->name('settings.branding.edit');
        Route::put('settings/branding', [BrandingController::class, 'update'])->name('settings.branding.update');
        Route::resource('users', UserController::class)->except(['show', 'destroy']);
    });
});
