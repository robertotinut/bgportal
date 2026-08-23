<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\AppManagementController;
use App\Http\Controllers\Admin\AppAccessController;
use App\Http\Controllers\Apps\PosController;
use App\Http\Controllers\Apps\PinterestAffiliateController;

// Public Privacy Policy Route
Route::view('/privacy-policy', 'privacy')->name('privacy');

// Guest Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth');

// Protected Central Dashboard & Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index']);

    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::get('/subscription', [\App\Http\Controllers\ProfileController::class, 'subscription'])->name('profile.subscription');
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
    Route::post('/fetch-boards', [PinterestAffiliateController::class, 'fetchBoards'])->name('fetch-boards');

    Route::get('/links', [PinterestAffiliateController::class, 'links'])->name('links');
    Route::post('/links', [PinterestAffiliateController::class, 'storeLink'])->name('links.store');
    Route::post('/links/{link}/process', [PinterestAffiliateController::class, 'processNow'])->name('links.process');
    Route::delete('/links/{link}', [PinterestAffiliateController::class, 'destroyLink'])->name('links.destroy');

    Route::get('/settings', [PinterestAffiliateController::class, 'settings'])->name('settings');
    Route::post('/settings', [PinterestAffiliateController::class, 'updateSettings'])->name('settings.update');

    Route::get('/logs', [PinterestAffiliateController::class, 'logs'])->name('logs');
});

// Finanza Finance Module Routes
Route::middleware('auth')->prefix('apps/finance')->name('apps.finance.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Apps\FinanceController::class, 'index'])->name('index');
    Route::get('/bills', [\App\Http\Controllers\Apps\FinanceController::class, 'bills'])->name('bills');
    Route::post('/bills', [\App\Http\Controllers\Apps\FinanceController::class, 'storeBill'])->name('bills.store');
    Route::put('/bills/{bill}', [\App\Http\Controllers\Apps\FinanceController::class, 'updateBill'])->name('bills.update');
    Route::post('/bills/{bill}/pay', [\App\Http\Controllers\Apps\FinanceController::class, 'payBill'])->name('bills.pay');
    Route::delete('/bills/{bill}', [\App\Http\Controllers\Apps\FinanceController::class, 'destroyBill'])->name('bills.destroy');
    Route::get('/reports', [\App\Http\Controllers\Apps\FinanceController::class, 'reports'])->name('reports');
    Route::get('/budgets', [\App\Http\Controllers\Apps\FinanceController::class, 'budgets'])->name('budgets');
    Route::post('/transactions', [\App\Http\Controllers\Apps\FinanceController::class, 'storeTransaction'])->name('transactions.store');
    Route::post('/analyze-receipt', [\App\Http\Controllers\Apps\FinanceController::class, 'analyzeReceipt'])->name('analyzeReceipt');
    Route::put('/transactions/{transaction}', [\App\Http\Controllers\Apps\FinanceController::class, 'updateTransaction'])->name('transactions.update');
    Route::delete('/transactions/{transaction}', [\App\Http\Controllers\Apps\FinanceController::class, 'destroyTransaction'])->name('transactions.destroy');
    Route::post('/budgets', [\App\Http\Controllers\Apps\FinanceController::class, 'storeBudget'])->name('budgets.store');
    Route::put('/target/{budget}', [\App\Http\Controllers\Apps\FinanceController::class, 'updateTarget'])->name('target.update');
    Route::delete('/target/{budget}', [\App\Http\Controllers\Apps\FinanceController::class, 'destroyBudget'])->name('target.destroy');
    Route::post('/wallets', [\App\Http\Controllers\Apps\FinanceController::class, 'storeWallet'])->name('wallets.store');
    Route::post('/wallets/transfer', [\App\Http\Controllers\Apps\FinanceController::class, 'transferWallet'])->name('wallets.transfer');
    Route::put('/wallets/{wallet}', [\App\Http\Controllers\Apps\FinanceController::class, 'updateWallet'])->name('wallets.update');
    Route::delete('/wallets/{wallet}', [\App\Http\Controllers\Apps\FinanceController::class, 'destroyWallet'])->name('wallets.destroy');
});

// Protected Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('apps', AppManagementController::class);
    Route::get('app-access', [AppAccessController::class, 'index'])->name('app-access.index');
    Route::get('app-access/{user}/edit', [AppAccessController::class, 'edit'])->name('app-access.edit');
    Route::put('app-access/{user}', [AppAccessController::class, 'update'])->name('app-access.update');
});
