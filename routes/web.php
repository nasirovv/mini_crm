<?php

use App\Http\Controllers\WEB\WidgetController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/widget');
});

Route::get('widget', [WidgetController::class, 'index']);
