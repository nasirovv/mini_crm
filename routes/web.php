<?php

use App\Http\Controllers\WEB\Admin\CustomerController;
use App\Http\Controllers\WEB\Admin\DashboardController;
use App\Http\Controllers\WEB\Admin\TicketController;
use App\Http\Controllers\WEB\AuthController;
use App\Http\Controllers\WEB\WidgetController;
use App\Http\Middleware\AllowIframeEmbedding;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/widget');
});

Route::get('widget', [WidgetController::class, 'index'])->middleware(AllowIframeEmbedding::class);
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth')->prefix('admin')->as('admin.')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::delete('logout', [AuthController::class, 'logout'])->name('logout');

    Route::prefix('tickets')->as('tickets.')->group(function () {
        Route::get('/', [TicketController::class, 'index'])->name('index');
        Route::get('{ticket}', [TicketController::class, 'show'])->name('show');
    });

    Route::prefix('customers')->as('customers.')->group(function () {
        Route::get('/', [CustomerController::class, 'index'])->name('index');
        Route::get('{customer}', [CustomerController::class, 'show'])->name('show');
    });
});

