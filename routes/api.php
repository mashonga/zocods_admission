<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApplicationController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/applications', [ApplicationController::class, 'index']);
Route::get('/applications/{application}', [ApplicationController::class, 'show']);
Route::patch('/applications/{application}/status', [ApplicationController::class, 'updateStatus']);
Route::delete('/applications/{application}', [ApplicationController::class, 'destroy']);

// PayChangu Webhook
Route::post('/api/paychangu/webhook', function(Request $request) {
    \Log::info('PayChangu Webhook', ['data' => $request->all()]);
    return response()->json(['status' => 'success']);
});
