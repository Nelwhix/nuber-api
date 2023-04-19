<?php

use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\DriverController;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;

Route::get('/ping', fn () => response(["message" => "pong @". Carbon::now() . "UTC"]));

Route::controller(AuthenticatedSessionController::class)->group(function () {
    Route::post('/auth/login', 'store');
    Route::post('/auth/verify', 'update');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function(Request $request) {
        return response()->json([
            'message' => 'successful',
            'user' => $request->user()
        ]);
    });

    Route::get('/driver', [DriverController::class, 'show']);
    Route::post('/driver', [DriverController::class, 'store']);


});
