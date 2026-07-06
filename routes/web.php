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

Route::get('/apply', [ApplicationController::class, 'create']);
Route::post('/apply', [ApplicationController::class, 'store']);

Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/admin/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    // Applications
    Route::get('/admin/applications', [ApplicationController::class, 'index']);
    Route::get('/admin/applications/{application}', [ApplicationController::class, 'show']);
    Route::post('/admin/applications/{application}/status', [ApplicationController::class, 'updateStatus']);
    Route::post('/admin/applications/{application}/delete', [ApplicationController::class, 'destroy']);

    // Programs
    Route::get('/admin/programs', [ProgramController::class, 'index']);
    Route::get('/admin/programs/create', [ProgramController::class, 'create']);
    Route::post('/admin/programs', [ProgramController::class, 'store']);
    Route::get('/admin/programs/{program}/edit', [ProgramController::class, 'edit']);
    Route::post('/admin/programs/{program}', [ProgramController::class, 'update']);
    Route::post('/admin/programs/{program}/delete', [ProgramController::class, 'destroy']);

    // Exam Boards
    Route::get('/admin/exam-boards', [ExamBoardController::class, 'index']);
    Route::post('/admin/exam-boards', [ExamBoardController::class, 'store']);
    Route::post('/admin/exam-boards/{board}/delete', [ExamBoardController::class, 'destroy']);

    // Board Fees
    Route::get('/admin/board-fees', [BoardFeeController::class, 'index']);
    Route::post('/admin/board-fees', [BoardFeeController::class, 'store']);
    Route::post('/admin/board-fees/{fee}/delete', [BoardFeeController::class, 'destroy']);

    // Intakes
    Route::get('/admin/intakes', [IntakeController::class, 'index']);
    Route::post('/admin/intakes', [IntakeController::class, 'store']);
    Route::post('/admin/intakes/{intake}/delete', [IntakeController::class, 'destroy']);

    Route::post('/admin/logout', [AuthController::class, 'logout']);
});
// Application Routes
Route::get('/apply', [App\Http\Controllers\ApplicationController::class, 'create'])->name('applications.create');
Route::post('/apply', [App\Http\Controllers\ApplicationController::class, 'store'])->name('applications.store');


// Application Routes
Route::get('/apply', [App\Http\Controllers\ApplicationController::class, 'create'])->name('applications.create');
Route::post('/apply', [App\Http\Controllers\ApplicationController::class, 'store'])->name('applications.store');
Route::get('/applications', [App\Http\Controllers\ApplicationController::class, 'index'])->name('applications.index');

// Payment Routes
Route::get('/payment/return', [App\Http\Controllers\ApplicationController::class, 'paymentReturn'])->name('payment.return');
Route::get('/payment/cancel', [App\Http\Controllers\ApplicationController::class, 'paymentCancel'])->name('payment.cancel');
Route::get('/success', [App\Http\Controllers\ApplicationController::class, 'success'])->name('payment.success');
Route::get('/payment/failed', [App\Http\Controllers\ApplicationController::class, 'failed'])->name('payment.failed');

// Application Routes
Route::get('/apply', [App\Http\Controllers\ApplicationController::class, 'create'])->name('applications.create');
Route::post('/apply', [App\Http\Controllers\ApplicationController::class, 'store'])->name('applications.store');
Route::get('/applications', [App\Http\Controllers\ApplicationController::class, 'index'])->name('applications.index');

// Payment Routes
Route::get('/payment/return', [App\Http\Controllers\ApplicationController::class, 'paymentReturn'])->name('payment.return');
Route::get('/payment/cancel', [App\Http\Controllers\ApplicationController::class, 'paymentCancel'])->name('payment.cancel');
Route::get('/success', [App\Http\Controllers\ApplicationController::class, 'success'])->name('payment.success');
Route::get('/payment/failed', [App\Http\Controllers\ApplicationController::class, 'failed'])->name('payment.failed');

// Auth Routes
Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
Route::get('/admin-direct', function() { 
    $user = App\Models\User::where('email', 'admin@zocods.com')->first();
    if ($user) {
        auth()->login($user);
        return redirect('/admin/applications');
    }
    return 'User not found';
});
