<?php

use App\Http\Controllers\AuthenticatedSessionController;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;

Route::get('/ping', fn () => response(["message" => "pong @". Carbon::now() . "UTC"]));

Route::controller(AuthenticatedSessionController::class)->group(function () {
    Route::post('/auth/login', 'store');
    Route::post('/auth/verify', 'update');
});
