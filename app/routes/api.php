<?php

use App\Http\Controllers\AuthenticatedSessionController;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;

Route::get('/ping', fn () => response(["message" => "pong @". Carbon::now() . "UTC"]));

Route::get('/user', function(Request $request) {
    return response()->json([
            'message' => 'successful',
            'user' => $request->user()
    ]);
})->middleware('auth:sanctum');

Route::controller(AuthenticatedSessionController::class)->group(function () {
    Route::post('/auth/login', 'store');
    Route::post('/auth/verify', 'update');
});
