<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\KonselingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Konseling Routes
Route::middleware(['auth', 'is.verified'])->group(function () {
    Route::resource('konseling', KonselingController::class);
    Route::post('konseling/{konseling}/accept', [KonselingController::class, 'accept'])->name('konseling.accept');
    Route::post('konseling/{konseling}/reject', [KonselingController::class, 'reject'])->name('konseling.reject');
    Route::post('konseling/{konseling}/approve', [KonselingController::class, 'approve'])->name('konseling.approve');
    Route::post('konseling/{konseling}/complete', [KonselingController::class, 'complete'])->name('konseling.complete');
});

// Journal Routes
Route::middleware(['auth', 'is.verified'])->group(function () {
    Route::get('/journal', [JournalController::class, 'index'])->name('journal.index');
    Route::post('/journal', [JournalController::class, 'store'])->name('journal.store');
    Route::get('/journal/{id}/decrypt', [JournalController::class, 'decrypt'])->name('journal.decrypt');
});

// Chat Routes
Route::middleware(['auth', 'is.verified'])->group(function () {
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/{chatRoom}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/{chatRoom}', [ChatController::class, 'store'])->name('chat.store');
    Route::get('/chat/{message}/download', [ChatController::class, 'download'])->name('chat.download');
    Route::post('/chat/create', [ChatController::class, 'create'])->name('chat.create');
});

// Admin Routes
Route::middleware(['auth', 'is.verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::middleware('role:admin')->group(function () {
        Route::get('/pending-users', [AdminController::class, 'pendingUsers'])->name('pending-users');
        Route::post('/users/{user}/verify', [AdminController::class, 'verifyUser'])->name('users.verify');
        Route::post('/users/{user}/reject', [AdminController::class, 'rejectUser'])->name('users.reject');

        // User Management
        Route::resource('users', UserController::class);
    });
});

// Reports Routes
Route::middleware(['auth', 'is.verified'])->prefix('reports')->name('reports.')->group(function () {
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/show', [ReportController::class, 'show'])->name('show');
        Route::get('/export', [ReportController::class, 'export'])->name('export');
    });
    Route::middleware(['role:guru_bk'])->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/show', [ReportController::class, 'show'])->name('show');
        Route::get('/export', [ReportController::class, 'export'])->name('export');
    });
});

require __DIR__.'/auth.php';
