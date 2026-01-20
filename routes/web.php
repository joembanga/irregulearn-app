<?php

use App\Http\Controllers\{
    AdminController,
    DashboardController,
    LeaderboardController,
    LearnController,
    ProfileController,
    ShareController,
    SocialController,
    VerbController,
};
use App\Models\Verb;
use Illuminate\Support\Facades\Route;

// Redirection racine
Route::get('/', function () {
    return redirect('/'. session('locale', config('app.locale', 'en')));
});

Route::prefix('{locale}')->middleware('setLocale')->group(
    function () {
        // Public pages: privacy and terms
        Route::view('/privacy', 'privacy')->name('privacy');
        Route::view('/terms', 'terms')->name('terms');
        Route::view('/about', 'about')->name('about');
        Route::view('/contact', 'contact')->name('contact');

        Route::middleware('guest')->get('/', function () {
            return view('welcome');
        })->name('welcome');

        Route::middleware(['auth', 'verified'])->group(function () {

            Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

            Route::get('/leaderboard', [LeaderboardController::class, 'load'])->name('leaderboard');

            Route::get('/u/{user:username}', [ProfileController::class, 'showPublicProfile'])->name('profile.public');

            Route::post('/user/timezone', [ProfileController::class, 'userTz'])->name('user.timezone');

            Route::get('/shop', function () {
                return view('shop');
            })->name('shop');



            Route::get('/search', function () {
                return view('search');
            })->name('search');

            Route::get('/grambuds', [SocialController::class, 'grambuds'])->name('grambuds');
            Route::get('/sentences', [SocialController::class, 'sentences'])->name('sentences');

            Route::prefix('profile')->name('profile.')->group(function () {
                Route::get('/', [ProfileController::class, 'edit'])->name('edit');
                Route::patch('/', [ProfileController::class, 'update'])->name('update');
                Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
            });

            Route::prefix('learn')->name('learn.')->group(function () {
                Route::get('/', [LearnController::class, 'index'])->name('index');
                Route::get('/session', [LearnController::class, 'startSession'])->name('session');
                Route::get('/custom', [LearnController::class, 'custom'])->name('custom');
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
            Route::get('/verbs/{verb}/edit', function (Verb $verb) {
                return view('admin.verbs.edit', ['verb' => $verb]);
            })->name('verbs.edit');

            Route::view('/users', 'admin.users.index')->name('users.index');
            Route::view('/reports', 'admin.reports.index')->name('reports.index');
        });
    }
);

// Share image generation (public)
Route::get('/share/image/{type}/{identifier}', [ShareController::class, 'generate'])->name('share.image');

require __DIR__.'/auth.php';
