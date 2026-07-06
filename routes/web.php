<?php

use App\Http\Controllers\AssessmentSessionController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RiskAssessmentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // PDF Generation Route
    Route::get('/assessment_sessions/{assessment_session}/pdf', [AssessmentSessionController::class, 'downloadPdf'])
        ->name('assessment_sessions.pdf');

    Route::resource('assets', AssetController::class);
    Route::resource('assessment_sessions', AssessmentSessionController::class);
    Route::resource('risk_assessments', RiskAssessmentController::class);
    
    // AJAX endpoint to get assets by session
    Route::get('/api/sessions/{session}/assets', [RiskAssessmentController::class, 'getAssetsBySession'])
        ->name('api.sessions.assets');

    Route::resource('users', UserController::class);
    
    // Toggle user status
    Route::patch('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])
        ->name('users.toggleStatus');

    Route::get('/audit-logs', [AuditLogController::class, 'index'])->name('audit_logs.index');
});

require __DIR__ . '/auth.php';
