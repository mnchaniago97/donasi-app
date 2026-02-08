<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\BankAccountController;
use App\Http\Controllers\Auth\AuthController;

// Home
Route::get('/', function () {
    return view('welcome');
});

// Auth Routes
Route::prefix('auth')->name('auth.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
    
    // Setup admin (hanya untuk development)
    Route::get('/create-admin', [AuthController::class, 'createAdmin'])->name('create-admin');
});

// Donasi Routes
Route::prefix('donasi')->name('donations.')->group(function () {
    // Public routes
    Route::get('/form', [DonationController::class, 'create'])->name('create');
    Route::post('/', [DonationController::class, 'store'])->name('store');
    Route::get('/{donation}/pembayaran', [DonationController::class, 'payment'])->name('payment');
    Route::get('/{donation}/status', [DonationController::class, 'show'])->name('show');
    Route::post('/{donation}/check-status', [DonationController::class, 'checkStatus'])->name('checkStatus');
    
    // Webhook from Midtrans
    Route::post('/webhook/midtrans', [DonationController::class, 'handleNotification'])->name('notification');
    
    // List donasi sukses
    Route::get('/daftar/sukses', [DonationController::class, 'listSuccess'])->name('listSuccess');
});

// Admin Routes (Protected by auth middleware)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DonationController::class, 'dashboard'])->name('dashboard');
    
    // Bank Accounts Management
    Route::resource('bank-accounts', BankAccountController::class);
});
