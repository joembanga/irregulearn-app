<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/u/{username}', [ProfileController::class, 'showPublicProfile'])->name('profile.public');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::get('/learn', function () {
        return view('learn');
    })->name('learn');

    Route::get('/practice', function () {
        $user = Auth::user();
        $user->refreshLives();

        // Groupes de verbes
        $stats = [
            'beginner' => \App\Models\Verb::where('level', 'beginner')->count(),
            'intermediate' => \App\Models\Verb::where('level', 'intermediate')->count(),
            'expert' => \App\Models\Verb::where('level', 'expert')->count(),
        ];

        // Top 3 pour la motivation
        $topThree = User::orderBy('xp_total', 'desc')->take(3)->get();

        return view('practice', compact('stats', 'topThree'));
    })->name('practice');

    Route::get('/leaderboard', function (Illuminate\Http\Request $request) {
        $user = Auth::user();
        $filter = $request->get('filter', 'global'); // 'global' par défaut
        $period = $request->get('period', 'weekly');

        $sortColumn = ($period === 'weekly') ? 'xp_weekly' : 'xp_total';

        $query = \App\Models\User::orderBy($sortColumn, 'desc');

        if ($filter === 'classmates') {
            // On récupère les IDs de ses amis acceptés
            $friendIds = DB::table('classmates')
                ->where(function ($q) use ($user) {
                    $q->where('user_id', $user->id)->orWhere('friend_id', $user->id);
                })
                ->where('status', 'accepted')
                ->get()
                ->map(function ($row) use ($user) {
                    return $row->user_id == $user->id ? $row->friend_id : $row->user_id;
                })
                ->toArray();

            // On inclut l'utilisateur lui-même dans le classement de ses amis
            $friendIds[] = $user->id;

            $query->whereIn('id', $friendIds);
        }

        $users = $query->paginate(20)->withQueryString();

        return view('leaderboard', compact('users', 'filter', 'period'));
        
    })->name('leaderboard');

    Route::get('/shop', function () {
        return view('shop');
    })->name('shop');

    Route::get('/notifications', function () {
        // On marque tout comme lu quand il ouvre la page
        auth()->user()->unreadNotifications->markAsRead();
        return view('notifications', [
            'notifications' => auth()->user()->notifications
        ]);
    })->name('notifications');

    Route::get('/u/{user:username}', [ProfileController::class, 'showPublicProfile'])->name('profile.public');

});

require __DIR__.'/auth.php';
