<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\Admin\TicketController as AdminTicketController;


Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware(['auth'])->group(function () {
    Route::get('/', [TicketController::class, 'index'])->name('dashboard');
    Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create');
    Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
});


Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/tickets', [AdminTicketController::class, 'index'])->name('admin.tickets.index');
    Route::get('/tickets/{ticket}', [AdminTicketController::class, 'show'])->name('admin.tickets.show');
    Route::post('/tickets/{ticket}/approve', [AdminTicketController::class, 'approve'])->name('admin.tickets.approve');
    Route::post('/tickets/{ticket}/reject', [AdminTicketController::class, 'reject'])->name('admin.tickets.reject');
    Route::post('/tickets/bulk-approve', [AdminTicketController::class, 'bulkApprove'])->name('admin.tickets.bulk-approve');
});
