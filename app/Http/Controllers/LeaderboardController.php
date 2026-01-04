<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        $users = $query->paginate(20)->withQueryString();

        return view('leaderboard', compact('users', 'filter', 'period'));
    }
}
