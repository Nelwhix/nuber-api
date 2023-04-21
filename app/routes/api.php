<?php

use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\TripController;
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

    Route::controller(TripController::class)->group(function () {
        Route::post('/trip',  'store');
        Route::get('/trip/{trip}', 'show');
        Route::post('/trip/{trip}/accept', 'accept');
        Route::post('/trip/{trip}/start', 'start');
        Route::post('/trip/{trip}/end', 'end');
        Route::post('/trip/{trip}/location', 'location');
    });
});
