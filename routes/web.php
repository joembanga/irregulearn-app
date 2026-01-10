<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VerbController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LearnController;
use App\Http\Controllers\ShareController;

// Share image generation (public)
Route::get('/share/image/{type}/{identifier}', [ShareController::class, 'generate'])->name('share.image');

// Public pages: privacy and terms
Route::view('/privacy', 'privacy')->name('privacy');
Route::view('/terms', 'terms')->name('terms');
Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');

Route::middleware('guest')->get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/leaderboard', [LeaderboardController::class, 'load'])->name('leaderboard');

    //Route::get('/profile/{username}', App\Livewire\ProfilePage::class)->name('profile.public');
    Route::get('/u/{user:username}', [ProfileController::class, 'showPublicProfile'])->name('profile.public');

    Route::post('/user/timezone', [ProfileController::class, 'userTz'])->name('user.timezone');

    Route::get('/shop', function () {
        return view('shop');
    })->name('shop');

    Route::get('/notifications', function () {
        Auth::user()->unreadNotifications->markAsRead();
        return view('notifications', [
            'notifications' => Auth::user()->notifications
        ]);
    })->name('notifications');

    Route::get('/search', function () {
        return view('search');
    })->name('search');

    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('learn')->name('learn.')->group(function () {
        Route::get('/', [LearnController::class, 'index'])->name('index');
        Route::get('/daily', [LearnController::class, 'daily'])->name('daily');
        Route::get('/favorites', [LearnController::class, 'favorites'])->name('favorites');
        Route::get('/know-verbs', [LearnController::class, 'knowVerbs'])->name('know-verbs');
        Route::get('/category/{category:slug}', [LearnController::class, 'show'])->name('category');
    });

    Route::prefix('verbs')->name('verbs.')->group(function () {
        Route::get('/', [VerbController::class, 'getList'])->name('index');
        Route::get('/today', [VerbController::class, 'today'])->name('today');
        Route::get('/describe/{verb:slug}', [VerbController::class, 'getVerb'])->name('show');
        Route::get('/export', [VerbController::class, 'exportPdf'])->name('export');
        Route::get('/favorites', [VerbController::class, 'listFavs'])->name('favorites');
    });
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


require __DIR__ . '/auth.php';
