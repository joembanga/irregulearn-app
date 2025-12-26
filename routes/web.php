<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VerbController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LearnController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/learn', [LearnController::class, 'index'])->name('learn');

    Route::get('/learn/{category:slug}', [LearnController::class, 'show'])->name('learn.category');

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
