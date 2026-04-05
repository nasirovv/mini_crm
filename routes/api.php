<?php

use App\Http\Controllers\API\TicketController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('tickets')->group(function () {
    Route::post('/', [TicketController::class, 'store'])->middleware('throttle:10,1');
});
