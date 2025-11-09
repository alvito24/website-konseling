<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KonselingController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/dashboard');
    }
    return redirect('/login');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', UserController::class);
});

// Counseling Routes
Route::prefix('konseling')->name('konseling.')->middleware(['auth'])->group(function () {
    Route::post('/{konseling}/accept', [KonselingController::class, 'accept'])->name('accept');
    Route::post('/{konseling}/reject', [KonselingController::class, 'reject'])->name('reject');
});

// Chat Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::post('/chat/create', [ChatController::class, 'create'])->name('chat.create');
    Route::get('/chat/{chatRoom}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/{chatRoom}/message', [ChatController::class, 'store'])->name('chat.store');
    Route::get('/chat/message/{message}/download', [ChatController::class, 'download'])->name('chat.download');
});

// Report Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/show', [ReportController::class, 'show'])->name('reports.show');
    Route::post('/reports/export', [ReportController::class, 'export'])->name('reports.export');
});

// Konseling Routes
Route::middleware(['auth'])->group(function () {
    Route::resource('konseling', KonselingController::class);
    
    // Additional Konseling Routes
    Route::post('/konseling/{konseling}/approve', [KonselingController::class, 'approve'])
        ->name('konseling.approve');
    Route::post('/konseling/{konseling}/complete', [KonselingController::class, 'complete'])
        ->name('konseling.complete');
});

// INI HALAMAN KHUSUS USER YANG UDAH LOGIN
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';