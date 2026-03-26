<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/apply', [ApplicationController::class, 'create']);
Route::post('/apply', [ApplicationController::class, 'store']);

Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/admin/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::get('/admin/applications', [ApplicationController::class, 'index']);
    Route::get('/admin/applications/{application}', [ApplicationController::class, 'show']);
    Route::post('/admin/applications/{application}/status', [ApplicationController::class, 'updateStatus']);
    Route::post('/admin/applications/{application}/delete', [ApplicationController::class, 'destroy']);
    Route::post('/admin/logout', [AuthController::class, 'logout']);
});