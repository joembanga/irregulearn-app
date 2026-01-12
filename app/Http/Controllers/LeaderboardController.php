<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class LeaderboardController extends Controller
{
    public function load(Request $request)
    {
        $user = Auth::user();
        $filter = $request->input('filter', 'global');
        $period = $request->input('period', 'weekly');

        $sortColumn = ($period === 'weekly') ? 'xp_weekly' : 'xp_total';

        $query = User::orderBy($sortColumn, 'desc');

        if ($filter === 'friends') {
            // Get friend IDs using the User model relationship
            $friendIds = $user->friends()->pluck('id');

            // Add current user to the list
            $friendIds->push($user->id);

            $query->whereIn('id', $friendIds);
        }

        $cacheKey = "leaderboard_{$filter}_{$period}_page_" . ($request->input('page', 1));

        $data = Cache::remember($cacheKey, now()->addMinutes(10), function () use ($query) {
            return [
                'top3' => (clone $query)->limit(3)->get(),
                'users' => $query->paginate(20)
            ];
        });

        $top3 = $data['top3'];
        $users = $data['users']->withQueryString();

        return view('leaderboard', compact('users', 'filter', 'period', 'top3'));
    }
}
