<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\PracticeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VerbController;
use App\Livewire\SearchPage;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/learn', function () {
        return view('learn');
    })->name('learn');

    Route::get('/learn/{category:slug}', function () {
        return view('learn');
    })->name('learn.category');

    Route::get('/practice', [PracticeController::class, 'exercises'])->name('practice');

    Route::get('/leaderboard', [LeaderboardController::class, 'load'])->name('leaderboard');

    Route::get('/shop', function () {
        return view('shop');
    })->name('shop');

    Route::get('/notifications', function () {
        Auth::user()->unreadNotifications->markAsRead();
        return view('notifications', [
            'notifications' => Auth::user()->notifications
        ]);
    })->name('notifications');

    Route::get('/u/{user:username}', [ProfileController::class, 'showPublicProfile'])->name('profile.public');

    Route::get('/verbs/{verb:slug}', [VerbController::class, 'getVerb'])->name('verb');
    
    Route::get('/verbs', [VerbController::class, 'getList'])->name('verbslist');

    Route::get('/search', function() {
        return view('search');
    })->name('search');

});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
});

require __DIR__ . '/auth.php';
