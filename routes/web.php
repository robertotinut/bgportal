<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\AppManagementController;
use App\Http\Controllers\Admin\AppAccessController;
use App\Http\Controllers\Apps\PosController;
use App\Http\Controllers\Apps\PinterestAffiliateController;

// Guest Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth');

// Protected Central Dashboard Routes
Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index']);
});

// POS Module Routes
Route::middleware('auth')->prefix('apps/pos')->name('apps.pos.')->group(function () {
    Route::get('/', [PosController::class, 'index'])->name('index');
    Route::get('/reports', [PosController::class, 'reports'])->name('reports');
    Route::get('/products', [PosController::class, 'products'])->name('products');
});

// Pinterest Affiliate Module Routes
Route::middleware('auth')->prefix('apps/pinterest-affiliate')->name('apps.pinterest.')->group(function () {
    Route::get('/', [PinterestAffiliateController::class, 'index'])->name('index');
    Route::post('/toggle', [PinterestAffiliateController::class, 'toggleAutomation'])->name('toggle');

    Route::get('/accounts', [PinterestAffiliateController::class, 'accounts'])->name('accounts');
    Route::post('/accounts', [PinterestAffiliateController::class, 'storeAccount'])->name('accounts.store');
    Route::delete('/accounts/{account}', [PinterestAffiliateController::class, 'destroyAccount'])->name('accounts.destroy');

    Route::get('/links', [PinterestAffiliateController::class, 'links'])->name('links');
    Route::post('/links', [PinterestAffiliateController::class, 'storeLink'])->name('links.store');
    Route::post('/links/{link}/process', [PinterestAffiliateController::class, 'processNow'])->name('links.process');
    Route::delete('/links/{link}', [PinterestAffiliateController::class, 'destroyLink'])->name('links.destroy');

    Route::get('/settings', [PinterestAffiliateController::class, 'settings'])->name('settings');
    Route::post('/settings', [PinterestAffiliateController::class, 'updateSettings'])->name('settings.update');

    Route::get('/logs', [PinterestAffiliateController::class, 'logs'])->name('logs');
});

// Protected Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('apps', AppManagementController::class);
    Route::get('app-access', [AppAccessController::class, 'index'])->name('app-access.index');
    Route::get('app-access/{user}/edit', [AppAccessController::class, 'edit'])->name('app-access.edit');
    Route::put('app-access/{user}', [AppAccessController::class, 'update'])->name('app-access.update');
});
