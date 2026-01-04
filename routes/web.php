<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VerbController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LearnController;

Route::middleware('guest')->get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/learn', [LearnController::class, 'index'])->name('learn');
    Route::get('/learn/daily', [LearnController::class, 'daily'])->name('learn.daily');
    Route::get('/learn/category/{category:slug}', [LearnController::class, 'show'])->name('learn.category');

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

    //Route::get('/profile/{username}', App\Livewire\ProfilePage::class)->name('profile.public');
    Route::get('/u/{user:username}', [ProfileController::class, 'showPublicProfile'])->name('profile.public');

    Route::get('/verbs', [VerbController::class, 'getList'])->name('verbslist');
    Route::get('/verbs/{verb:slug}', [VerbController::class, 'getVerb'])->name('verb');
    Route::get('/export', [VerbController::class, 'exportPdf'])->name('verbs.export');

    Route::get('/search', function () {
        return view('search');
    })->name('search');

    Route::get('/favorites', [VerbController::class, 'listFavs'])->name('favorites');

    Route::post('/user/timezone', [ProfileController::class, 'userTz'])->name('user.timezone');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Management Routes (We'll use standard controllers wrapping Livewire or direct Livewire routes)
    // For now, let's stick to standard routes that return views containing Livewire components
    Route::view('/verbs', 'admin.verbs.index')->name('verbs.index');
    Route::view('/verbs/create', 'admin.verbs.create')->name('verbs.create');
    Route::get('/verbs/{verb}/edit', function (App\Models\Verb $verb) {
        return view('admin.verbs.edit', ['verb' => $verb]);
    })->name('verbs.edit');

    Route::view('/users', 'admin.users.index')->name('users.index');
    Route::view('/reports', 'admin.reports.index')->name('reports.index');
});

// Public pages: privacy and terms
Route::view('/privacy', 'privacy')->name('privacy');
Route::view('/terms', 'terms')->name('terms');
Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');

require __DIR__ . '/auth.php';
