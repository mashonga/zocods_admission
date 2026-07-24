<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\ExamBoardController;
use App\Http\Controllers\BoardFeeController;
use App\Http\Controllers\IntakeController;
use Illuminate\Support\Facades\Route;
use App\Models\Program;

Route::get('/', function () {
    $programs = Program::where('is_active', true)
        ->orderBy('sort_order')
        ->get();
    return view('home', compact('programs'));
});

Route::get('/apply', [ApplicationController::class, 'create'])->name('applications.create');
Route::post('/apply', [ApplicationController::class, 'store'])->name('applications.store');

Route::get('/payment/return', [ApplicationController::class, 'paymentReturn'])->name('payment.return');
Route::get('/payment/cancel', [ApplicationController::class, 'paymentCancel'])->name('payment.cancel');
Route::get('/payment/check/{reference}', [ApplicationController::class, 'paymentCheck'])->name('payment.check');
Route::get('/success', [ApplicationController::class, 'success'])->name('payment.success');
Route::get('/payment/failed', [ApplicationController::class, 'failed'])->name('payment.failed');

Route::get('/programs', function () {
    return redirect('/#programs');
});

Route::get('/programs/{slug}', function ($slug) {
    $program = Program::where('slug', $slug)->where('is_active', true)->firstOrFail();
    return view('program-details', compact('program'));
});

Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/admin/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::get('/admin/applications', [ApplicationController::class, 'index']);
    Route::get('/admin/applications/{application}', [ApplicationController::class, 'show']);
    Route::post('/admin/applications/{application}/status', [ApplicationController::class, 'updateStatus']);
    Route::post('/admin/applications/{application}/delete', [ApplicationController::class, 'destroy']);

    Route::get('/admin/programs', [ProgramController::class, 'index']);
    Route::post('/admin/programs', [ProgramController::class, 'store']);
    Route::post('/admin/programs/{program}/update', [ProgramController::class, 'update']);
    Route::post('/admin/programs/{program}/delete', [ProgramController::class, 'destroy']);

    Route::get('/admin/exam-boards', [ExamBoardController::class, 'index']);
    Route::post('/admin/exam-boards', [ExamBoardController::class, 'store']);
    Route::post('/admin/exam-boards/{board}/delete', [ExamBoardController::class, 'destroy']);

    Route::get('/admin/board-fees', [BoardFeeController::class, 'index']);
    Route::post('/admin/board-fees', [BoardFeeController::class, 'store']);
    Route::post('/admin/board-fees/{fee}/delete', [BoardFeeController::class, 'destroy']);

    Route::get('/admin/intakes', [IntakeController::class, 'index']);
    Route::post('/admin/intakes', [IntakeController::class, 'store']);
    Route::post('/admin/intakes/{intake}/delete', [IntakeController::class, 'destroy']);

    Route::post('/admin/logout', [AuthController::class, 'logout']);
});

// PayChangu Webhook (for server-to-server notifications)
Route::post('/webhook/paychangu', [App\Http\Controllers\ApplicationController::class, 'webhook'])
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);
